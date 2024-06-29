<?php

namespace App\Http\Controllers\Auth\Tenant\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Marketing;
use App\Models\Tenant;
use App\Models\Kasir;
use App\Models\DetailAdmin;
use App\Models\DetailMarketing;
use App\Models\DetailTenant;
use App\Models\DetailKasir;
use App\Models\InvitationCode;
use App\Models\Rekening;
use App\Models\StoreDetail;
use App\Models\QrisWallet;
use App\Models\AgregateWallet;
use App\Models\Withdrawal;
use App\Models\DetailPenarikan;
use App\Models\NobuWithdrawFeeHistory;
use App\Models\AppVersion;
use App\Models\BiayaAdminTransferDana;
use App\Models\RekeningWithdraw;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Ichtrojan\Otp\Otp;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleHttpClient;
use Exception;

class AuthController extends Controller {

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

    private function createHistoryUser($action, $log, $status){
        $user_id = auth()->user()->id;
        $user_email = auth()->user()->email;
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

    private function sendNotificationToUser($body){
        $api_key    = getenv("WHATZAPP_API_KEY");
        $sender  = getenv("WHATZAPP_PHONE_NUMBER");
        $client = new GuzzleHttpClient();
        $postResponse = "";
        $noHP = auth()->user()->phone;
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
            $action = "Send Whatsapp Notification Fail";
            $this->createHistoryUser($action, $ex, 0);
        }
        $responseCode = $postResponse->getStatusCode();
        if($responseCode != 200){
            $action = "Send Whatsapp Notification Fail";
            $this->createHistoryUser($action, $ex, 0);
        } 
    }

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
                'sup_user_id'            => $tenant->id,
                'sup_user_name'          => $tenant->name,
                'sup_user_referal_code'  => $invitationcodeid->id,
                'sup_user_email'         => $request->email,
                'sup_email_verification' => $tenant->email_verified_at,
                'sup_phone_verification' => $tenant->phone_number_verified_at,
                'sup_user_token'         => $token,
                'app-version'            => $this->getAppversion()
            ),
            'status' => 200
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
                'sup_user_id'            => $tenant->id,
                'sup_user_name'          => $tenant->name,
                'sup_user_referal_code'  => $tenant->id_inv_code,
                'sup_user_company'       => null,
                'sup_user_email'         => $tenant->email,
                'sup_email_verification' => $tenant->email_verified_at,
                'sup_phone_verification' => $tenant->phone_number_verified_at,
                'sup_user_type'          => 'owner',
                'sup_user_token'         => $token,
                'app-version'            => $this->getAppversion()
            ),
            'status' => 200
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
            'status' => 200,
            'app-version' => $this->getAppversion()
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
                    'status' => 200,
                    'app-version' => $this->getAppversion()
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
                // return response()->json([
                //     'message' => $$postResponse,
                //     'status' => "testing",
                //     'app-version' => $this->getAppversion()
                // ]);
            } catch(Exception $ex){
                return response()->json([
                    'message' => $ex,
                    'status' => "testing walla",
                    'app-version' => $this->getAppversion()
                ]);
                return $ex;
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
                    'message' => 'OTP Send Failed!',
                    'status' => 500,
                    'app-version' => $this->getAppversion()
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to send Whatsapp OTP!',
                'error-message' => $e->getMessage(),
                'status' => 500,
                'app-version' => $this->getAppversion()
            ]);
            exit;
        }
    }

    public function verifyWhatsappOTP(Request $request){
        if(!empty(auth()->user()->phone_number_verified_at) || !is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at != NULL || auth()->user()->phone_number_verified_at != "") {
            return response()->json([
                'message' => 'Your Whatsapp Number has been verified!',
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $kode = (int) $request->kode_otp;
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
                        'sup_phone_verification' => auth()->user()->phone_number_verified_at,
                    ),
                    'status' => 200,
                    'app-version' => $this->getAppversion()
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
        try {
            $user = Tenant::select(['tenants.id','tenants.name', 'tenants.email as mail', 'tenants.phone', 'tenants.email_verified_at', 'tenants.phone_number_verified_at', 'tenants.is_active'])
                            ->with(['detail' => function($query){
                                    $query->select(['detail_tenants.id',
                                                    'detail_tenants.id_tenant',
                                                    'detail_tenants.no_ktp',
                                                    'detail_tenants.tempat_lahir',
                                                    'detail_tenants.tanggal_lahir',
                                                    'detail_tenants.jenis_kelamin',
                                                    'detail_tenants.alamat',
                                                    'detail_tenants.photo',
                                    ])
                                    ->where('id_tenant', Auth::user()->id)
                                    ->where('email', Auth::user()->email)
                                    ->first();
                            },
                            'storeDetail' => function($query){
                                $query->select([
                                    'store_details.id',
                                    'store_details.store_identifier',
                                    'store_details.id_tenant',
                                    'store_details.email',
                                    'store_details.name',
                                    'store_details.alamat',
                                    'store_details.kabupaten',
                                    'store_details.kode_pos',
                                    'store_details.no_telp_toko',
                                    'store_details.jenis_usaha',
                                    'store_details.status_umi',
                                    'store_details.catatan_kaki',
                                    'store_details.photo',
                                ])
                                ->where('id_tenant', Auth::user()->id)
                                ->where('email', Auth::user()->email)
                                ->first();
                            }])
                            ->where('id', Auth::user()->id)
                            ->where('email', Auth::user()->email)
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
            'sup_email_verification' => $user->email_verified_at,
            'sup_phone_verification' => $user->phone_number_verified_at,
            'status' => 200,
            'app-version' => $this->getAppversion()
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
        return response()->json(['message' => 'Update Success', 'status' => 200, 'app-version' => $this->getAppversion()]);
    }

    public function userUpdatePassword(Request $request) : JsonResponse {
        DB::connection()->enableQueryLog();
        $rules = [
            'otp' => 'required|numeric',
            'password' => 'required|confirmed|min:8',
            'old_password' => 'required|min:8'
        ];
    
        $customMessages = [
            'required' => 'Inputan tidak boleh kosong!',
            'confirmed' => 'Konfirmasi password tidak sesuai'
        ];
    
        $validator = $this->validate($request, $rules, $customMessages);

        if($validator){
            $password = $request->password;
            $old_password = $request->old_password;
            $kode = $request->otp;

            $otp = (new Otp)->validate(auth()->user()->phone, $kode);
            if(!$otp->status){
                return response()->json([
                    'message' => 'OTP salah atau tidak sesuai!',
                    'status' => 401
                ]);
            } else {
                if(!Hash::check($old_password, auth::user()->password)){
                    return response()->json([
                        'message' => 'Password lama tidak sesuai!',
                        'status' => 401
                    ]);
                }

                Tenant::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($password),
                ]);

                $action = "Tenant : Update Password | Using Application";
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                $date = Carbon::now()->format('d-m-Y H:i:s');
                $body = "Password anda telah diubah pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                $this->sendNotificationToUser($body);

                return response()->json([
                    'message' => 'Password berhasil diupdate!',
                    'status' => 200
                ]);
            }
        }
    }

    public function userUpdateStore(Request $request) : JsonResponse {
        $nama_toko = $request->nama_toko;
        $alamat_toko = $request->alamat_toko;
        $catatan_kaki_toko = $request->catatan_kaki_toko;
        $phone_toko = $request->phone_toko;
        $tenant = "";
        $store_detail = "";
        try {
            $store_detail = StoreDetail::where('email', auth()->user()->email)->firstOrFail();
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
        return response()->json(['message' => 'Update Success', 'status' => 200, 'app-version' => $this->getAppversion()]);
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
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function rekList() : JsonResponse {
        $rek = "";
        try {
            $rek = Rekening::where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();

            $dataRekening = "";
            if(!empty($rek->no_rekening) || !is_null($rek->no_rekening) || $rek->no_rekening != NULL || $rek->no_rekening != ""){
                $ip = "36.84.106.3";
                $PublicIP = $this->get_client_ip();
                $getLoc = Location::get($ip);
                $lat = $getLoc->latitude;
                $long = $getLoc->longitude;
                $rekClient = new GuzzleHttpClient();
                $urlRek = "https://erp.pt-best.com/api/rek_inquiry";
                try {
                    $getRek = $rekClient->request('POST',  $urlRek, [
                        'form_params' => [
                            'latitude' => $lat,
                            'longitude' => $long,
                            'bankCode' => $rek->swift_code,
                            'accountNo' => $rek->no_rekening,
                            'secret_key' => "Vpos71237577Inquiry"
                        ]
                    ]);
                    $responseCode = $getRek->getStatusCode();
                    $dataRekening = json_decode($getRek->getBody());
                } catch (Exception $e) {
                    return response()->json([
                        'message' => 'Fetch Fail!',
                        'rekening-status' => 'Akun Bank Tidak Terdeteksi, Harap cek kembali nomor rekening dan nama bank yang anda inputkan',
                        'data-bank' => $dataRekening,
                        'data-rekening' => $rek,
                        'status' => 404
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'Anda belum memasukkan nomor rekening!',
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        if($rek->count() == 0 || $rek == "" || empty($rek) || is_null($rek)){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'No data found in this collection!',
                'data-rekening' => $rek,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            if($dataRekening->responseCode == "2001600" || $dataRekening->responseCode == 2001600){
                return response()->json([
                    'message' => 'Fetch Success!',
                    'rekening-status' => 'Akun Terdeteksi',
                    'data-bank' => $dataRekening,
                    'data-rekening' => $rek,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                return response()->json([
                    'message' => 'Fetch Success!',
                    'rekening-status' => 'Akun Bank Tidak Terdeteksi, Harap cek kembali nomor rekening dan nama bank yang anda inputkan',
                    'data-bank' => $dataRekening,
                    'data-rekening' => $rek,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
    }

    public function bankList(){
        $client = new GuzzleHttpClient();
        $ip = "36.84.106.3";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $rekClient = new GuzzleHttpClient();
        $client = new GuzzleHttpClient();
        $url = 'https://erp.pt-best.com/api/testing-get-swift-code';
        $postResponse = $client->request('POST',  $url);
        $responseCode = $postResponse->getStatusCode();
        $data = json_decode($postResponse->getBody());
        $dataBankList = $data->bankSwiftList;


        return response()->json([
            'message' => 'Fetch Success!',
            'data-status' => 'Bank',
            'data-bank-list' => $dataBankList,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);

    }

    public function rekeningupdate(Request $request){
        $swift_code = $request->swift_code;
        $no_rekening = $request->no_rekening;
        $nama_bank = $request->nama_bank;
        $rekeningAkun = Rekening::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();

        if(is_null($rekeningAkun) || empty($rekeningAkun)){
            return response()->json([
                'message' => 'Data not found!',
                'status' => 404
            ]);
        }

        $ip = "36.84.106.3";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $rekClient = new GuzzleHttpClient();
        $urlRek = "https://erp.pt-best.com/api/rek_inquiry";
        try {
            $getRek = $rekClient->request('POST',  $urlRek, [
                'form_params' => [
                    'latitude' => $lat,
                    'longitude' => $long,
                    'bankCode' => $swift_code,
                    'accountNo' => $no_rekening,
                    'secret_key' => "Vpos71237577Inquiry"
                ]
            ]);
            $responseCode = $getRek->getStatusCode();
            $dataRekening = json_decode($getRek->getBody());
            if ($dataRekening->responseCode == 2001600 ||$dataRekening->responseCode == "2001600"){   
                $rekeningAkun->update([
                    'atas_nama' => $dataRekening->beneficiaryAccountName,
                    'nama_bank' => $nama_bank,
                    'no_rekening' => $dataRekening->beneficiaryAccountNo,
                    'swift_code' => $swift_code,
                ]);
                return response()->json([
                    'message' => 'Rekening berhasil diupdate!',
                    'data-bank' => $dataRekening,
                    'data-rekening' => $rekeningAkun,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                return response()->json([
                    'message' => 'Rekening Inquiry Error!',
                    'rekening-status' => 'Akun Bank Tidak Terdeteksi, Harap cek kembali nomor rekening dan nama bank yang anda inputkan',
                    'data-bank' => $dataRekening,
                    'data-rekening' => $rekeningAkun,
                    'status' => 404
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Rekening Inquiry Error!',
                'rekening-status' => 'Akun Bank Tidak Terdeteksi, Harap cek kembali nomor rekening dan nama bank yang anda inputkan',
                'data-bank' => $dataRekening,
                'data-rekening' => $rekeningAkun,
                'status' => 404
            ]);
        }
    }

    public function cekSaldoQris(){
        $qrisWallet = QrisWallet::select(['saldo'])
                                ->where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        return response()->json([
            'message' => 'Fetch Success!',
            'saldo-qris-akun' => $qrisWallet,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function tarikDana(Request $request){
        DB::connection()->enableQueryLog();
        $url = 'https://erp.pt-best.com/api/rek_transfer';
        $client = new GuzzleHttpClient();
        $ip = "125.164.243.227";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        // $agregate = 350;
        // $aplikator = 350;
        // $mitra = 500;
        $nominal_tarik = $request->nominal_penarikan;
        // $total_biaya_transfer = 1500;
        $withDraw = "";
        $qrisWallet = "";

        $transferFee = BiayaAdminTransferDana::get();
        $biayaAdmin = $transferFee->sum('nominal');
        $aplikator = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Admin')->first();
        $mitra = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Mitra Aplikasi')->first();
        $agregateMaintenance = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Agregate Server')->first();
        $agregateTransfer = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Transfer')->first();

        $total_tarik = (int) $nominal_tarik+$biayaAdmin;

        $qrisWallet = QrisWallet::where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();

        $saldo_tenant = $qrisWallet->saldo;

        if($saldo_tenant == 0){
            return response()->json([
                'message' => 'Saldo anda kosong!',
                'status' => 200
            ]);
        } else {
            if($nominal_tarik<10000){
                return response()->json([
                    'message' => 'Minimal tarik saldo adalah Rp. 10.000!',
                    'status' => 200
                ]);
            } else {
                if($qrisWallet->saldo<$total_tarik){
                    return response()->json([
                        'message' => 'Saldo anda tidak mencukupi!',
                        'status' => 200
                    ]);
                } else {
                    $rekening = Rekening::select(['swift_code', 'no_rekening', 'nama_bank', 'atas_nama', 'id'])
                                        ->where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
                    $agregateWalletMaintenance = AgregateWallet::find(1);
                    $agregateWalletTransfer = AgregateWallet::find(2);
                    $qrisAdmin = QrisWallet::where('email', 'adminsu@visipos.id')->find(1);

                    $marketing = InvitationCode::select(['invitation_codes.id',
                                                            'invitation_codes.id_marketing',
                                                        ])
                                                ->with(['marketing' => function ($query){
                                                    $query->select(['marketings.id',
                                                                    'marketings.email'
                                                    ])->get();
                                                }])
                                                ->find(auth()->user()->id_inv_code);

                    $saldoMitra = QrisWallet::where('id_user', $marketing->marketing->id)
                                            ->where('email', $marketing->marketing->email)
                                            ->first();

                    try{
                        $postResponse = $client->request('POST',  $url, [
                            'form_params' => [
                                'latitude' => $lat,
                                'longitude' => $long,
                                'bankCode' => $rekening->swift_code,
                                'accountNo' => $rekening->no_rekening,
                                'amount' => $nominal_tarik,
                                'secret_key' => "Vpos71237577Transfer"
                            ]
                        ]);
                        $responseCode = $postResponse->getStatusCode();
                        $data = json_decode($postResponse->getBody());
                        $responseCode = $data->responseCode;
                        $responseMessage = $data->responseMessage;
 
                        if($responseCode == 2001800 && $responseMessage == "Request has been processed successfully") {
                            $withDraw = Withdrawal::create([
                                'id_user' => auth()->user()->id,
                                'id_rekening' => $rekening->id,
                                'email' => auth()->user()->email,
                                'jenis_penarikan' => "Penarikan Dana Tenant",
                                'tanggal_penarikan' => Carbon::now(),
                                'nominal' => $nominal_tarik,
                                'biaya_admin' => $biayaAdmin,
                                'tanggal_masuk' => Carbon::now(),
                                'deteksi_ip_address' => $ip,
                                'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                                'status' => 1
                            ]);
                            // return $withDraw;
                            if(!is_null($withDraw) || !empty($withDraw)){
                                RekeningWithdraw::create([
                                    'id_penarikan' => $withDraw->id,
                                    'atas_nama' => $rekening->atas_nama,
                                    'nama_bank' => $rekening->nama_bank,
                                    'no_rekening' => $rekening->no_rekening,
                                ]);

                                $qrisWallet->update([
                                    'saldo' => $saldo_tenant-$total_tarik
                                ]);
                                $adminSaldo = $qrisAdmin->saldo;

                                $qrisAdmin->update([
                                    'saldo' => $adminSaldo+$aplikator->nominal
                                ]);

                                $mitraSaldo = $saldoMitra->saldo;
                                $saldoMitra->update([
                                    'saldo' => $mitraSaldo+$mitra->nominal
                                ]);

                                $agregateSaldoMaintenance = $agregateWalletMaintenance->saldo;
                                $agregateWalletMaintenance->update([
                                    'saldo' =>$agregateSaldoMaintenance+$agregateMaintenance->nominal
                                ]);

                                $agregateSaldoTransfer = $agregateWalletTransfer->saldo;
                                $agregateWalletTransfer->update([
                                    'saldo' =>$agregateSaldoTransfer+$agregateTransfer->nominal
                                ]);

                                foreach($transferFee as $fee){
                                    DetailPenarikan::create([
                                        'id_penarikan' => $withDraw->id,
                                        'id_insentif' => $fee->id,
                                        'nominal' => $fee->nominal,
                                    ]);
                                }

                                NobuWithdrawFeeHistory::create([
                                    'id_penarikan' => $withDraw->id,
                                    'nominal' => 300
                                ]);
                                $action = "Tenant : Withdrawal Process Success | Using Application";
                                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                                $date = Carbon::now()->format('d-m-Y H:i:s');
                                $body = "Penarikan dana Qris sebesar Rp. ".$nominal_tarik." melalui aplikasi android sukses pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                                $this->sendNotificationToUser($body);
                                return response()->json([
                                    'message' => 'Penarikan Berhasil!',
                                    'data-withdraw' => $withDraw,
                                    'saldo-qris' => $qrisWallet,
                                    'status' => 200,
                                    'app-version' => $this->getAppversion()
                                ]);
                            } else {
                                $action = "Tenant : Withdrawal Process Failed | Using Application";
                                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
                                $date = Carbon::now()->format('d-m-Y H:i:s');
                                $body = "Penarikan dana Qris sebesar Rp. ".$nominal_tarik." melalui aplikasi android gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                                $this->sendNotificationToUser($body);
                                return response()->json([
                                    'message' => 'Transaction Error!',
                                    'status' => 500
                                ]);
                            }
                        } else {
                            $withDraw = Withdrawal::create([
                                'id_user' => auth()->user()->id,
                                'email' => auth()->user()->email,
                                'tanggal_penarikan' => Carbon::now(),
                                'nominal' => $nominal_tarik,
                                'biaya_admin' => $biayaAdmin,
                                'tanggal_masuk' => Carbon::now(),
                                'deteksi_ip_address' => $ip,
                                'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                                'status' => 0
                            ]);
                            $action = "Tenant : Withdrawal Transaction fail invalid";
                            $this->createHistoryUser($action, $responseMessage, 0);
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Penarikan dana Qris sebesar Rp. ".$nominal_tarik." melalui aplikasi android gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body);
                            return response()->json([
                                'message' => 'Penarikan gagal, harap hubungi admin!',
                                'status' => 500
                            ]);
                        }
                    } catch(Exception $e){
                        $action = "Tenant : Withdraw Process | Error (HTTP API Error)";
                        $this->createHistoryUser($action, $e, 0);
                        $date = Carbon::now()->format('d-m-Y H:i:s');
                        $body = "Penarikan dana Qris sebesar Rp. ".$nominal_tarik." melalui aplikasi android gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                        $this->sendNotificationToUser($body);
                        return response()->json([
                            'message' => 'Penarikan gagal, harap hubungi admin!',
                            'error' => $e,
                            'status' => 500
                        ]);
                    }
                }
            }
        }
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
