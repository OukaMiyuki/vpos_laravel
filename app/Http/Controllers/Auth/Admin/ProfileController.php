<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client as GuzzleHttpClient;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\DetailAdmin;
use App\Models\Rekening;
use App\Models\AgregateWallet;
use App\Models\QrisWallet;
use App\Models\Withdrawal;
use App\Models\DetailPenarikan;
use App\Models\NobuWithdrawFeeHistory;
use App\Models\History;
use App\Models\RekeningAdmin;
use App\Models\BiayaAdminTransferDana;
use App\Models\RekeningWithdraw;
use Exception;

class ProfileController extends Controller {

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
            $action = "Admin Send User Notification Fail";
            $this->createHistoryUser($action, $ex, 0);
        }
        if(is_null($postResponse) || empty($postResponse) || $postResponse == NULL || $postResponse == ""){
            $action = "Admin Send User Notification Fail";
            $this->createHistoryUser(NULL, NULL, $action, "OTP Response NULL", 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification)->withInput();
        } else {
            $responseCode = $postResponse->getStatusCode();
            if($responseCode != 200){
                $action = "Send Whatsapp Notification Fail";
                $this->createHistoryUser($action, $ex, 0);
            } 
        }
    }

    public function adminSettings(){
        return view('admin.admin_setting');
    }

    public function profile(){
        return view('admin.admin_profile');
    }

    public function profileAccountUpdate(Request $request){
        $id = auth()->user()->id;
        $account = Admin::find($id);
        $account->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        $notification = array(
            'message' => 'Data akun berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function profileInfoUpdate(Request $request) {
        DB::connection()->enableQueryLog();
        $id = auth()->user()->detail->id;
        $accountInfo = DetailAdmin::find($id);
        $action = "";
        if(auth()->user()->access_level == 0){
             $action = "Admin Super User : Update Profile";
        } else {
            $action = "Administrator : Update Profile";
        }
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $namaFile = auth()->user()->name;
            $storagePath = Storage::path('public/images/profile');
            $ext = $file->getClientOriginalExtension();
            $filename = $namaFile.'-'.time().'.'.$ext;

            if(empty($accountInfo->photo)){
                try {
                    $file->move($storagePath, $filename);
                } catch (\Exception $e) {
                    if(auth()->user()->access_level == 0){
                        $action = "Admin Super User : Update Profile | Upload Photo Error";
                    } else {
                        $action = "Administrator : Update Profile | Upload Photo Error";
                    }
                    $this->createHistoryUser($action, $e, 0);
                }
            } else {
                try {
                    Storage::delete('public/images/profile/'.$accountInfo->photo);
                    $file->move($storagePath, $filename);
                } catch (\Exception $e) {
                    if(auth()->user()->access_level == 0){
                        $action = "Admin Super User : Update Profile | Upload Photo Error";
                    } else {
                        $action = "Administrator : Update Profile | Upload Photo Error";
                    }
                    $this->createHistoryUser($action, $e, 0);
                }
            }

            $accountInfo->update([
                'no_ktp' => $request->no_ktp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'photo' => $filename,
                'updated_at' => Carbon::now()
            ]);

        } else {
            $accountInfo->update([
                'no_ktp' => $request->no_ktp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'updated_at' => Carbon::now()
            ]);
        }
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Data akun berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function password(){
        return view('admin.auth.password_update');
    }

    public function passwordUpdate(Request $request){
        $action = "";
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Update Password";
        } else {
            $action = "Administrator : Update Password";
        }
        DB::connection()->enableQueryLog();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        try{
            $otp = (new Otp)->validate(auth()->user()->phone, $request->otp);
            if(!$otp->status){
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
                Admin::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($request->new_password),
                ]);
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                $date = Carbon::now()->format('d-m-Y H:i:s');
                $body = "Password anda telah diubah pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                $this->sendNotificationToUser($body);
                $notification = array(
                    'message' => 'Password berhasil diperbarui!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            }
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Update Password Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function whatsappNotification(){
        DB::connection()->enableQueryLog();
        $action = "";
        $api_key    = getenv("WHATZAPP_API_KEY");
        $sender  = getenv("WHATZAPP_PHONE_NUMBER");
        // dd($sender);
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
        } catch(Exception $ex){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Send Whatsapp OTP Fail";
            } else {
                $action = "Administrator : Send Whatsapp OTP Fail";
            }
            $this->createHistoryUser($action, $ex, 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        if(is_null($postResponse) || empty($postResponse) || $postResponse == NULL || $postResponse == ""){
            $action = "Admin User Send Whatsapp OTP Fail";
            $this->createHistoryUser(NULL, NULL, $action, "OTP Response NULL", 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification)->withInput();
        } else {
            $responseCode = $postResponse->getStatusCode();
            if($responseCode == 200){
                if(auth()->user()->access_level == 0){
                    $action = "Admin Super User : Send Whatsapp OTP Success";
                } else {
                    $action = "Administrator : Send Whatsapp OTP Success";
                }
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                $notification = array(
                    'message' => 'OTP Sukses dikirim!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            } else {
                if(auth()->user()->access_level == 0){
                    $action = "Admin Super User : Send Whatsapp OTP Fail | Status : ".$responseCode;
                } else {
                    $action = "Administrator : Send Whatsapp OTP Fail | Status : ".$responseCode;
                }
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
                $notification = array(
                    'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }
        }

    }

    public function rekeningList(){
        $rekeningList = RekeningAdmin::latest()->get();
        return view('admin.admin_rekening_list', compact('rekeningList'));
    }

    public function rekeningListAdd(){
        $client = new GuzzleHttpClient();
        $url = 'https://erp.pt-best.com/api/testing-get-swift-code';
        $postResponse = $client->request('POST',  $url);
        $responseCode = $postResponse->getStatusCode();
        $data = json_decode($postResponse->getBody());
        $dataBankList = $data->bankSwiftList;
        return view('admin.admin_rekening_add', compact(['dataBankList']));
    }

    public function rekeningListInsert(Request $request){
        $kode = (int) $request->otp;
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Tambah Rekening";
        } else {
            $action = "Administrator : Tambah Rekening";
        }
        DB::connection()->enableQueryLog();

        try{
            $otp = (new Otp)->validate(auth()->user()->phone, $kode);
            if(!$otp->status){
                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                if(!is_null($request->swift_code) && !is_null($request->no_rekening)){
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
                                'bankCode' => $request->swift_code,
                                'accountNo' => $request->no_rekening,
                                'secret_key' => "Vpos71237577Inquiry"
                            ]
                        ]);
                        $responseCode = $getRek->getStatusCode();
                        $dataRekening = json_decode($getRek->getBody());
                        if ($dataRekening->responseCode == 2001600 ||$dataRekening->responseCode == "2001600"){    
                            RekeningAdmin::create([
                                'id_user' => auth()->user()->id,
                                'email' => auth()->user()->email,
                                'atas_nama' => $dataRekening->beneficiaryAccountName,
                                'nama_rekening' => $request->nama_rekening,
                                'nama_bank' => $request->nama_bank,
                                'swift_code' => $request->swift_code,
                                'no_rekening' => $dataRekening->beneficiaryAccountNo,
                            ]);
                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Anda telah sukses menambahkan rekening ". $request->nama_rekening." pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body);
                            $notification = array(
                                'message' => 'Rekening berhasil ditambahkan!',
                                'alert-type' => 'success',
                            );
                            return redirect()->route('admin.rekening.setting')->with($notification);
                        } else {
                            $action = "Admin Super User : Inquiry Rekening Fail";
                            $log = "Response from API : ".$dataRekening->responseCode;
                            $this->createHistoryUser($action, $log, 0);
                            $notification = array(
                                'message' => 'Cek rekening gagal, pastikan nomor rekening yang anda inputkan benar!',
                                'alert-type' => 'warning',
                            );
                            return redirect()->route('admin.rekening.setting')->with($notification);
                        }
                    } catch (Exception $e) {
                        $action = "Admin Super User : Add Rekening Fail";
                        $this->createHistoryUser($action, $e, 0);
                        $notification = array(
                            'message' => 'Cek rekening gagal!',
                            'alert-type' => 'error',
                        );
                        return redirect()->route('admin.rekening.setting')->with($notification);
                    }
                } else {
                    $notification = array(
                        'message' => 'Inputan rekening dan bank tidak boleh ada yang kosong!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->route('admin.rekening.setting')->with($notification);
                }
            }
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Update Rekening Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function rekeningListEdit($id){
        $rekening = RekeningAdmin::find($id);

        if(is_null($rekening) || empty($rekening)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('admin.rekening.setting')->with($notification);
        }

        $ip = "36.84.106.3";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $dataBankList = "";
        
        $rekClient = new GuzzleHttpClient();
        $urlRek = "https://erp.pt-best.com/api/rek_inquiry";
        try {
            $client = new GuzzleHttpClient();
            $url = 'https://erp.pt-best.com/api/testing-get-swift-code';
            $postResponse = $client->request('POST',  $url);
            $responseCode = $postResponse->getStatusCode();
            $data = json_decode($postResponse->getBody());
            $dataBankList = $data->bankSwiftList;

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
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Rekening Cek Error HTTP API";
            } else {
                $action = "Administrator : Rekening Cek Error HTTP API";
            }
            $this->createHistoryUser($action, $e, 0);
        }

        return view('admin.admin_rekening_setting', compact('rekening', 'dataBankList', 'dataRekening'));

    }

    public function rekeningSettingUpdate(Request $request){
        $kode = (int) $request->otp;
        $swift_code = $request->swift_code;
        $nama_bank = $request->nama_bank;
        $nomor_rekening = $request->no_rekening;
        $nama_rekening = $request->nama_rekening;
        $action = "";
        if(auth()->user()->access_level == 0){
            $action = "Admin Super User : Rekening Update";
        } else {
            $action = "Administrator : Rekening Update";
        }
        DB::connection()->enableQueryLog();
        try{
            $otp = (new Otp)->validate(auth()->user()->phone, $kode);
            if(!$otp->status){
                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                $rekening = RekeningAdmin::find($request->id);
                if(is_null($rekening) || empty($rekening)){
                    $notification = array(
                        'message' => 'Data tidak ditemukan!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->route('admin.rekening.setting')->with($notification);
                }
                if(!is_null($swift_code) && !is_null($rekening)){
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
                                'accountNo' => $nomor_rekening,
                                'secret_key' => "Vpos71237577Inquiry"
                            ]
                        ]);
                        $responseCode = $getRek->getStatusCode();
                        $dataRekening = json_decode($getRek->getBody());
                        if ($dataRekening->responseCode == 2001600 ||$dataRekening->responseCode == "2001600"){    
                            $rekening->update([
                                'atas_nama' => $dataRekening->beneficiaryAccountName,
                                'nama_bank' => $nama_bank,
                                'no_rekening' => $dataRekening->beneficiaryAccountNo,
                                'swift_code' => $swift_code,
                            ]);
                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Rekening untuk ".$nama_rekening." telah diupdate pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body);
                            $notification = array(
                                'message' => 'Update nomor rekening berhasil!',
                                'alert-type' => 'success',
                            );
                            return redirect()->route('admin.rekening.setting')->with($notification);
                        } else {
                            $action = "Admin Super User : Inquiry Rekening Fail";
                            $log = "Response from API : ".$dataRekening->responseCode;
                            $this->createHistoryUser($action, $log, 0);
                            $notification = array(
                                'message' => 'Cek rekening gagal, pastikan nomor rekening yang anda inputkan benar!',
                                'alert-type' => 'warning',
                            );
                            return redirect()->route('admin.rekening.setting')->with($notification);
                        }
                    } catch (Exception $e) {
                        $action = "Admin SUper User : Inquiry Fail";
                        $this->createHistoryUser($action, $e, 0);
                        $notification = array(
                            'message' => 'Cek rekening gagal!',
                            'alert-type' => 'error',
                        );
                        return redirect()->back()->with($notification);
                    }
                } else {
                    $notification = array(
                        'message' => 'Inputan rekening dan bank tidak boleh ada yang kosong!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->back()->with($notification);
                }
            }
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Update Rekening Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function adminWithdraw(){
        $adminQrisWallet = QrisWallet::select(['saldo'])->where('email', auth()->user()->email)->find(auth()->user()->id);
        $agregateWalletAplikasi = AgregateWallet::select(['saldo'])->find(1);
        $agregateWalletTransfer = AgregateWallet::select(['saldo'])->find(2);
        $rekening = RekeningAdmin::latest()->get();
        return view('admin.admin_withdraw', compact('adminQrisWallet', 'agregateWalletAplikasi', 'agregateWalletTransfer', 'rekening'));
    }

    public function adminWithdrawTarik(Request $request){
        DB::connection()->enableQueryLog();
        $ip = "125.164.243.227";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $wallet = "";
        $action = "";
        $biayaTransfer = 0;
        $dataRekening = "";

        $nominal_tarik = $request->nominal_tarik;
        $otp = $request->wa_otp;
        $jenis_tarik = $request->jenis_tarik;
        $rekening = $request->rekening;

        try{
            $otp = (new Otp)->validate(auth()->user()->phone, $otp);
            if(!$otp->status){
                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                $rekening = RekeningAdmin::where('id_user', auth()->user()->id)
                                            ->where('email', auth()->user()->email)
                                            ->find($rekening);
                if($jenis_tarik == "Qris"){
                    $wallet = QrisWallet::select(['saldo'])->where('email', auth()->user()->email)->find(auth()->user()->id);
                    $biayaTransferBank = BiayaAdminTransferDana::find(1);
                    $biayaTransferAgregate = BiayaAdminTransferDana::find(2);
                    $biayaTransfer = $biayaTransferBank->nominal+$biayaTransferAgregate->nominal;
                } else if($jenis_tarik == "Aplikasi"){
                    $wallet = AgregateWallet::select(['saldo'])->find(1);
                    $biayaTransferBank = BiayaAdminTransferDana::find(1);
                    $biayaTransferAgregate = BiayaAdminTransferDana::find(2);
                    $biayaTransfer = $biayaTransferBank->nominal+$biayaTransferAgregate->nominal;
                } else if($jenis_tarik == "Transfer"){
                    $wallet = AgregateWallet::select(['saldo'])->find(2);
                    $biayaTransferBank = BiayaAdminTransferDana::find(1);
                    $biayaTransfer = $biayaTransferBank->nominal;
                } else {
                    $notification = array(
                        'message' => 'Jenis saldo kosong!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->back()->with($notification);
                }

                if($wallet->saldo<$nominal_tarik){
                    $notification = array(
                        'message' => 'Saldo anda tidak mencukupi!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->back()->with($notification);
                } else {
                    if($nominal_tarik<10000){
                        $notification = array(
                            'message' => 'Minimal tarik dana Rp. 10.000!',
                            'alert-type' => 'warning',
                        );
                        return redirect()->back()->with($notification);
                    }
                    
                    $totalPenarikan = $nominal_tarik+$biayaTransfer;
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
                        if($dataRekening->responseMessage == "Inactive Account"){
                            $notification = array(
                                'message' => 'Rekening Error!, harap cek kembali apakah rekening sudah benar!',
                                'alert-type' => 'error',
                            );
                            return redirect()->route('admin.withdraw')->with($notification);
                        }
                        return view('admin.admin_form_cek_penarikan', compact(['dataRekening', 'rekening', 'nominal_tarik', 'totalPenarikan', 'jenis_tarik', 'biayaTransfer']));
                    } catch (Exception $e) {
                        if(auth()->user()->access_level == 0){
                            $action = "Admin Super User :Cek Rekening Error";
                        } else {
                            $action = "Administrator : Cek Rekening Error";
                        }
                        $this->createHistoryUser($action, $e, 0);
                        $notification = array(
                            'message' => 'Tarik dana error, harap hubungi admin!',
                            'alert-type' => 'error',
                        );
                        return redirect()->route('admin.withdraw')->with($notification);
                    }
                }
            }
        } catch(Exception $e){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Withdrawal Process Error";
            } else {
                $action = "Administrator : Withdrawal Process Error";
            }
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Penarikan dana gagal, harap hubungi admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function adminWithdrawTarikProcess(Request $request){
        $url = 'https://erp.pt-best.com/api/rek_transfer';
        $client = new GuzzleHttpClient();
        $ip = "125.164.243.227";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $wallet = "";
        $action = "";
        DB::connection()->enableQueryLog();
        $nominal_tarik = $request->nominal_penarikan;
        $jenis_tarik = $request->jenis_penarikan;
        $biayaTransferBank = "";
        $biayaTransferAgregate = "";
        $biayaTransfer = "";
        $wallet = "";
        $rekening_id = $request->id_rekening;
        $rekening = RekeningAdmin::select(['swift_code', 'no_rekening', 'id', 'atas_nama', 'nama_bank'])
                            ->where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->find($rekening_id);
        if($jenis_tarik == "Qris"){
            $wallet = QrisWallet::where('email', auth()->user()->email)->find(auth()->user()->id);
            $biayaTransferBank = BiayaAdminTransferDana::find(1);
            $biayaTransferAgregate = BiayaAdminTransferDana::find(2);
            $biayaTransfer = $biayaTransferBank->nominal+$biayaTransferAgregate->nominal;
        } else if($jenis_tarik == "Aplikasi"){
            $wallet = AgregateWallet::find(1);
            $biayaTransferBank = BiayaAdminTransferDana::find(1);
            $biayaTransferAgregate = BiayaAdminTransferDana::find(2);
            $biayaTransfer = $biayaTransferBank->nominal+$biayaTransferAgregate->nominal;
        } else if($jenis_tarik == "Transfer"){
            $wallet = AgregateWallet::find(2);
            $biayaTransferBank = BiayaAdminTransferDana::find(1);
            $biayaTransfer = $biayaTransferBank->nominal;
        } else {
            $notification = array(
                'message' => 'Jenis saldo kosong!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }

        try{
            $nominal_penarikan = filter_var($nominal_tarik, FILTER_SANITIZE_NUMBER_INT);
            $total_penarikan = filter_var($nominal_tarik+$biayaTransfer, FILTER_SANITIZE_NUMBER_INT);
            $saldo = $wallet->saldo;
            if($saldo < $total_penarikan){
                $notification = array(
                    'message' => 'Saldo anda tidak mencukupi!',
                    'alert-type' => 'warning',
                );
                return redirect()->route('admin.withdraw')->with($notification);
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
                        $jenis_penarikan = "Penarikan Dana ".$jenis_tarik." Admin Super User";
                        $withDraw = Withdrawal::create([
                            'id_user' => auth()->user()->id,
                            'id_rekening' => $rekening->id,
                            'email' => auth()->user()->email,
                            'jenis_penarikan' => $jenis_penarikan,
                            'tanggal_penarikan' => Carbon::now(),
                            'nominal' => $nominal_penarikan,
                            'biaya_admin' => $biayaTransfer,
                            'tanggal_masuk' => Carbon::now(),
                            'deteksi_ip_address' => $ip,
                            'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                            'status' => 1
                        ]);
 
                        if(!is_null($withDraw) || !empty($withDraw)){
                            RekeningWithdraw::create([
                                'id_penarikan' => $withDraw->id,
                                'atas_nama' => $rekening->atas_nama,
                                'nama_bank' => $rekening->nama_bank,
                                'no_rekening' => $rekening->no_rekening,
                            ]);
                            $wallet->update([
                                'saldo' => (int) $saldo-$total_penarikan
                            ]);
                            $transferFee = BiayaAdminTransferDana::get();
                            if($jenis_tarik == "Qris" || $jenis_tarik == "Aplikasi"){
                                $transferAgregate = $biayaTransferAgregate->nominal;
                                $walletTransfer = AgregateWallet::find(2);
                                $walletSaldoTransfer = $walletTransfer->saldo;
                                $walletTransfer->update([
                                    'saldo' => $transferAgregate+$walletSaldoTransfer
                                ]);
                                foreach($transferFee as $fee){
                                    if($fee->id == 1){
                                        DetailPenarikan::create([
                                            'id_penarikan' => $withDraw->id,
                                            'id_insentif' => $fee->id,
                                            'nominal' => $fee->nominal,
                                        ]);
                                    }

                                    if($fee->id == 2){
                                        DetailPenarikan::create([
                                            'id_penarikan' => $withDraw->id,
                                            'id_insentif' => $fee->id,
                                            'nominal' => $fee->nominal,
                                        ]);
                                    }
                                }
                            } else if($jenis_tarik == "Transfer"){
                                DetailPenarikan::create([
                                    'id_penarikan' => $withDraw->id,
                                    'id_insentif' => $biayaTransferBank->id,
                                    'nominal' => $biayaTransferBank->nominal,
                                ]);
                            }

                            NobuWithdrawFeeHistory::create([
                                'id_penarikan' => $withDraw->id,
                                'nominal' => 300
                            ]);

                            $action = "Admin Super User : Withdraw Success";

                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                            
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Penarikan dana saldo ".$jenis_tarik ." sebesar Rp. ".$nominal_penarikan." berhasil pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body);
                            
                            $notification = array(
                                'message' => 'Penarikan dana sukses!',
                                'alert-type' => 'success',
                            );
                            return redirect()->route('admin.dashboard.finance.withdraw.invoice', array('id' => $withDraw->id))->with($notification);
                        } else {
                            if(auth()->user()->access_level == 0){
                                $action = "Admin Super User : Withdrawal Process Error";
                            } else {
                                $action = "Administrator : Withdrawal Process Error";
                            }
                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
                            $notification = array(
                                'message' => 'Penarikan dana gagal, harap hubungi admin!',
                                'alert-type' => 'error',
                            );
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Penarikan dana saldo ".$jenis_tarik ." sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body);
                            return redirect()->route('admin.withdraw')->with($notification);
                        }
                    } else {
                        $withDraw = Withdrawal::create([
                            'id_user' => auth()->user()->id,
                            'email' => auth()->user()->email,
                            'tanggal_penarikan' => Carbon::now(),
                            'nominal' => $nominal_penarikan,
                            'biaya_admin' => $biayaTransfer,
                            'tanggal_masuk' => Carbon::now(),
                            'deteksi_ip_address' => $ip,
                            'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                            'status' => 0
                        ]);
                       
                        if(auth()->user()->access_level == 0){
                            $action = "Admin Super User : Withdrawal Transaction fail invalid";
                        } else {
                            $action = "Administrator : Withdrawal Transaction fail invalid";
                        }
                        $this->createHistoryUser($action, $responseMessage, 0);
                        $date = Carbon::now()->format('d-m-Y H:i:s');
                        $body = "Penarikan dana saldo ".$jenis_tarik ." sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                        $this->sendNotificationToUser($body);
                        $notification = array(
                            'message' => 'Penarikan dana gagal!',
                            'alert-type' => 'error',
                        );
                        return redirect()->route('admin.withdraw')->with($notification);
                    }
                } catch (Exception $e) {
                    if(auth()->user()->access_level == 0){
                        $action = "Admin Super User :  Withdraw Process | Error (HTTP API Error)";
                    } else {
                        $action = "Administrator :  Withdraw Process | Error (HTTP API Error)";
                    }
                    $this->createHistoryUser($action, $e, 0);
                    $date = Carbon::now()->format('d-m-Y H:i:s');
                    $body = "Penarikan dana saldo ".$jenis_tarik ." sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                    $this->sendNotificationToUser($body);
                    $notification = array(
                        'message' => 'Penarikan dana gagal!',
                        'alert-type' => 'error',
                    );
                    return redirect()->route('admin.withdraw')->with($notification);
                }
            }
        } catch (Exception $e){
            if(auth()->user()->access_level == 0){
                $action = "Admin Super User : Withdraw Process | Error";
            } else {
                $action = "Administrator : Withdraw Process | Error";
            }
            $this->createHistoryUser($action, $e, 0);
            $date = Carbon::now()->format('d-m-Y H:i:s');
            $body = "Penarikan dana saldo ".$jenis_tarik ." sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            $this->sendNotificationToUser($body);
            $notification = array(
                'message' => 'Penarikan dana gagal!',
                'alert-type' => 'error',
            );
            return redirect()->route('admin.withdraw')->with($notification);
        }
    }
}
