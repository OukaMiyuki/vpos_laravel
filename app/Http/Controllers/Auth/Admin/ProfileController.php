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

    public function rekeningSetting(){
        $rekening = Rekening::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $dataRekening = "";
        $action = "";
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
                if(auth()->user()->access_level == 0){
                    $action = "Admin Super User : Rekening Cek Error HTTP API";
                } else {
                    $action = "Administrator : Rekening Cek Error HTTP API";
                }
                $this->createHistoryUser($action, $e, 0);
            }
        }

        $client = new GuzzleHttpClient();
        $url = 'https://erp.pt-best.com/api/testing-get-swift-code';
        $postResponse = $client->request('POST',  $url);
        $responseCode = $postResponse->getStatusCode();
        $data = json_decode($postResponse->getBody());
        $dataBankList = $data->bankSwiftList;
        return view('admin.admin_rekening_setting', compact('rekening', 'dataBankList', 'dataRekening'));
    }

    public function rekeningSettingUpdate(Request $request){
        $kode = (int) $request->otp;
        $swift_code = $request->swift_code;
        $nama_bank = $request->nama_bank;
        $rekening = $request->no_rekening;
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
                $rekeningAkun = Rekening::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
                $rekeningAkun->update([
                    'no_rekening' => $rekening,
                    'nama_bank' => $nama_bank,
                    'swift_code' => $swift_code,
                ]);
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                $notification = array(
                    'message' => 'Update nomor rekening berhasil!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
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
        $agregateWallet = AgregateWallet::select(['saldo'])->first();
        return view('admin.admin_withdraw', compact('adminQrisWallet', 'agregateWallet'));
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

        $nominal_tarik = $request->nominal_tarik;
        $otp = $request->wa_otp;
        $jenis_tarik = $request->jenis_tarik;

        try{
            $otp = (new Otp)->validate(auth()->user()->phone, $otp);
            if(!$otp->status){
                $notification = array(
                    'message' => 'OTP salah atau tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                if($jenis_tarik == "Qris"){
                    $wallet = QrisWallet::select(['saldo'])
                                            ->where('email', auth()->user()->email)
                                            ->find(auth()->user()->id);
                } else if($jenis_tarik == "Agregate"){
                    $wallet = AgregateWallet::select(['saldo'])->first();
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

                    $rekening = Rekening::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
                    $totalPenarikan = $nominal_tarik+300;
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
                        return view('admin.admin_form_cek_penarikan', compact(['dataRekening', 'rekening', 'nominal_tarik', 'totalPenarikan', 'jenis_tarik']));
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
                        return redirect()->back()->with($notification);
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
        $total_tarik = $request->total_tarik;
        $biaya_admin = $request->biaya_admin;
        $jenis_tarik = $request->jenis_penarikan;
        $rekening = Rekening::select(['swift_code', 'no_rekening'])
                            ->where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        if($jenis_tarik == "Qris"){
            $wallet = QrisWallet::where('id_user', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->first();
        } else if($jenis_tarik == "Agregate"){
            $wallet = AgregateWallet::first();
        } else {
            $notification = array(
                'message' => 'Jenis saldo kosong!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }

        try{
            $nominal_penarikan = filter_var($nominal_tarik, FILTER_SANITIZE_NUMBER_INT);
            $total_penarikan = $total_tarik;
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
                        $withDraw = Withdrawal::create([
                            'id_user' => auth()->user()->id,
                            'email' => auth()->user()->email,
                            'jenis_penarikan' => $jenis_tarik,
                            'tanggal_penarikan' => Carbon::now(),
                            'nominal' => $nominal_penarikan,
                            'biaya_admin' => $biaya_admin,
                            'tanggal_masuk' => Carbon::now(),
                            'deteksi_ip_address' => $ip,
                            'deteksi_lokasi_penarikan' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                            'status' => 1
                        ]);

                        if(!is_null($withDraw) || !empty($withDraw)){
                            $wallet->update([
                                'saldo' => (int) $saldo-$total_penarikan
                            ]);

                            DetailPenarikan::create([
                                'id_penarikan' => $withDraw->id,
                                'nominal_penarikan' => $total_penarikan,
                                'nominal_bersih_penarikan' => $nominal_penarikan,
                                'total_biaya_admin' => $biaya_admin,
                                'biaya_nobu' => 300,
                                'biaya_mitra' => NULL,
                                'biaya_tenant' => NULL,
                                'biaya_admin_su' => NULL,
                                'biaya_agregate' => NULL
                            ]);

                            NobuWithdrawFeeHistory::create([
                                'id_penarikan' => $withDraw->id,
                                'nominal' => 300
                            ]);

                            if(auth()->user()->access_level == 0){
                                $action = "Admin Super User : Update Profile";
                            } else {
                                $action = "Administrator : Update Profile";
                            }

                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

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
                            return redirect()->route('admin.withdraw')->with($notification);
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
                            'biaya_tenant' => NULL,
                            'biaya_admin_su' => NULL,
                            'biaya_agregate' => NULL
                        ]);
                        if(auth()->user()->access_level == 0){
                            $action = "Admin Super User : Withdrawal Transaction fail invalid";
                        } else {
                            $action = "Administrator : Withdrawal Transaction fail invalid";
                        }
                        $this->createHistoryUser($action, $responseMessage, 0);
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
            $notification = array(
                'message' => 'Penarikan dana gagal!',
                'alert-type' => 'error',
            );
            return redirect()->route('admin.withdraw')->with($notification);
        }
    }
}
