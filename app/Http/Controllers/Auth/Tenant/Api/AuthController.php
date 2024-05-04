<?php

namespace App\Http\Controllers\Auth\Tenant\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Admin;
use App\Models\Marketing;
use App\Models\Tenant;
use App\Models\Kasir;
use App\Models\DetailAdmin;
use App\Models\DetailMarketing;
use App\Models\DetailTenant;
use App\Models\DetailKasir;
use App\Models\InvitationCode;
use App\Models\StoreDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Ichtrojan\Otp\Otp;
use GuzzleHttp\Client as GuzzleHttpClient;
use Exception;

class AuthController extends Controller {
    
    public function register(Request $request) {
        //EDIT DISINI
        // $validator = Validator::make($request->all(), [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
        //     'no_ktp' => ['required', 'string', 'numeric', 'digits:16', 'unique:'.DetailAdmin::class, 'unique:'.DetailMarketing::class, 'unique:'.DetailTenant::class, 'unique:'.DetailKasir::class],
        //     'phone' => ['required', 'string', 'numeric', 'digits_between:1,20', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
        //     'jenis_kelamin' => ['required'],
        //     'tempat_lahir' => ['required'],
        //     'tanggal_lahir' => ['required'],
        //     'alamat' => ['required', 'string', 'max:255'],
        //     'password' => ['required', 'confirmed', 'min:8'],
        //     'inv_code' => ['required', Rule::exists('invitation_codes')->where(function ($query) {
        //                     return $query->where('inv_code', request()->get('inv_code'));
        //                 })],
        // ]);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'phone' => ['required', 'string', 'numeric', 'digits_between:1,20', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'password' => ['required', 'min:8'],
            'inv_code' => ['required', Rule::exists('invitation_codes')->where(function ($query) {
                            return $query->where('inv_code', request()->get('inv_code'));
                        })],
            // 'no_ktp' => ['required', 'string', 'numeric', 'digits:16', 'unique:'.DetailAdmin::class, 'unique:'.DetailMarketing::class, 'unique:'.DetailTenant::class, 'unique:'.DetailKasir::class],
            // 'jenis_kelamin' => ['required'],
            // 'tempat_lahir' => ['required'],
            // 'tanggal_lahir' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $invitationcodeid = InvitationCode::where('inv_code', $request->inv_code)->first();

        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'id_inv_code' => $invitationcodeid->id
        ]);

        if(!is_null($tenant)) {
            $tenant->detailTenantStore($tenant);
            $tenant->storeInsert($tenant);
        }

        event(new Registered($tenant));

        $token = $tenant->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $tenant,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => array(
                'sup_user_id'           => $tenant->id,
                'sup_user_name'         => $tenant->name,
                'sup_user_referal_code' => $invitationcodeid->id,
                'sup_user_email'        => $request->email,
                'sup_email_verification' => $tenant->email_verified_at,
                'sup_phone_verification' => $tenant->phone_number_verified_at,
                'sup_user_token'        => $token,
            ),
        ]);
        //EDIT DISINI
    }

    public function login(Request $request) {
        if (! Auth::guard('tenant')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $tenant = Tenant::where('email', $request->email)->firstOrFail();

        //EDIT DISINI

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
        ]);

        //EDIT DISINI
    }

    public function sendMailOTP(Request $request){
        try {
            auth()->user()->sendEmailVerificationNotification();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to send Email!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        return response()->json([
            'message' => 'Email Sent!',
            'status' => 200
        ]);
    }

    public function verifyMailOTP(Request $request){
        if(!empty(auth()->user()->email_verified_at) || !is_null(auth()->user()->email_verified_at) || auth()->user()->email_verified_at != NULL || auth()->user()->email_verified_at != "") {
            return response()->json([
                'message' => 'Your Email has been verified!',
                'status' => 200
            ]);
        } else {
            $kode = (int) $request->kode_otp;
            $otp = (new Otp)->validate(auth()->user()->email, $kode);
            if(!$otp->status){
                return response()->json([
                    'message' => 'OTP salah atau tidak sesuai!',
                    'status' => 200
                ]);
            } else {
                $user = Tenant::where('email', auth()->user()->email)->first();
                $user->markEmailAsVerified();
                return response()->json([
                    'message' => 'Verifikasi OTP Email Berhasil!',
                    'data' => array(
                        'sup_email_verification' => auth()->user()->email_verified_at,
                    ),
                    'status' => 200
                ]);
            }
        }
    }

    public function sendWhatsappOTP(Request $request){
        try {
            $api_key    = getenv("WHATZAPP_API_KEY");
            $sender  = getenv("WHATZAPP_PHONE_NUMBER");
            $client = new GuzzleHttpClient();
            $nohp = auth()->user()->phone;
            $hp = "";
            $postResponse = "";
            $otp = (new Otp)->generate(auth()->user()->phone, 'numeric', 6, 5);
            $body = "Berikut adalah kode OTP untuk akun Visioner POS anda : "."*".$otp->token."*"."\n\n\n"."*Harap berhati-hati dan jangan membagikan kode OTP pada pihak manapun!, Admin dan Tim dari Visioner POS tidak akan pernah meminta OTP kepada User!*";
            if(!preg_match("/[^+0-9]/",trim($nohp))){
                if(substr(trim($nohp), 0, 2)=="62"){
                    $hp    =trim($nohp);
                }
                else if(substr(trim($nohp), 0, 1)=="0"){
                    $hp    ="62".substr(trim($nohp), 1);
                }
            }
            $url = 'https://whatzapp.my.id/send-message';
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
                return $ex;
            }
            $responseCode = $postResponse->getStatusCode();
            
            if($responseCode == 200){
                return response()->json([
                    'message' => 'OTP Sent!',
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'OTP Send Failed!',
                    'status' => 200
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to send Whatsapp OTP!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
    }

    public function verifyWhatsappOTP(Request $request){
        if(!empty(auth()->user()->phone_number_verified_at) || !is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at != NULL || auth()->user()->phone_number_verified_at != "") {
            return response()->json([
                'message' => 'Your Whatsapp Number has been verified!',
                'status' => 200
            ]);
        } else {
            $kode = (int) $request->otp;
            $otp = (new Otp)->validate(auth()->user()->phone, $kode);
            if(!$otp->status){
                return response()->json([
                    'message' => 'OTP salah atau tidak sesuai!',
                    'status' => 200
                ]);
            } else {
                $user = Tenant::find(auth()->user()->id);
                $user->update([
                    'phone_number_verified_at' => now()
                ]);
                return response()->json([
                    'message' => 'Verifikasi OTP Whatsapp Berhasil!',
                    'data' => array(
                        'sup_email_verification' => auth()->user()->email_verified_at,
                    ),
                    'status' => 200
                ]);
            }
        }
    }

    public function user(){
        $user = Auth::user();
        return response()->json(['data' => $user]);
    }

    public function userDetail(Request $request) : JsonResponse {
        $user = "";
        // $id = $request->id;
        try {
            // $user = Tenant::select('id')
            //                 ->with([
            //                 'detail' => function(Builder $query){
            //                     $query->select(
            //                         'detail_tenants.id as detail_id',
            //                         'detail_tenants.id_tenant as id_detail_tenant',
            //                         'no_ktp',
            //                         'tempat_lahir',
            //                         'tanggal_lahir',
            //                         'jenis_kelamin',
            //                         'detail_tenants.alamat as alamat_tenant',
            //                         'detail_tenants.photo as tenant_photo_profile'
            //                     );
            //                 }, 
            //                 'storeDetail' => function(Builder $query){
            //                     $query->select(
            //                         'store_details.id as store_detail_id',
            //                         'store_details.id_tenant as id_store_detail_tenant',
            //                         'store_details.name as nama_toko',
            //                         'store_details.alamat as alamat_toko',
            //                         'store_details.no_telp_toko as no_telp_toko',
            //                         'jenis_usaha',
            //                         'status_umi',
            //                         'catatan_kaki',
            //                         'store_details.photo as photo_toko'
            //                     );
            //                 }
            //                 ])
            //                 ->where('id', Auth::user()->id)
            //                 ->firstOrFail();
            $user = Tenant::with(['detail', 'storeDetail'])
                                ->whereHas('detail', function($q) {
                                    $q->select(
                                        'detail_tenants.id as detail_id',
                                        'detail_tenants.id_tenant as id_detail_tenant',
                                        'no_ktp',
                                        'tempat_lahir',
                                        'tanggal_lahir',
                                        'jenis_kelamin',
                                        'detail_tenants.alamat as alamat_tenant',
                                        'detail_tenants.photo as tenant_photo_profile'
                                    );
                                })
                                ->whereHas('storeDetail', function($q) {
                                    $q->select(
                                        'store_details.id as store_detail_id',
                                        'store_details.id_tenant as id_store_detail_tenant',
                                        'store_details.name as nama_toko',
                                        'store_details.alamat as alamat_toko',
                                        'store_details.no_telp_toko as no_telp_toko',
                                        'jenis_usaha',
                                        'status_umi',
                                        'catatan_kaki',
                                        'store_details.photo as photo_toko'
                                    );
                                })
                                ->where('id', Auth::user()->id)
                                ->firstOrFail();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        return response()->json([
            'message' => 'Fetch Success',
            'data-detail-user' => $user,
            'status' => 200
        ]);
    }

    public function userUpdate(Request $request) : JsonResponse {
        $name = $request->name;
        $password = $request->password;
        $tenant = "";
        try {
            $tenant = Tenant::with('detail')->where('id', Auth::user()->id)->firstOrFail();// ->where('id', $id)->firstOrFail();
            if($password == null || $password == ''){
                $tenant->update(['name' => $name,]);
            }else{
                $tenant->update(['name' => $name,'password' => Hash::make($password),]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        return response()->json(['message' => 'Update Success',]);
    }

    public function userUpdateStore(Request $request) : JsonResponse {
        $nama_toko = $request->nama_toko;
        $alamat_toko = $request->alamat_toko;
        $catatan_kaki_toko = $request->catatan_kaki_toko;
        $phone_toko = $request->phone_toko;
        $tenant = "";
        $store_detail = "";
        try {
            //$tenant = Tenant::with('detail')->where('id', Auth::user()->id)->firstOrFail();// ->where('id', $id)->firstOrFail();
            $store_detail = StoreDetail::where('id_tenant', auth()->user()->id)->firstOrFail();// ->where('id', $id)->firstOrFail();
            $store_detail->update([
                'name' => $nama_toko,
                'alamat' => $alamat_toko,
                'catatan_kaki' => $catatan_kaki_toko,
                'no_telp_toko' => $phone_toko,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        return response()->json(['message' => 'Update Success',]);
    }

    public function csInfo() : JsonResponse {
        try {
            $cs = InvitationCode::with('marketing')
                                ->select([
                                    'invitation_codes.id as inv_id',
                                    'invitation_codes.id_marketing',
                                    'invitation_codes.inv_code as code'
                                ])
                                ->where('id', Auth::user()->id_inv_code)
                                ->firstOrFail();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        return response()->json([
            'message' => 'Fetch Success',
            'data-cs' => $cs,
            'status' => 200
        ]);
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}