<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleHttpClient;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use App\Models\Kasir;
use App\Models\Tenant;
use App\Models\StoreDetail;
use App\Models\AppVersion;
use App\Models\History;
use Exception;

class LoginController extends Controller {

    private function getAppversion(){
        $appVersion = AppVersion::find(1);
        return $appVersion->versi;
    }

    private function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    private function createHistoryUser($user_id,  $user_email, $action, $log, $status){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $ip, $log, $status);
        }
    }

    public function sendWhatsappLoginNotification($user_id, $user_email, $noHP, $action, $body){
        DB::connection()->enableQueryLog();
        $api_key    = getenv("WHATZAPP_API_KEY");
        $sender  = getenv("WHATZAPP_PHONE_NUMBER");
        $client = new GuzzleHttpClient();
        $postResponse = "";
        $action = "";
        if(!preg_match("/[^+0-9]/",trim($noHP))){
            if(substr(trim($noHP), 0, 2)=="62"){
                $hp    =trim($noHP);
            }
            else if(substr(trim($noHP), 0, 1)=="0"){
                $hp    ="62".substr(trim($noHP), 1);
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
            $action = "Send User Login Notification Fail";
            $this->createHistoryUser($user_id, $user_email, $action, $ex, 0);
        }
        if(is_null($postResponse) || empty($postResponse) || $postResponse == NULL || $postResponse == ""){
            $this->createHistoryUser($user_id, $user_email, $action, "Send User Login Notification Fail", 0);
        } else {
            $responseCode = $postResponse->getStatusCode();
            if($responseCode == 200){
                $action = "Send User Login Notification Success";
                $this->createHistoryUser($user_id, $user_email, $action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            } else {
                $action = "Send User Login Notification Fail";
                $this->createHistoryUser($user_id, $user_email, $action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
            }
        }
    }

    public function login(Request $request) {
        $date = Carbon::now()->format('d-m-Y H:i:s');
        DB::connection()->enableQueryLog();
        if (! Auth::guard('tenant')->attempt($request->only('email', 'password'))) {
            if (! Auth::guard('kasir')->attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $kasir = Kasir::where('email', $request->email)->firstOrFail();

            if($kasir->is_active == 0){
                return response()->json([
                    'message' => 'Akun telah dinonaktifkan oleh admin!',
                    'login' => 'Failed',
                    'status' => 401
                ]);
            }

            $storeDetail = StoreDetail::select([
                                            'store_details.id',
                                            'store_details.store_identifier',
                                            'store_details.id_tenant',
                                        ])
                                        ->with([
                                            'tenant' => function($query){
                                                $query->select([
                                                    'tenants.id',
                                                    'tenants.is_active'
                                                ]);
                                            }
                                        ])
                                        ->where('store_identifier', $kasir->id_store)
                                        ->first();

            if($storeDetail->tenant->is_active == 2) {
                return response()->json([
                    'message' => 'Login gagal, toko telah dinonaktifkan oleh admin!',
                    'login' => 'Failed',
                    'status' => 401
                ]);
            }

            $token = $kasir->createToken('auth_token')->plainTextToken;
            $action = "Login User Kasir Using Application";
            $login_id = NULL;
            $login_email = $request->email;
            $this->createHistoryUser($login_id, $login_email, $action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $id = $kasir->id;
            $email = $kasir->email;
            $noHp = $kasir->phone;
            $body = "Anda berhasil melakukan login sebagai Kasir melalui aplikasi android pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            $this->sendWhatsappLoginNotification($id, $email, $noHp, $action, $body);
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
                    'sup_user_token'        => $token,
                    'app-version'           => $this->getAppversion()
                ),
                'status' => 200
            ]);
        }

        $tenant = Tenant::where('email', $request->email)->firstOrFail();

        if($tenant->id_inv_code != 0) {

            if($tenant->is_active == 0){
                return response()->json([
                    'message' => 'Akun telah dinonaktifkan oleh admin!',
                    'status' => 401
                ]);
            }

            $token = $tenant->createToken('auth_token')->plainTextToken;
            $action = "Login User Mitra Tenant Using Application";
            $login_id = NULL;
            $login_email = $request->email;
            $this->createHistoryUser($login_id, $login_email, $action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $id = $tenant->id;
            $email = $tenant->email;
            $noHp = $tenant->phone;
            $body = "Anda berhasil melakukan login sebagai Mitra Tenant melalui aplikasi android pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            $this->sendWhatsappLoginNotification($id, $email, $noHp, $action, $body);
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
                    'sup_user_token'        => $token,
                    'app-version'           => $this->getAppversion()
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
                    'status' => 200,
                    'app-version' => $this->getAppversion()
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
                'status' => 200,
                'app-version' => $this->getAppversion()
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
                'status' => 200,
                'app-version' => $this->getAppversion()
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
                    'status' => 200,
                    'app-version' => $this->getAppversion()
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
