<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use GuzzleHttp\Client as GuzzleHttpClient;
use Ichtrojan\Otp\Otp;
use Twilio\Rest\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Marketing;
use App\Models\DetailMarketing;
use App\Models\Rekening;
use App\Models\History;
use App\Models\QrisWallet;
use App\Models\AgregateWallet;
use App\Models\DetailPenarikan;
use App\Models\NobuWithdrawFeeHistory;
use App\Models\BiayaAdminTransferDana;
use App\Models\Withdrawal;
use App\Models\RekeningWithdraw;
use App\Models\Admin;
use App\Models\Kasir;
use App\Models\Tenant;
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
        $environment = App::environment();
        $isDebug = config('app.debug');
        $user_id = auth()->user()->id;
        $user_email = auth()->user()->email;
        $ip_testing = "125.164.244.223";
        $ip_production = $this->get_client_ip();
        $PublicIP = "";
        $lat = "";
        $long = "";
        $user_location = "";
        if ($environment === 'production' && !$isDebug) {
            $PublicIP = $ip_production;
        } else if ($environment === 'local' && $isDebug) {
            $PublicIP = $ip_testing;
        }

        if(!is_null($PublicIP) || !empty($PublicIP)){
            $getLoc = Location::get($PublicIP);
            if(!is_null($getLoc->latitude) && !is_null($getLoc->longitude)){
                $lat = $getLoc->latitude;
                $long = $getLoc->longitude;
                $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";
            }
        }

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $PublicIP, $log, $status);
        }
    }

    private function sendNotificationToUser($body, $phone){
        $api_key    = getenv("WHATZAPP_API_KEY");
        $sender  = getenv("WHATZAPP_PHONE_NUMBER");
        $client = new GuzzleHttpClient();
        $postResponse = "";
        $noHP = $phone;
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
        if(is_null($postResponse) || empty($postResponse) || $postResponse == NULL || $postResponse == ""){
            $action = "Mitra Aplikasi Send User Notification";
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

    public function marketingSettings(){
        return view('marketing.marketing_settings');
    }

    public function profile(){
        $profilMarketing = Marketing::select(['marketings.id', 'marketings.name', 'marketings.email', 'marketings.phone', 'marketings.is_active', 'marketings.phone_number_verified_at', 'marketings.email_verified_at'])
                                ->with(['detail' => function($query){
                                    $query->select(['detail_marketings.id',
                                                    'detail_marketings.id_marketing',
                                                    'detail_marketings.no_ktp',
                                                    'detail_marketings.tempat_lahir',
                                                    'detail_marketings.tanggal_lahir',
                                                    'detail_marketings.jenis_kelamin',
                                                    'detail_marketings.alamat',
                                                    'detail_marketings.photo'])
                                            ->where('detail_marketings.id_marketing', auth()->user()->id)
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
        return view('marketing.marketing_profile', compact(['profilMarketing', 'rekening', 'qrisWallet']));
    }

    public function profileInfoUpdate(Request $request){
        DB::connection()->enableQueryLog();
        $action = "MItra Aplikasi : Profile Update";
        try{
            $profileInfo = DetailMarketing::find(auth()->user()->detail->id);
            $accountInfo = Marketing::find(auth()->user()->id);

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
                        $this->createHistoryUser($action, $e, 0);
                        $notification = array(
                            'message' => 'Error data gagal diupdate!',
                            'alert-type' => 'error',
                        );
                        return redirect()->back()->with($notification);
                    }
                } else {
                    try{
                        Storage::delete('public/images/profile/'.$profileInfo->detail->photo);
                        $file->move($storagePath, $filename);
                    } catch(Exception $e){
                        $this->createHistoryUser($action, $e, 0);
                    }
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

                $accountInfo->update([
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

                $accountInfo->update([
                    'name' => $request->name
                ]);
            }
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Error data gagal diupdate!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function phoneNumber(){
        return view('marketing.auth.marketing_phone_update');
    }

    public function phoneNumberSendOTP(Request $request){
        DB::connection()->enableQueryLog();
        $action = "";
        $api_key    = getenv("WHATZAPP_API_KEY");
        $sender  = getenv("WHATZAPP_PHONE_NUMBER");
        $client = new GuzzleHttpClient();
        $nohp = $request->no_wa;
        $hp = "";
        $postResponse = "";
        $otp = (new Otp)->generate($nohp, 'numeric', 6, 5);
        $body = "Berikut adalah kode OTP untuk mengubah nomor Whatsapp : "."*".$otp->token."*"."\n\n\n"."*Harap berhati-hati dan jangan membagikan kode OTP pada pihak manapun!, Admin dan Tim dari Visioner POS tidak akan pernah meminta OTP kepada User!*";
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
            $action = "Mitra Aplikasi : Send Whatsapp OTP Change Number Fail";
            $this->createHistoryUser($action, $ex, 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        if(is_null($postResponse) || empty($postResponse) || $postResponse == NULL || $postResponse == ""){
            $action = "Mitra Aplikasi : Send Whatsapp OTP Change Number Fail";
            $this->createHistoryUser(NULL, NULL, $action, "OTP Response NULL", 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification)->withInput();
        } else {
            $responseCode = $postResponse->getStatusCode();
            if(is_null($responseCode) || empty($responseCode)){
                $notification = array(
                    'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification)->withInput();
            }
            if($responseCode == 200){
                $action = "Mitra Aplikasi : Send Whatsapp OTP Change Number Success";
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                $notification = array(
                    'message' => 'OTP Sukses dikirim!',
                    'alert-type' => 'success',
                );
                return view('marketing.auth.marketing_change_number_form', compact(['nohp']))->with($notification);
            } else {
                $action = "Mitra Aplikasi : Send Whatsapp OTP Change Number Fail | Status : ".$responseCode;
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
                $notification = array(
                    'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }
        }
    }

    public function phoneNumberUpdate(Request $request){
        DB::connection()->enableQueryLog();
        $no_lama = auth()->user()->phone;
        $password = $request->password;
        $no_wa = $request->no_wa;
        $kode = $request->otp;
        $action = "";

        try{
            $otp = (new Otp)->validate($no_wa, $kode);
            if(!$otp->status){
                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                if(!Hash::check($password, auth::user()->password)){
                    $notification = array(
                        'message' => 'Password salah!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->back()->with($notification);
                }

                $checkAdminNumber = Admin::select(['phone'])->where('phone', $no_wa)->first();
                $checkMarketingNumber = Marketing::select(['phone'])->where('phone', $no_wa)->first();
                $checkTenantNumber = Tenant::select(['phone'])->where('phone', $no_wa)->first();
                $checkKasirNumber = Kasir::select(['phone'])->where('phone', $no_wa)->first();

                if(!is_null($checkAdminNumber) || !is_null($checkMarketingNumber) || !is_null($checkTenantNumber) || !is_null($checkKasirNumber)){
                    $notification = array(
                        'message' => 'Nomor telah terdaftar di sistem kami, harap gunakan nomor lain!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->back()->with($notification);
                } else {
                    $action = "Mitra Aplikasi : Change Phone Number Success";
                    $date = Carbon::now()->format('d-m-Y H:i:s');
                    $body = "Nomor Whatsapp akun Visioner anda akan diganti ke nomor ".$no_wa." pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                    $this->sendNotificationToUser($body, $no_lama);
                    Marketing::whereId(auth()->user()->id)->update([
                        'phone' => $no_wa,
                    ]);
                    $body = "Pergantian nomor akun Visioner ke nomor ".$no_wa." telah sukses dilakukan pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                    $this->sendNotificationToUser($body, $no_wa);
                    $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                    $notification = array(
                        'message' => 'Nomor Whatsapp berhasil diperbarui!',
                        'alert-type' => 'success',
                    );
                    return redirect()->route('marketing.profile')->with($notification);
                }

            }
        } catch(Exception $e){
            $action = "Mitra Aplikasi : Change Phone Number Error";
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Nomor Whatsapp Error, harap hubungi admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function password(){
        return view('marketing.auth.password_update');
    }

    public function passwordUpdate(Request $request){
        $action = "Mitra Aplikasi : Password Update";
        DB::connection()->enableQueryLog();
        $request->validate([
            'otp' => 'required',
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

                Marketing::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($request->new_password),
                ]);
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                $date = Carbon::now()->format('d-m-Y H:i:s');
                $body = "Password anda telah diubah pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                $this->sendNotificationToUser($body, auth()->user()->phone);
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

    public function whatsappNotificationTwilio(Request $request){
        $sid    = getenv("TWILIO_AUTH_SID");
        $token  = getenv("TWILIO_AUTH_TOKEN");
        $wa_from= getenv("TWILIO_WHATSAPP_FROM");
        $twilio = new Client($sid, $token);
        $resultMessage = "";
        $result = ['success' => false, 'data' => [], 'message' => ''];
        $nohp = auth()->user()->phone;
        $hp = "";
        if(!preg_match("/[^+0-9]/",trim($nohp))){
            if(substr(trim($nohp), 0, 2)=="62"){
                $hp    =trim($nohp);
            }
            else if(substr(trim($nohp), 0, 1)=="0"){
                $hp    ="62".substr(trim($nohp), 1);
            }
        }

        $otp = (new Otp)->generate(auth()->user()->phone, 'numeric', 6, 5);
        $body = "Berikut adalah kode OTP untuk akun VIsioner POS anda : "."*".$otp->token."*";
        try {
            $resultMessage = $twilio->messages->create("whatsapp:$hp",["from" => "whatsapp:$wa_from", "body" => $body]);
            $result['data'] = $resultMessage->toArray();
            if(!empty($result['data']['errorCode'])) {
                throw new Exception('Send SMS request failed');
            }
            $result['success'] = true;
            $result['message'] = 'SMS request success';
        } catch(Exception $ex){
            $result['success'] = false;
            $result['message'] = $ex->getMessage();
        }
        if($result['success']){
            $notification = array(
                'message' => 'OTP Sukses dikirim!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function whatsappNotification(){
        DB::connection()->enableQueryLog();
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
        } catch(Exception $ex){
            $action = "Mitra Aplikasi : Send Whatsapp OTP Fail";
            $this->createHistoryUser($action, $ex, 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
        $responseCode = $postResponse->getStatusCode();
        if(is_null($postResponse) || empty($postResponse) || is_null($responseCode) || empty($responseCode)){
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
        if($responseCode == 200){
            $action = "Mitra Aplikasi : Send Whatsapp OTP Success";
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'OTP Sukses dikirim!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } else {
            $action = "Mitra Aplikasi : Send Whatsapp OTP Fail | Status : ".$responseCode;
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

    }

    public function whatsappOTPSubmit(Request $request){
        $action = "Mitra Aplikasi : Whatsapp Number Verification Process";
        if(!empty(auth()->user()->phone_number_verified_at) || !is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at != NULL || auth()->user()->phone_number_verified_at != "") {
            return redirect()->route('marketing.dashboard');
        } else {
            $kode = (int) $request->otp;
            $otp = (new Otp)->validate(auth()->user()->phone, $kode);
            if(!$otp->status){
                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                $user = Marketing::find(auth()->user()->id);
                $user->update([
                    'phone_number_verified_at' => now()
                ]);
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                $notification = array(
                    'message' => 'Nomor anda telah diverifikasi!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            }
        }
    }
    public function rekeningSetting(Request $request){
        $rekening = Rekening::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $dataRekening = "";
        $action = "";
        if(!empty($rekening->no_rekening) || !is_null($rekening->no_rekening) || $rekening->no_rekening != NULL || $rekening->no_rekening != ""){
            $environment = App::environment();
            $isDebug = config('app.debug');
            $PublicIP = "";
            $lat = "";
            $long = "";
            $ip_testing = "125.164.244.223";
            $ip_production = $this->get_client_ip();
            if ($environment === 'production' && !$isDebug) {
                $PublicIP = $ip_production;
            } else if ($environment === 'local' && $isDebug) {
                $PublicIP = $ip_testing;
            }
    
            if(!is_null($PublicIP) || !empty($PublicIP)){
                $getLoc = Location::get($PublicIP);
                if(!is_null($getLoc->latitude) && !is_null($getLoc->longitude)){
                    $lat = $getLoc->latitude;
                    $long = $getLoc->longitude;
                }
            }
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
                $action = "Mitra Aplikasi : Rekening Cek Error HTTP API";
                $this->createHistoryUser($action, $e, 0);
            }
        }

        $client = new GuzzleHttpClient();
        $url = 'https://erp.pt-best.com/api/testing-get-swift-code';
        $postResponse = $client->request('POST',  $url);
        $responseCode = $postResponse->getStatusCode();
        $data = json_decode($postResponse->getBody());
        $dataBankList = $data->bankSwiftList;
        return view('marketing.marketing_rekening_setting', compact('rekening', 'dataBankList', 'dataRekening'));
    }

    public function rekeningSettingUpdate(Request $request){
        $kode = (int) $request->otp;
        $swift_code = $request->swift_code;
        $nama_bank = $request->nama_bank;
        $rekening = $request->no_rekening;
        $action = "Mitra Aplikasi : Rekening Update";
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
                $rekeningAkun = Rekening::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
                
                if(!is_null($swift_code) && !is_null($rekening)){
                    $environment = App::environment();
                    $isDebug = config('app.debug');
                    $PublicIP = "";
                    $lat = "";
                    $long = "";
                    $ip_testing = "125.164.244.223";
                    $ip_production = $this->get_client_ip();
                    if ($environment === 'production' && !$isDebug) {
                        $PublicIP = $ip_production;
                    } else if ($environment === 'local' && $isDebug) {
                        $PublicIP = $ip_testing;
                    }
            
                    if(!is_null($PublicIP) || !empty($PublicIP)){
                        $getLoc = Location::get($PublicIP);
                        if(!is_null($getLoc->latitude) && !is_null($getLoc->longitude)){
                            $lat = $getLoc->latitude;
                            $long = $getLoc->longitude;
                        }
                    }
                    $rekClient = new GuzzleHttpClient();
                    $urlRek = "https://erp.pt-best.com/api/rek_inquiry";
                    try {
                        $getRek = $rekClient->request('POST',  $urlRek, [
                            'form_params' => [
                                'latitude' => $lat,
                                'longitude' => $long,
                                'bankCode' => $swift_code,
                                'accountNo' => $rekening,
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
                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Rekening anda berhasil diupdate pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body, auth()->user()->phone);
                            $notification = array(
                                'message' => 'Update nomor rekening berhasil!',
                                'alert-type' => 'success',
                            );
                            return redirect()->back()->with($notification);
                        } else {
                            $action = "Mitra Aplikasi : Inquiry Rekening Fail";
                            $log = "Response from API : ".$dataRekening->responseCode;
                            $this->createHistoryUser($action, $log, 0);
                            $notification = array(
                                'message' => 'Cek rekening gagal, pastikan nomor rekening yang anda inputkan benar!',
                                'alert-type' => 'warning',
                            );
                            return redirect()->back()->with($notification);
                        }
                    } catch (Exception $e) {
                        if(auth()->user()->id_inv_code == 0){
                            $action = "Mitra Bisnis : Rekening Inquiry Fail";
                        } else {
                            $action = "Tenant : Rekening Inquiry Fail";
                        }
                        $this->createHistoryUser($action, $e, 0);
                        $notification = array(
                            'message' => 'Cek rekening gagal, harap hubungi admin!',
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

    public function withdraw(){
        $qrisWallet = QrisWallet::select(['saldo'])
                                ->where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $rekening = Rekening::select([
                                'rekenings.nama_bank',
                                'rekenings.swift_code',
                                'rekenings.no_rekening',
                            ])
                            ->where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();

        $biayaAdmin = BiayaAdminTransferDana::sum('nominal');
        $dataRekening = "";
        $action = "";
        if(!empty($rekening->no_rekening) || !is_null($rekening->no_rekening) || $rekening->no_rekening != NULL || $rekening->no_rekening != ""){
            $environment = App::environment();
            $isDebug = config('app.debug');
            $PublicIP = "";
            $lat = "";
            $long = "";
            $ip_testing = "125.164.244.223";
            $ip_production = $this->get_client_ip();
            if ($environment === 'production' && !$isDebug) {
                $PublicIP = $ip_production;
            } else if ($environment === 'local' && $isDebug) {
                $PublicIP = $ip_testing;
            }
    
            if(!is_null($PublicIP) || !empty($PublicIP)){
                $getLoc = Location::get($PublicIP);
                if(!is_null($getLoc->latitude) && !is_null($getLoc->longitude)){
                    $lat = $getLoc->latitude;
                    $long = $getLoc->longitude;
                }
            }
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
                $action = "Mitra Aplikasi : Rekening Inquiry Fail";
                $this->createHistoryUser($action, $e, 0);
            }
        }

        return view('marketing.marketing_withdraw', compact('qrisWallet', 'dataRekening', 'rekening', 'biayaAdmin'));
    }

    public function withdrawProcess(Request $request){
        DB::connection()->enableQueryLog();        
        $otp = $request->wa_otp;
        try{
            $otp = (new Otp)->validate(auth()->user()->phone, $otp);
            if(!$otp->status){
                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                $nominal_tarik = $request->nominal_tarik_dana;
                // $total_tarik = (int) str_replace(['.', ' ', 'Rp'], '', $request->total_tarik);

                $transferFee = BiayaAdminTransferDana::get();
                $biayaAdmin = $transferFee->sum('nominal');

                $qrisMarketing = QrisWallet::where('id_user', auth()->user()->id)
                                            ->where('email', auth()->user()->email)
                                            ->first();
                                            
                $total_tarik_dana = $nominal_tarik+$biayaAdmin;

                if($nominal_tarik<10000){
                    $notification = array(
                        'message' => 'Minimal tarik dana Rp. 10.000!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->back()->with($notification);
                } else {
                    if($qrisMarketing->saldo<$total_tarik_dana){
                        $notification = array(
                            'message' => 'Saldo anda tidak mencukupi untuk melakukan proses penarikan!',
                            'alert-type' => 'warning',
                        );
                        return redirect()->back()->with($notification);
                    } else {
                        $transfer = "";
                        $transfer = $this->prosesTarikDanaMarketing($nominal_tarik, $total_tarik_dana);

                        if(!is_null($transfer) || !empty($transfer) || $transfer != "" || $transfer != NULL){
                            if($transfer != 0) {
                                $notification = array(
                                    'message' => 'Penarikan dana sukses!',
                                    'alert-type' => 'success',
                                );
                                return redirect()->route('marketing.finance.history_penarikan.invoice', array('id' => $transfer))->with($notification);
                            } else {
                                $notification = array(
                                    'message' => 'Penarikan dana gagal, harap hubungi admin!',
                                    'alert-type' => 'error',
                                );
                                return redirect()->route('marketing.withdraw')->with($notification);
                            }
                        } else {
                            $notification = array(
                                'message' => 'Penarikan dana gagal, harap hubungi admin!',
                                'alert-type' => 'warning',
                            );
                            return redirect()->route('marketing.withdraw')->with($notification);
                        }
                    }
                }
                
            }
        } catch(Exception $e){
            $action = "Mitra Aplikasi : Withdrawal Process Error | OTP Error Problem";
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Penarikan dana gagal, harap hubungi admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    private function prosesTarikDanaMarketing($nominal_tarik, $total_tarik){
        $url = 'https://erp.pt-best.com/api/rek_transfer';
        $client = new GuzzleHttpClient();
        $environment = App::environment();
        $isDebug = config('app.debug');
        $PublicIP = "";
        $lat = "";
        $long = "";
        $ip_testing = "125.164.244.223";
        $ip_production = $this->get_client_ip();
        if ($environment === 'production' && !$isDebug) {
            $PublicIP = $ip_production;
        } else if ($environment === 'local' && $isDebug) {
            $PublicIP = $ip_testing;
        }
        if(!is_null($PublicIP) || !empty($PublicIP)){
            $getLoc = Location::get($PublicIP);
            if(!is_null($getLoc->latitude) && !is_null($getLoc->longitude)){
                $lat = $getLoc->latitude;
                $long = $getLoc->longitude;
            }
        }
        $transferFee = BiayaAdminTransferDana::get();
        $biayaAdmin = $transferFee->sum('nominal');
        $aplikator = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Admin')->first();
        $mitra = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Mitra Aplikasi')->first();
        $agregateMaintenance = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Agregate Server')->first();
        $agregateTransfer = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Transfer')->first();
        DB::connection()->enableQueryLog();

        $rekeningMarketing = Rekening::select(['swift_code', 'no_rekening', 'id', 'nama_bank', 'atas_nama'])
                                    ->where('id_user', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->first();
        $qrisWalletMarketing = QrisWallet::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
        $agregateWalletforMaintenance = AgregateWallet::find(1);
        $agregateWalletforTransfer = AgregateWallet::find(2);
        $qrisAdmin = QrisWallet::where('email', 'adminsu@visipos.id')->find(1);
        $agregateSaldoforMaintenance = $agregateWalletforMaintenance->saldo;
        $agregateSaldoforTransfer = $agregateWalletforTransfer->saldo;

        try{
            $nominal_penarikan = filter_var($nominal_tarik, FILTER_SANITIZE_NUMBER_INT);
            $total_penarikan = filter_var($total_tarik, FILTER_SANITIZE_NUMBER_INT);
            $saldoMarketing = $qrisWalletMarketing->saldo;
            if($saldoMarketing < $total_penarikan){
                $notification = array(
                    'message' => 'Saldo anda tidak mencukupi!',
                    'alert-type' => 'warning',
                );
                return redirect()->route('marketing.profile')->with($notification);
            } else {
                try {
                    $postResponse = $client->request('POST',  $url, [
                        'form_params' => [
                            'latitude' => $lat,
                            'longitude' => $long,
                            'bankCode' => $rekeningMarketing->swift_code,
                            'accountNo' => $rekeningMarketing->no_rekening,
                            'amount' => $nominal_penarikan,
                            'secret_key' => "Vpos71237577Transfer"
                        ]
                    ]);
                    $responseCode = $postResponse->getStatusCode();
                    $data = json_decode($postResponse->getBody());
                    $responseCode = $data->responseCode;
                    $responseMessage = $data->responseMessage;
                    if($responseCode == 2001800 && $responseMessage == "Request has been processed successfully") {
                        $jenis_penarikan = "Penarikan Dana Mitra Aplikasi";
                        $withDraw = Withdrawal::create([
                            'id_user' => auth()->user()->id,
                            'id_rekening' => $rekeningMarketing->id,
                            'email' => auth()->user()->email,
                            'jenis_penarikan' => $jenis_penarikan,
                            'tanggal_penarikan' => Carbon::now(),
                            'nominal' => $nominal_penarikan,
                            'biaya_admin' => $biayaAdmin,
                            'tanggal_masuk' => Carbon::now(),
                            'deteksi_ip_address' => $PublicIP,
                            'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                            'status' => 1
                        ]);

                        if(!is_null($withDraw) || !empty($withDraw)){
                            RekeningWithdraw::create([
                                'id_penarikan' => $withDraw->id,
                                'atas_nama' => $rekeningMarketing->atas_nama,
                                'nama_bank' => $rekeningMarketing->nama_bank,
                                'no_rekening' => $rekeningMarketing->no_rekening,
                            ]);
                            $qrisWalletMarketing->update([
                                'saldo' => $saldoMarketing-$total_penarikan
                            ]);
                            $adminSaldo = $qrisAdmin->saldo;
                            $qrisAdmin->update([
                                'saldo' => $adminSaldo+$aplikator->nominal+$mitra->nominal
                            ]);
                            
                            $agregateWalletforMaintenance->update([
                                'saldo' =>$agregateSaldoforMaintenance+$agregateMaintenance->nominal
                            ]);

                            $agregateWalletforTransfer->update([
                                'saldo' =>$agregateSaldoforTransfer+$agregateTransfer->nominal
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

                            $action = "Mitra Aplikasi : Withdrawal Success";
                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                            
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Penarikan dana Mitra Aplikasi sebesar *Rp. ".$nominal_tarik."* ke rekening bank *".$rekeningMarketing->nama_bank."* atas nama *".$rekeningMarketing->atas_nama."* ke rekenung tujuan *".$rekeningMarketing->no_rekening."* sukses pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body, auth()->user()->phone);
                            
                            return $withDraw->id;
                        } else {
                            $action = "Mitra Aplikasi : Withdrawal Process Error";
                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Penarikan saldo sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body, auth()->user()->phone);
                            
                            return 0;
                        }
                    } else {
                        $withDraw = Withdrawal::create([
                            'id_user' => auth()->user()->id,
                            'email' => auth()->user()->email,
                            'tanggal_penarikan' => Carbon::now(),
                            'nominal' => $nominal_penarikan,
                            'biaya_admin' => $biayaAdmin,
                            'tanggal_masuk' => Carbon::now(),
                            'deteksi_ip_address' => $PublicIP,
                            'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                            'status' => 0
                        ]);
                        $action = "Mitra Aplikasi : Withdrawal Transaction fail invalid";
                        $this->createHistoryUser($action, $responseMessage, 0);
                        $date = Carbon::now()->format('d-m-Y H:i:s');
                        $body = "Penarikan saldo sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                        $this->sendNotificationToUser($body, auth()->user()->phone);
                        
                        return 0;
                    }
                } catch (Exception $e) {
                    $action = "Mitra Aplikasi : Withdraw Process | Error (HTTP API Error)";
                    $this->createHistoryUser($action, $e, 0);
                    $date = Carbon::now()->format('d-m-Y H:i:s');
                    $body = "Penarikan saldo sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                    $this->sendNotificationToUser($body, auth()->user()->phone);
                    
                    return 0;
                }
            }
        } catch (Exception $e){
            $action = "Mitra Aplikasi : Withdraw Process | Error";
            $this->createHistoryUser($action, $e, 0);
            $date = Carbon::now()->format('d-m-Y H:i:s');
            $body = "Penarikan saldo sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            $this->sendNotificationToUser($body, auth()->user()->phone);
            
            return 0;
        }
    }

    public function ipTesting(){
        $PublicIP = $this->get_client_ip();
        $ip = "180.254.52.209";
        $getLoc = Location::get($ip);
        return $getLoc->latitude;
    }
}
