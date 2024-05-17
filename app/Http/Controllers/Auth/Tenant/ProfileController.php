<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\CsvImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleHttpClient;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use Ichtrojan\Otp\Otp;
use Twilio\Rest\Client;
use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\DetailTenant;
use App\Models\StoreDetail;
use App\Models\UmiRequest;
use App\Mail\SendUmiEmail;
use App\Models\History;
use App\Models\Rekening;
use App\Models\QrisWallet;
use App\Models\Withdrawal;
use App\Models\NobuWithdrawFeeHistory;
use App\Models\DetailPenarikan;
use App\Models\AgregateWallet;
use App\Models\InvitationCode;
use File;
use Mail;
use Exception;

class ProfileController extends Controller{
    public function __construct() {
        $this->middleware('isTenantIsMitra');
    }

    public function tenantSettings(){
        return view('tenant.tenant_settings');
    }

    public function profile(){
        $profilTenant = Tenant::select(['tenants.id', 'tenants.name', 'tenants.email', 'tenants.phone', 'tenants.is_active', 'tenants.phone_number_verified_at', 'tenants.email_verified_at'])
                                ->with(['detail' => function($query){
                                    $query->select(['detail_tenants.id', 
                                                    'detail_tenants.id_tenant', 
                                                    'detail_tenants.no_ktp',
                                                    'detail_tenants.tempat_lahir',
                                                    'detail_tenants.tanggal_lahir',
                                                    'detail_tenants.jenis_kelamin',
                                                    'detail_tenants.alamat',
                                                    'detail_tenants.photo'])
                                            ->where('detail_tenants.id_tenant', auth()->user()->id)
                                            ->where('detail_tenants.email', auth()->user()->email)
                                            ->first();
                                }
                                ])
                                ->find(auth()->user()->id);
        $rekening = Rekening::select(['swift_code', 'no_rekening'])
                            ->where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $qrisWallet = QrisWallet::select(['saldo'])
                                ->where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        return view('tenant.tenant_profile', compact('profilTenant', 'rekening', 'qrisWallet'));
    }

