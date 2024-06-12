<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleHttpClient;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\Kasir;
use App\Models\Tenant;
use Exception;

class LoginController extends Controller {
    public function login(Request $request) {
        if (! Auth::guard('tenant')->attempt($request->only('email', 'password'))) {
            if (! Auth::guard('kasir')->attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $kasir = Kasir::where('email', $request->email)->firstOrFail();

            $token = $kasir->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login success',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'data' => array(
                    'sup_user_id'           => $kasir->id,
                    'sup_user_name'         => $kasir->name,
                    'sup_user_company'      => $kasir->id_tenant,
                    'sup_user_email'        => $kasir->email,
                    'sup_user_type'         => 'kasir',
                    'sup_user_token'        => $token
                ),
                'status' => 200
            ]);
        }

        $tenant = Tenant::where('email', $request->email)->firstOrFail();

        if($tenant->id_inv_code != 0) {

            $token = $tenant->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login success',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'data' => array(
                    'sup_user_id'           => $tenant->id,
                    'sup_user_name'         => $tenant->name,
                    'sup_user_referal_code' => $tenant->id_inv_code,
                    'sup_user_company'      => null,
                    'sup_user_email'        => $tenant->email,
                    'sup_email_verification' => $tenant->email_verified_at,
                    'sup_phone_verification' => $tenant->phone_number_verified_at,
                    'sup_user_type'         => 'owner',
                    'sup_user_token'        => $token
                ),
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401
            ]);
        }
    }

    public function user(){
        $user = Auth::user();
        return response()->json(['data' => $user]);
    }

    public function checkUser(Request $request) : JsonResponse {
        $user = "";
        $phone = $request->phone;

        $checkTenant = Tenant::select([
                                'tenants.id',
                                'tenants.phone',
                                'tenants.name',
                                'tenants.is_active',
                                'id_inv_code'
                            ])
                            ->with([
                                'detail' => function($query){
                                    $query->select([
                                        'detail_tenants.id',
                                        'detail_tenants.id_tenant',
                                        'detail_tenants.photo'
                                    ]);
                                }
                            ])
                            ->where('phone', $phone)
                            ->first();
        $checkKasir = Kasir::select([
                                'kasirs.id',
                                'kasirs.phone',
                                'kasirs.name',
                                'kasirs.is_active'
                            ])
                            ->with([
                                'detail' => function($query){
                                    $query->select([
                                        'detail_kasirs.id',
                                        'detail_kasirs.id_kasir',
                                        'detail_kasirs.photo'
                                    ]);
                                }
                            ])
                            ->where('phone', $phone)
                            ->first();

        if($checkTenant){
            $user = $checkTenant;
            if($checkTenant->id_inv_code != 0){
                $userType = "Tenant";
                return response()->json([
                    'message' => 'User Found',
                    'user-type' => $userType,
                    'user' => $user,
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'User tidak terdaftar pada sistem kami',
                    'status' => 404
                ]);
            }
        } else if($checkKasir){
            $user = $checkKasir;
            $userType = "Kasir";
            return response()->json([
                'message' => 'User Found',
                'user-type' => $userType,
                'user' => $user,
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'User tidak terdaftar pada sistem kami',
                'status' => 404
            ]);
        }
    }

    public function sendOTPResetPaass(Request $request) : JsonResponse {
        $api_key    = getenv("WHATZAPP_API_KEY");
        $sender  = getenv("WHATZAPP_PHONE_NUMBER");
        $client = new GuzzleHttpClient();
        $nohp = $request->phone;
        $hp = "";
        $postResponse = "";
        $otp = (new Otp)->generate($nohp, 'numeric', 6, 30);
        $body = "Berikut adalah kode OTP untuk reset password Visioner anda : "."*".$otp->token."*"."\n\n\n"."*Harap berhati-hati dan jangan membagikan kode OTP pada pihak manapun!, Admin dan Tim dari Visioner POS tidak akan pernah meminta OTP kepada User!*";
        if(!preg_match("/[^+0-9]/",trim($nohp))){
            if(substr(trim($nohp), 0, 2)=="62"){
                $hp    =trim($nohp);
            }
            else if(substr(trim($nohp), 0, 1)=="0"){
                $hp    ="62".substr(trim($nohp), 1);
            }
        }
        $url = 'https://waq.my.id/send-message';
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $data = [
            'api_key' => $api_key,
            'sender' => $sender,
            'number' => $hp,
            'message' => $body
        ];
        try {
            $postResponse = $client->post($url, [
                'headers' => $headers,
                'json' => $data,
            ]);
        } catch(Exception $ex){
            return response()->json([
                'message' => 'OTP Error, pastikan nomor anda terdaftar di aplikasi Whatsapp!',
                'status' => 500
            ]);
        }
        $responseCode = $postResponse->getStatusCode();

        if($responseCode == 200){
            return response()->json([
                'message' => 'OTP Sent!',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'OTP Error, pastikan nomor anda terdaftar di aplikasi Whatsapp!',
                'status' => 500
            ]);
        }
    }

    public function verifyOTPReset(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'otp' => 'required|numeric',
            'password' => 'required|confirmed|min:8',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error!',
                'validation' => $validator,
                'status' => 400
            ]);
        }

        $kode = (int) $request->otp;
        $phone = $request->phone;
        $password = $request->password;
        $otp = (new Otp)->validate($phone, $kode);
        if(!$otp->status){
            return response()->json([
                'message' => 'OTP salah atau tidak sesuai!',
                'status' => 401
            ]);
        } else {
            $checkTenant = Tenant::where('phone', $phone)->first();
            $checkKasir = Kasir::where('phone', $phone)->first();

            if($checkTenant){
                $checkTenant->update([
                    'password' => Hash::make($password)
                ]);
                return response()->json([
                    'message' => 'Password diperbarui!',
                    'status' => 200
                ]);
            } else if($checkKasir){
                $checkKasir->update([
                    'password' => Hash::make($password)
                ]);
                return response()->json([
                    'message' => 'Password diperbarui!',
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'User not found, password change failed!',
                    'status' => 500
                ]);
            }
        }
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success',
            'status' => 200
        ]);
    }
}
