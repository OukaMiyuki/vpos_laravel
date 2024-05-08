<?php

namespace App\Http\Controllers\Auth\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
use App\Models\RekeningMarketing;

class ProfileController extends Controller {
    public function marketingSettings(){
        return view('marketing.marketing_settings');
    }

    public function profile(){
        return view('marketing.marketing_profile');
    }

    public function profileAccountUpdate(Request $request){
        $profileInfo = Marketing::find(auth()->user()->id);

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

    public function profileInfoUpdate(Request $request){
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

            $accountInfo->update([
                'name' => $request->name
            ]);

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);

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

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function password(){
        return view('marketing.auth.password_update');
    }

    public function passwordUpdate(Request $request){
        $request->validate([
            'otp' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

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
    
            $notification = array(
                'message' => 'Password berhasil diperbarui!',
                'alert-type' => 'success',
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
                'message' => 'OTP Gagal dikirim!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
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
        if(!empty(auth()->user()->phone_number_verified_at) || !is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at != NULL || auth()->user()->phone_number_verified_at != "") {
            return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD);
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
                $notification = array(
                    'message' => 'Nomor anda telah diverifikasi!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            }
        }
    }
    public function rekeningSetting(Request $request){
        $rekening = RekeningMarketing::where('id_marketing', auth()->user()->id)->first();
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
        return view('marketing.marketing_rekening_setting', compact('rekening', 'dataBankList', 'dataRekening'));
    }

    public function rekeningSettingUpdate(Request $request){
        $kode = (int) $request->otp;
        $swift_code = $request->swift_code;
        $rekening = $request->no_rekening;

        $otp = (new Otp)->validate(auth()->user()->phone, $kode);
        if(!$otp->status){
            $notification = array(
                'message' => 'OTP salah atau tidak sesuai!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        } else {
            $rekeningAkun = RekeningMarketing::where('id_marketing', auth()->user()->id)->first();
            $rekeningAkun->update([
                'no_rekening' => $rekening,
                'swift_code' => $swift_code,
                'is_confirmed' => 1
            ]);
            $notification = array(
                'message' => 'Update nomor rekening berhasil!',
                'alert-type' => 'success',
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

    public function ipTesting(){
        $PublicIP = $this->get_client_ip();
        $ip = "180.254.52.209";
        $getLoc = Location::get($ip);
        return $getLoc->latitude;
        // $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
        // $json     = json_decode($json, true);
        // $country  = $json['country'];
        // $region   = $json['region'];
        // $city     = $json['loc'];

        // return $city;
    }
}