    // tidak dipakai karena info akun tidak bisa diupdate
    public function profileAccountUpdate(Request $request){
        $profileInfo = Tenant::find(auth()->user()->id);

        $profileInfo->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        $notification = array(
            'message' => 'Data akun berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
    // tidak dipakai karena info akun tidak bisa diupdate

    public function profileInfoUpdate(Request $request){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();
        try {
            $profileInfo = DetailTenant::where('id_tenant', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->find(auth()->user()->detail->id);
            $account = Tenant::where('id', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();

            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $namaFile = $profileInfo->name;
                $storagePath = Storage::path('public/images/profile');
                $ext = $file->getClientOriginalExtension();
                $filename = $namaFile.'-'.time().'.'.$ext;

                if(empty($profileInfo->detail->photo)){
                    try {
                        $file->move($storagePath, $filename);
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                } else {
                    Storage::delete('public/images/profile/'.$profileInfo->detail->photo);
                    $file->move($storagePath, $filename);
                }

                $profileInfo->update([
                    'no_ktp' => $request->no_ktp,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'photo' => $filename,
                    'updated_at' => Carbon::now()
                ]);

                $account->update([
                    'name' => $request->name
                ]);

            } else {
                $profileInfo->update([
                    'no_ktp' => $request->no_ktp,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'updated_at' => Carbon::now()
                ]);

                $account->update([
                    'name' => $request->name
                ]);
            }

            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change profile information : Success",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                'status' => 1
            ]);

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);

        } catch (Exception $e) {
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change profile information : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Error data gagal diupdate!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function password(){
        return view('tenant.auth.password_update');
    }

    public function passwordUpdate(Request $request){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();

        $request->validate([
            'otp' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        try{
            $otp = (new Otp)->validate(auth()->user()->phone, $request->otp);
            if(!$otp->status){
                History::create([
                    'id_user' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'action' => "Change Password : OTP Fail doesn't match",
                    'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                    'deteksi_ip' => $ip,
                    'log' => str_replace("'", "\'", json_encode($otp)),
                    'status' => 0
                ]);

                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                if(!Hash::check($request->old_password, auth::user()->password)){
                    $notification = array(
                        'message' => 'Password lama tidak sesuai!',
                        'alert-type' => 'error',
                    );
                    return redirect()->back()->with($notification);
                }
        
                Tenant::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($request->new_password),
                ]);

                History::create([
                    'id_user' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'action' => "Change Password : Success!",
                    'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                    'deteksi_ip' => $ip,
                    'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                    'status' => 1
                ]);
                
                $notification = array(
                    'message' => 'Password berhasil diperbarui!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            }
        } catch (Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change Password : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Update Password Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }
    
    public function storeProfileSettings(){
        $tenantStore = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        return view('tenant.tenant_store_detail', compact('tenantStore'));
    }

    public function storeProfileSettingsUPdate(Request $request) {
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();

        try{
            $tenantStore = StoreDetail::where('id_tenant', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();

            if(is_null($tenantStore) || empty($tenantStore)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            } 

            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $namaFile = $request->nama;
                $storagePath = Storage::path('public/images/profile');
                $ext = $file->getClientOriginalExtension();
                $filename = $namaFile.'-'.time().'.'.$ext;

                if(empty($tenantStore->photo)){
                    try {
                        $file->move($storagePath, $filename);
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                } else {
                    Storage::delete('public/images/profile/'.$tenantStore->photo);
                    $file->move($storagePath, $filename);
                }

                $tenantStore->update([
                    'name' => $request->name,
                    'alamat' => $request->alamat,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                    'catatan_kaki' => $request->catatan,
                    'photo' => $filename
                ]);
            } else {
                $tenantStore->update([
                    'name' => $request->name,
                    'alamat' => $request->alamat,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                    'catatan_kaki' => $request->catatan,
                ]);
            }

            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Update Store Profile : Success",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                'status' => 1
            ]);

            $notification = array(
                'message' => 'Data berhasil diperbarui!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Update Store Profile : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Error data gagal diupdate!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function rekeingSetting(){
        $rekening = Rekening::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $dataRekening = "";
        if(!empty($rekening->no_rekening) || !is_null($rekening->no_rekening) || $rekening->no_rekening != NULL || $rekening->no_rekening != ""){
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
                        'bankCode' => $rekening->swift_code,
                        'accountNo' => $rekening->no_rekening,
                        'secret_key' => "Vpos71237577Inquiry"
                    ]
                ]);
                $responseCode = $getRek->getStatusCode();
                $dataRekening = json_decode($getRek->getBody());
            } catch (Exception $e) {
                return $e;
                exit;
            }
        }
        $client = new GuzzleHttpClient();
        $url = 'https://erp.pt-best.com/api/testing-get-swift-code';
        $postResponse = $client->request('POST',  $url);
        $responseCode = $postResponse->getStatusCode();
        $data = json_decode($postResponse->getBody());
        $dataBankList = $data->bankSwiftList;
        //dd($data->bankSwiftList);
        return view('tenant.tenant_rekening_setting', compact('rekening', 'dataBankList', 'dataRekening'));
    }

    public function rekeningSettingUpdate(Request $request){
        $kode = (int) $request->otp;
        $swift_code = $request->swift_code;
        $rekening = $request->no_rekening;

        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();

        try{
            $otp = (new Otp)->validate(auth()->user()->phone, $kode);
            if(!$otp->status){
                History::create([
                    'id_user' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'action' => "Change Rekening : OTP Fail doesn't match",
                    'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                    'deteksi_ip' => $ip,
                    'log' => str_replace("'", "\'", json_encode($otp)),
                    'status' => 0
                ]);
                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                $rekeningAkun = Rekening::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
                $rekeningAkun->update([
                    'no_rekening' => $rekening,
                    'swift_code' => $swift_code,
                ]);

                History::create([
                    'id_user' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'action' => "Change Rekening : Success!",
                    'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                    'deteksi_ip' => $ip,
                    'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                    'status' => 1
                ]);

                $notification = array(
                    'message' => 'Update nomor rekening berhasil!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            }
        } catch(Exception $e) {
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change Rekening : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Update Rekening Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function umiRequestForm(){
        $umiRequest = UmiRequest::where('id_tenant', auth()->user()->id)->first();
        if(empty($umiRequest)){
            $umiRequest = "Empty";
        }
        return view('tenant.tenant_umi_request', compact('umiRequest'));
    }

    public function umiRequestProcess(Request $request){
        $umiRequest = UmiRequest::where('id_tenant', auth()->user()->id)->first();
        if(empty($umiRequest) || is_null($umiRequest) || $umiRequest == ""){
            $tanggal = date("j F Y", strtotime(date('Y-m-d')));
            $nama_pemilik = $request->nama_pemilik;
            $no_ktp = $request->no_ktp;
            $no_hp = $request->no_hp;
            $email = $request->email;
            $nama_usaha = $request->nama_usaha;
            $jenis_usaha = $request->jenis_usaha;
            $alamat = $request->alamat;
            $kab_kota = $request->kab_kota;
            $kode_pos = $request->kode_pos;
            $templatePath = Storage::path('public/docs/umi/template/Formulir_Pendaftaran_NOBU_QRIS_(NMID).xlsx');
            $userDocsPath = Storage::path('public/docs/umi/user_doc');
            $filename = 'Formulir Pendaftaran NOBU QRIS (NMID) PT BRAHMA ESATAMA_'.$nama_usaha.'_'.date('dmYHis').'.xlsx';
            $fileSave = $userDocsPath.'/'.$filename;
            try {
                //File::copy($templatePath, $fileSave);
                $spreadsheet = IOFactory::load($fileSave);
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('D6', $tanggal);
                $sheet->setCellValue('C10', $nama_pemilik);
                $sheet->setCellValue('D10', $no_ktp);
                $sheet->setCellValue('E10', $no_hp);
                $sheet->setCellValue('F10', $email);
                $sheet->setCellValue('G10', $nama_usaha);
                $sheet->setCellValue('H10', $jenis_usaha);
                $sheet->setCellValue('I10', $alamat);
                $sheet->setCellValue('J10', $kab_kota);
                $sheet->setCellValue('K10', $kode_pos);
                $sheet->setCellValue('L10', 'Ya');
                $sheet->setCellValue('M10', 'UMI - Penjualan/Tahun: < 2M');
                $sheet->setCellValue('N10', 'Booth (Dinamis & Statis)');
                $sheet->setCellValue('O10', '0,00%');
                $sheet->setCellValue('P10', 'Ya');
                $sheet->setCellValue('Q10', '');
                $newFilePath = $fileSave;
                $writer = new Xlsx($spreadsheet);
                $writer->save($newFilePath);
                UmiRequest::create([
                    'id_tenant' => auth()->user()->id,
                    'tanggal_pengajuan' => Carbon::now(),
                    'file_path' => $filename
                ]);
                $mailData = [
                    'title' => 'Formulir Pendaftaran UMI',
                    'body' => 'This is for testing email using smtp.',
                    'file' => $fileSave
                ];
                 
                //Mail::to('ouka.dev@gmail.com')->send(new SendUmiEmail($mailData));
                   
                //dd("Email is sent successfully.");
                $notification = array(
                    'message' => 'Permintaan UMI berhasil diajukan!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            } catch (Exception $e) {
                return $e;
                exit;
            }
        } else {
            return redirect()->back();
        }
    }

    public function whatsappNotification(Request $request){
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
            $notification = array(
                'message' => 'OTP Sukses dikirim!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'OTP Gagal dikirim!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function whatsappOTPSubmit(Request $request){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();
        if(!empty(auth()->user()->phone_number_verified_at) || !is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at != NULL || auth()->user()->phone_number_verified_at != "") {
            return redirect()->route('tenant.dashboard');
        } else {
            try{
                $kode = (int) $request->otp;
                $otp = (new Otp)->validate(auth()->user()->phone, $kode);
                if(!$otp->status){
                    History::create([
                        'id_user' => auth()->user()->id,
                        'email' => auth()->user()->email,
                        'action' => "Whatsapp Number Verification : OTP Fail doesn't match",
                        'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                        'deteksi_ip' => $ip,
                        'log' => str_replace("'", "\'", json_encode($otp)),
                        'status' => 0
                    ]);
                    $notification = array(
                        'message' => 'OTP salah atau tidak sesuai!',
                        'alert-type' => 'error',
                    );
                    return redirect()->back()->with($notification);
                } else {
                    $user = Tenant::find(auth()->user()->id);
                    $user->update([
                        'phone_number_verified_at' => now()
                    ]);
                    History::create([
                        'id_user' => auth()->user()->id,
                        'email' => auth()->user()->email,
                        'action' => "Whatsapp Number Verification : Success!",
                        'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                        'deteksi_ip' => $ip,
                        'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                        'status' => 1
                    ]);
                    $notification = array(
                        'message' => 'Nomor anda telah diverifikasi!',
                        'alert-type' => 'success',
                    );
                    return redirect()->back()->with($notification);
                }
            } catch(Exception $e){
                History::create([
                    'id_user' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'action' => "Whatsapp Number Verification : Error",
                    'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                    'deteksi_ip' => $ip,
                    'log' => $e,
                    'status' => 0
                ]);
    
                $notification = array(
                    'message' => 'Whatsapp Verification Error!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }
        }
    }

    public function tarikDanaQris(Request $request){
        $ip = "125.164.243.227";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        
        $nominal_tarik = $request->nominal_tarik;
        $otp = $request->wa_otp;

        try{
            $otp = (new Otp)->validate(auth()->user()->phone, $otp);
            if(!$otp->status){
                History::create([
                    'id_user' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'action' => "Tarik dana Qris : OTP Fail doesn't match",
                    'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                    'deteksi_ip' => $ip,
                    'log' => str_replace("'", "\'", json_encode($otp)),
                    'status' => 0
                ]);

                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                $qrisWallet = QrisWallet::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
                if($qrisWallet->saldo<$nominal_tarik){
                    History::create([
                        'id_user' => auth()->user()->id,
                        'email' => auth()->user()->email,
                        'action' => "Withdraw Process : Fail (Saldo tidak mencukupi)",
                        'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                        'deteksi_ip' => $ip,
                        'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                        'status' => 0
                    ]);
                    $notification = array(
                        'message' => 'Saldo anda tidak mencukupi!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->back()->with($notification);
                } else {
                    $rekening = Rekening::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
                    $totalPenarikan = $nominal_tarik+1500;
                    $rekClient = new GuzzleHttpClient();
                    $urlRek = "https://erp.pt-best.com/api/rek_inquiry";
                    try {
                        $getRek = $rekClient->request('POST',  $urlRek, [
                            'form_params' => [
                                'latitude' => $lat,
                                'longitude' => $long,
                                'bankCode' => $rekening->swift_code,
                                'accountNo' => $rekening->no_rekening,
                                'secret_key' => "Vpos71237577Inquiry"
                            ]
                        ]);
                        $responseCode = $getRek->getStatusCode();
                        $dataRekening = json_decode($getRek->getBody());
                        return view('tenant.tenant_form_cek_penarikan', compact(['dataRekening', 'rekening', 'nominal_tarik', 'totalPenarikan']));
                    } catch (Exception $e) {
                        return $e;
                        exit;
                    }
                }
            }
        } catch(Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Withdraw Process : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Penarikan dana gagal, harap hubungi admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function prosesTarikDana(Request $request){
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
        DB::connection()->enableQueryLog();

        $nominal_tarik = $request->nominal_penarikan;
        $total_tarik = $request->total_tarik;
        $biaya_admin = $request->biaya_admin;
        
        $rekening = Rekening::select(['swift_code', 'no_rekening'])
                            ->where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $qrisWallet = QrisWallet::where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $agregateWallet = AgregateWallet::find(1);
        $qrisAdmin = QrisWallet::where('id_user', 8)
                                ->where('email', 'adminsu@vpos.my.id.com')
                                ->find(6);
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
        $agregateSaldo = $agregateWallet->saldo;

        try{
            $nominal_penarikan = filter_var($nominal_tarik, FILTER_SANITIZE_NUMBER_INT);
            $total_penarikan = $total_tarik;
            $saldo = $qrisWallet->saldo;
            if($saldo < $total_penarikan){
                History::create([
                    'id_user' => auth()->user()->id,
                    'email' => auth()->user()->email,
                    'action' => "Withdraw Process : Fail (Saldo tidak mencukupi)",
                    'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                    'deteksi_ip' => $ip,
                    'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                    'status' => 0
                ]);
                $notification = array(
                    'message' => 'Saldo anda tidak mencukupi!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            } else {
                try {
                    $postResponse = $client->request('POST',  $url, [
                        'form_params' => [
                            'latitude' => $lat,
                            'longitude' => $long,
                            'bankCode' => $rekening->swift_code,
                            'accountNo' => $rekening->no_rekening,
                            'amount' => $nominal_penarikan,
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
                            'nominal' => $nominal_penarikan,
                            'biaya_admin' => $biaya_admin,
                            'tanggal_masuk' => Carbon::now(),
                            'deteksi_ip_address' => $ip,
                            'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                            'status' => 1
                        ]);

                        if(!is_null($withDraw) || !empty($withDraw)){
                            $qrisWallet->update([
                                'saldo' => $saldo-$total_penarikan
                            ]);
                            $adminSaldo = $qrisAdmin->saldo;
                            $qrisAdmin->update([
                                'saldo' => $adminSaldo+$aplikator
                            ]);
                            $mitraSaldo = $saldoMitra->saldo;
                            $saldoMitra->update([
                                'saldo' => $mitraSaldo+$mitra
                            ]);
                            $agregateWallet->update([
                                'saldo' =>$agregateSaldo+$agregate
                            ]);

                            DetailPenarikan::create([
                                'id_penarikan' => $withDraw->id,
                                'nominal_penarikan' => $total_penarikan,
                                'nominal_bersih_penarikan' => $nominal_penarikan,
                                'total_biaya_admin' => $biaya_admin,
                                'biaya_nobu' => 300,
                                'biaya_mitra' => $mitra,
                                'biaya_admin_su' => $aplikator,
                                'biaya_agregate' => $agregate
                            ]);

                            NobuWithdrawFeeHistory::create([
                                'id_penarikan' => $withDraw->id,
                                'nominal' => 300
                            ]);

                            History::create([
                                'id_user' => auth()->user()->id,
                                'email' => auth()->user()->email,
                                'action' => "Withdraw Process : Success!",
                                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                                'deteksi_ip' => $ip,
                                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                                'status' => 1
                            ]);
                            
                            $notification = array(
                                'message' => 'Penarikan dana sukses!',
                                'alert-type' => 'success',
                            );
                            return redirect()->route('tenant.finance.history_penarikan.invoice', array('id' => $withDraw->id))->with($notification);
                        } else {
                            return "testing";
                        }
                    } else {
                        $withDraw = Withdrawal::create([
                            'id_user' => auth()->user()->id,
                            'email' => auth()->user()->email,
                            'tanggal_penarikan' => Carbon::now(),
                            'nominal' => $nominal_penarikan,
                            'biaya_admin' => $biaya_admin,
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
                            'biaya_mitra' => NULL,
                            'biaya_admin_su' => NULL,
                            'biaya_agregate' => NULL
                        ]);
                        History::create([
                            'id_user' => auth()->user()->id,
                            'email' => auth()->user()->email,
                            'action' => "Withdraw Process : Transaction fail invalid",
                            'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                            'deteksi_ip' => $ip,
                            'log' => $responseMessage,
                            'status' => 0
                        ]);
                        $notification = array(
                            'message' => 'Penarikan dana gagal, harap hubungi admin!',
                            'alert-type' => 'error',
                        );
                        return redirect()->back()->with($notification);
                    }
                } catch (Exception $e) {
                    History::create([
                        'id_user' => auth()->user()->id,
                        'email' => auth()->user()->email,
                        'action' => "Withdraw Process : Error (HTTP API Error)",
                        'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                        'deteksi_ip' => $ip,
                        'log' => $e,
                        'status' => 0
                    ]);
                    $notification = array(
                        'message' => 'Penarikan dana gagal, harap hubungi admin!',
                        'alert-type' => 'error',
                    );
                    return redirect()->back()->with($notification);
                }
            }
        } catch (Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Withdraw Process : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Penarikan dana gagal, harap hubungi admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
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
}
