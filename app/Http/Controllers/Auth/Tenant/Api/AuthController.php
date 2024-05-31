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
        try {
            // $user = Tenant::select(['tenants.id','tenants.name', 'tenants.email as mail', 'tenants.phone', 'tenants.email_verified_at', 'tenants.phone_number_verified_at', 'tenants.is_active'])
            //                     ->with(['detail', 'storeDetail'])
            //                     ->whereHas('detail', function($q) {
            //                         $q->select(
            //                             'detail_tenants.id as detail_id',
            //                             'detail_tenants.id_tenant as id_detail_tenant',
            //                             'no_ktp',
            //                             'tempat_lahir',
            //                             'tanggal_lahir',
            //                             'jenis_kelamin',
            //                             'detail_tenants.alamat as alamat_tenant',
            //                             'detail_tenants.photo as tenant_photo_profile'
            //                         );
            //                     })
            //                     ->whereHas('storeDetail', function($q) {
            //                         $q->select(
            //                             'store_details.id as store_detail_id',
            //                             'store_details.id_tenant as id_store_detail_tenant',
            //                             'store_details.name as nama_toko',
            //                             'store_details.alamat as alamat_toko',
            //                             'store_details.no_telp_toko as no_telp_toko',
            //                             'jenis_usaha',
            //                             'status_umi',
            //                             'catatan_kaki',
            //                             'store_details.photo as photo_toko'
            //                         );
            //                     })
            //                     ->where('id', Auth::user()->id)
            //                     ->firstOrFail();
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
                    'status' => 200
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
                'status' => 200
            ]);
        } else {
            if($dataRekening->responseCode == "2001600" || $dataRekening->responseCode == 2001600){
                return response()->json([
                    'message' => 'Fetch Success!',
                    'rekening-status' => 'Akun Terdeteksi',
                    'data-bank' => $dataRekening,
                    'data-rekening' => $rek,
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Fetch Success!',
                    'rekening-status' => 'Akun Bank Tidak Terdeteksi, Harap cek kembali nomor rekening dan nama bank yang anda inputkan',
                    'data-bank' => $dataRekening,
                    'data-rekening' => $rek,
                    'status' => 200
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
            'status' => 200
        ]);

    }

    public function rekeningupdate(Request $request){
        $swift_code = $request->swift_code;
        $rekening = $request->no_rekening;
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

        $rekeningAkun->update([
            'nama_bank' => $nama_bank,
            'no_rekening' => $rekening,
            'swift_code' => $swift_code,
        ]);

        return response()->json([
            'message' => 'Rekening berhasil diupdate!',
            'data-rekening' => $rekeningAkun,
            'status' => 200
        ]);
    }

    public function cekSaldoQris(){
        $qrisWallet = QrisWallet::select(['saldo'])
                                ->where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        return response()->json([
            'message' => 'Fetch Success!',
            'saldo-qris-akun' => $qrisWallet,
            'status' => 200
        ]);
    }
    
    public function tarikDana(Request $request){
        $url = 'https://erp.pt-best.com/api/rek_transfer';
        $client = new GuzzleHttpClient();
        $ip = "125.164.243.227";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $agregate = 350;
        $aplikator = 350;
        $mitra = 500;
        $nominal_tarik = $request->nominal_penarikan;
        $total_biaya_transfer = 1500;
        $total_tarik = (int) $nominal_tarik+$total_biaya_transfer;
        $withDraw = "";
        $qrisWallet = "";
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
                    $rekening = Rekening::select(['swift_code', 'no_rekening'])
                                        ->where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
                    $agregateWallet = AgregateWallet::find(1);
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
                                'email' => auth()->user()->email,
                                'tanggal_penarikan' => Carbon::now(),
                                'nominal' => $nominal_tarik,
                                'biaya_admin' => $total_biaya_transfer,
                                'tanggal_masuk' => Carbon::now(),
                                'deteksi_ip_address' => $ip,
                                'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                                'status' => 1
                            ]);
                            // return $withDraw;
                            if(!is_null($withDraw) || !empty($withDraw)){
                                $qrisWallet->update([
                                    'saldo' => $saldo_tenant-$total_tarik
                                ]);
                                $adminSaldo = $qrisAdmin->saldo;
    
                                $qrisAdmin->update([
                                    'saldo' => $adminSaldo+$aplikator
                                ]);

                                $mitraSaldo = $saldoMitra->saldo;
                                $saldoMitra->update([
                                    'saldo' => $mitraSaldo+$mitra
                                ]);
                                $agregateSaldo = $agregateWallet->saldo;
                                $agregateWallet->update([
                                    'saldo' =>$agregateSaldo+$agregate
                                ]);
    
                                DetailPenarikan::create([
                                    'id_penarikan' => $withDraw->id,
                                    'nominal_penarikan' => $total_tarik,
                                    'nominal_bersih_penarikan' => $nominal_tarik,
                                    'total_biaya_admin' => $total_biaya_transfer,
                                    'biaya_nobu' => 300,
                                    'biaya_tenant' => $nominal_tarik,
                                    'biaya_mitra' => $mitra,
                                    'biaya_admin_su' => $aplikator,
                                    'biaya_agregate' => $agregate
                                ]);
    
                                NobuWithdrawFeeHistory::create([
                                    'id_penarikan' => $withDraw->id,
                                    'nominal' => 300
                                ]);
                                
                                return response()->json([
                                    'message' => 'Penarikan Berhasil!',
                                    'data-withdraw' => $withDraw,
                                    'saldo-qris' => $qrisWallet,
                                    'status' => 200
                                ]);
                            } else {
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
                                'biaya_admin' => $total_biaya_transfer,
                                'tanggal_masuk' => Carbon::now(),
                                'deteksi_ip_address' => $ip,
                                'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                                'status' => 0
                            ]);
                            DetailPenarikan::create([
                                'id_penarikan' => $withDraw->id,
                                'nominal_penarikan' => NULL,
                                'nominal_bersih_penarikan' => NULL,
                                'total_biaya_admin' => NULL,
                                'biaya_nobu' => NULL,
                                'biaya_tenant' => NULL,
                                'biaya_mitra' => NULL,
                                'biaya_admin_su' => NULL,
                                'biaya_agregate' => NULL
                            ]);

                            return response()->json([
                                'message' => 'Penarikan gagal, harap hubungi admin!',
                                'status' => 500
                            ]);
                        }
                    } catch(Exception $e){
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

    function get_client_ip() {
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

    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}