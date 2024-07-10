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
use App\Models\Admin;
use App\Models\Marketing;
use App\Models\Kasir;
use App\Models\DetailTenant;
use App\Models\StoreDetail;
use App\Models\UmiRequest;
use App\Mail\SendUmiEmail;
use App\Models\History;
use App\Models\Rekening;
use App\Models\QrisWallet;
use App\Models\Withdrawal;
use App\Models\NobuWithdrawFeeHistory;
use App\Models\BiayaAdminTransferDana;
use App\Models\DetailPenarikan;
use App\Models\AgregateWallet;
use App\Models\InvitationCode;
use App\Models\RekeningWithdraw;
use App\Models\MDR;
use App\Models\TenantQrisAccount;
use File;
use Mail;
use Exception;

class ProfileController extends Controller{
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
        $getLoc = Location::get($PublicIP);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $PublicIP, $log, $status);
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

    public function tenantSettings(){
        return view('tenant.tenant_settings');
    }

    public function helpSupport(){
        if(auth()->user()->id_inv_code != 0){
            $kontakMarketing = InvitationCode::select([
                                                'invitation_codes.id',
                                                'invitation_codes.id_marketing',
                                                'invitation_codes.inv_code',
                                                'invitation_codes.holder',
                                            ])
                                            ->with([
                                                'marketing' => function($query){
                                                    $query->select([
                                                        'marketings.id',
                                                        'marketings.name',
                                                        'marketings.phone'
                                                    ]);
                                                }
                                            ])
                                            ->find(auth()->user()->id_inv_code);
            $marketingPhone = "";
            if(!preg_match("/[^+0-9]/",trim($kontakMarketing->marketing->phone))){
                if(substr(trim($kontakMarketing->marketing->phone), 0, 2)=="62"){
                    $marketingPhone    =trim($kontakMarketing->marketing->phone);
                }
                else if(substr(trim($kontakMarketing->marketing->phone), 0, 1)=="0"){
                    $marketingPhone    ="62".substr(trim($kontakMarketing->marketing->phone), 1);
                }
            }
            return view('tenant.tenant_help', compact('kontakMarketing', 'marketingPhone'));
        }
    }

    public function helpUMI(){
        $mdr = MDR::get();
        return view('tenant.tenant_help_umi', compact('mdr'));
    }

    public function helpUMIMitra(){
        $mdr = MDR::where('presentase_minimal_mdr', '!=', 0)->get();
        return view('tenant.tenant_mitra.tenant_mitra_help_umi', compact('mdr'));
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
                                                    'detail_tenants.photo',
                                                    'detail_tenants.nama_perusahaan',
                                                    'detail_tenants.ktp_image'])
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

    public function profileInfoUpdate(Request $request){
        $action = "";
        if(auth()->user()->id_inv_code == 0){
            $action = "Mitra Bisnis : Update Profile";
        } else {
            $action = "Tenant : Update Profile";
        }
        DB::connection()->enableQueryLog();
        try {
            $profileInfo = DetailTenant::where('id_tenant', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->find(auth()->user()->detail->id);
            $account = Tenant::where('id', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
            $filenamektp = auth()->user()->detail->ktp_image;
            if($request->hasFile('ktp-image')){
                $fileKtp = $request->file('ktp-image');
                $nama = auth()->user()->name;
                $storagePathKto = Storage::path('public/images/profile');
                $extKtp = $fileKtp->getClientOriginalExtension();
                $filenamektp = $nama.'-'.time().'.'.$extKtp;

                $ktpImage = auth()->user()->detail->ktp_image;
                if(empty($ktpImage)){
                    try{
                        $fileKtp->move($storagePathKto, $filenamektp);
                    } catch(Exception $e){
                        return "gakdihapus  ".$e;
                    }
                } else {
                    try{
                        Storage::delete('public/images/profile/'.$ktpImage);
                        $fileKtp->move($storagePathKto, $filenamektp);
                    } catch(Exception $e){
                        return "dihapus  ".$e;
                    }
                }
            }

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

                if(auth()->user()->id_inv_code == 0){
                    $profileInfo->update([
                        'no_ktp' => $request->no_ktp,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'alamat' => $request->alamat,
                        'photo' => $filename,
                        'nama_perusahaan' => $request->nama_perusahaan,
                        'updated_at' => Carbon::now(),
                        'ktp_image' => $filenamektp
                    ]);
                } else {
                    $profileInfo->update([
                        'no_ktp' => $request->no_ktp,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'alamat' => $request->alamat,
                        'photo' => $filename,
                        'updated_at' => Carbon::now(),
                        'ktp_image' => $filenamektp
                    ]);
                }

                $account->update([
                    'name' => $request->name
                ]);

            } else {
                if(auth()->user()->id_inv_code == 0){
                    $profileInfo->update([
                        'no_ktp' => $request->no_ktp,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'nama_perusahaan' => $request->nama_perusahaan,
                        'alamat' => $request->alamat,
                        'updated_at' => Carbon::now(),
                        'ktp_image' => $filenamektp
                    ]);
                } else {
                    $profileInfo->update([
                        'no_ktp' => $request->no_ktp,
                        'tempat_lahir' => $request->tempat_lahir,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'alamat' => $request->alamat,
                        'updated_at' => Carbon::now(),
                        'ktp_image' => $filenamektp
                    ]);
                }

                $account->update([
                    'name' => $request->name
                ]);
            }

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch (Exception $e) {
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Error data gagal diupdate!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function phoneNumber(){
        return view('tenant.auth.tenant_phone_update');
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
            if(auth()->user()->id_inv_code == 0){
                $action = "Mitra Bisnis : Send Whatsapp OTP Change Number Fail";
            } else {
                $action = "Tenant : Send Whatsapp OTP Change Number Fail";
            }
            $this->createHistoryUser($action, $ex, 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        if(is_null($postResponse) || empty($postResponse) || $postResponse == NULL || $postResponse == ""){
            if(auth()->user()->id_inv_code == 0){
                $action = "Mitra Bisnis : Send Whatsapp OTP Change Number Fail";
            } else {
                $action = "Tenant : Send Whatsapp OTP Change Number Fail";
            }
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
                if(auth()->user()->id_inv_code == 0){
                    $action = "Mitra Bisnis : Send Whatsapp OTP Change Number Success";
                } else {
                    $action = "Tenant : Send Whatsapp OTP Change Number Success";
                }
                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                $notification = array(
                    'message' => 'OTP Sukses dikirim!',
                    'alert-type' => 'success',
                );
                return view('tenant.auth.tenant_change_number_form', compact(['nohp']))->with($notification);
            } else {
                if(auth()->user()->id_inv_code == 0){
                    $action = "Mitra Bisnis : Send Whatsapp OTP Change Number Fail | Status : ".$responseCode;
                } else {
                    $action = "Tenant : Send Whatsapp OTP Change Number Fail | Status : ".$responseCode;
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
                    if(auth()->user()->id_inv_code == 0){
                        $action = "Mitra Bisnis : Change Phone Number Success";
                    } else {
                        $action = "Tenant : Change Phone Number Success";
                    }
                    $date = Carbon::now()->format('d-m-Y H:i:s');
                    $body = "Nomor Whatsapp akun Visioner anda akan diganti ke nomor ".$no_wa." pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                    $this->sendNotificationToUser($body, $no_lama);
                    Tenant::whereId(auth()->user()->id)->update([
                        'phone' => $no_wa,
                    ]);
                    $body = "Pergantian nomor akun Visioner ke nomor ".$no_wa." telah sukses dilakukan pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                    $this->sendNotificationToUser($body, $no_wa);
                    $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                    $notification = array(
                        'message' => 'Nomor Whatsapp berhasil diperbarui!',
                        'alert-type' => 'success',
                    );
                    return redirect()->route('tenant.profile')->with($notification);
                }

            }
        } catch(Exception $e){
            if(auth()->user()->id_inv_code == 0){
                $action = "Mitra Bisnis : Change Phone Number Error";
            } else {
                $action = "Tenant : Change Phone Number Error";
            }
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Nomor Whatsapp Error, harap hubungi admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function password(){
        return view('tenant.auth.password_update');
    }

    public function passwordUpdate(Request $request){
        $action = "";
        if(auth()->user()->id_inv_code == 0){
            $action = "Mitra Bisnis : Update Password";
        } else {
            $action = "Tenant : Update Password";
        }
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

                Tenant::whereId(auth()->user()->id)->update([
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
        } catch (Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Update Password Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function storeProfileSettings(){
        $tenantStore = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->with(['tenantQrisAccount'])
                                ->where('email', auth()->user()->email)
                                ->first();
        return view('tenant.tenant_store_detail', compact('tenantStore'));
    }

    public function storeProfileSettingsUPdate(Request $request) {
        $action = "Tenant : Store Profile Update";
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

            // $fileKtp = $request->file('ktp-image');
            // $nama = auth()->user()->name;
            // $storagePathKto = Storage::path('public/images/profile');
            // $extKtp = $fileKtp->getClientOriginalExtension();
            // $filenamektp = $nama.'-'.time().'.'.$extKtp;

            // if(empty($tenantStore->ktp_image)){
            //     $fileKtp->move($storagePathKto, $filenamektp);
            // } else {
            //     Storage::delete('public/images/profile/'.$tenantStore->ktp_image);
            //     $fileKtp->move($storagePathKto, $filenamektp);
            // }

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
                    'no_npwp' => $request->no_npwp,
                    'alamat' => $request->alamat,
                    'nama_jalan' => $request->nama_jalan,
                    'nama_blok' => $request->nama_blok,
                    'rt' => $request->rt,
                    'rw' => $request->rw,
                    'kelurahan_desa' => $request->kelurahan_desa,
                    'kecamatan' => $request->kecamatan,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                    'kantor_toko_fisik' => $request->kantor_toko_fisik,
                    'kategori_usaha_omset' => $request->kategori_usaha_omset,
                    'catatan_kaki' => $request->catatan,
                    'website' => $request->website,
                    'photo' => $filename,
                ]);
            } else {
                $tenantStore->update([
                    'name' => $request->name,
                    'no_npwp' => $request->no_npwp,
                    'alamat' => $request->alamat,
                    'nama_jalan' => $request->nama_jalan,
                    'nama_blok' => $request->nama_blok,
                    'rt' => $request->rt,
                    'rw' => $request->rw,
                    'kelurahan_desa' => $request->kelurahan_desa,
                    'kecamatan' => $request->kecamatan,
                    'kabupaten' => $request->kabupaten,
                    'kode_pos' => $request->kode_pos,
                    'no_telp_toko' => $request->no_telp,
                    'jenis_usaha' => $request->jenis,
                    'kantor_toko_fisik' => $request->kantor_toko_fisik,
                    'kategori_usaha_omset' => $request->kategori_usaha_omset,
                    'catatan_kaki' => $request->catatan,
                    'website' => $request->website,
                ]);
            }

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data berhasil diperbarui!',
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

    public function rekeingSetting(){
        $rekening = Rekening::select([
                                'rekenings.atas_nama',
                                'rekenings.nama_bank',
                                'rekenings.swift_code',
                                'rekenings.no_rekening',
                            ])
                            ->where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $dataRekening = "";
        $action = "";
        if(!empty($rekening->no_rekening) || !is_null($rekening->no_rekening) || $rekening->no_rekening != NULL || $rekening->no_rekening != ""){
            $ip = "36.84.106.3";
            $PublicIP = $this->get_client_ip();
            $getLoc = Location::get($PublicIP);
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
                if(auth()->user()->id_inv_code == 0){
                    $action = "Mitra Bisnis : Rekening Inquiry Fail";
                } else {
                    $action = "Tenant : Rekening Inquiry Fail";
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
        //dd($data->bankSwiftList);
        return view('tenant.tenant_rekening_setting', compact('rekening', 'dataBankList', 'dataRekening'));
    }

    public function rekeningSettingUpdate(Request $request){
        $kode = (int) $request->otp;
        $swift_code = $request->swift_code;
        $rekening = $request->no_rekening;
        $nama_bank = $request->nama_bank;
        $atas_nama = $request->atas_nama;

        $action = "";
        if(auth()->user()->id_inv_code == 0){
            $action = "Mitra Bisnis : Update Profile";
        } else {
            $action = "Tenant : Update Profile";
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

                if(!is_null($swift_code) && !is_null($rekening)){
                    $ip = "36.84.106.3";
                    $PublicIP = $this->get_client_ip();
                    $getLoc = Location::get($PublicIP);
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
                            $this->sendNotificationToUser($body);
                            $notification = array(
                                'message' => 'Update nomor rekening berhasil!',
                                'alert-type' => 'success',
                            );
                            return redirect()->back()->with($notification);
                        } else {
                            $action = "Tenant : Inquiry Rekening Fail";
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
        } catch(Exception $e) {
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
            $ip = "36.84.106.3";
            $PublicIP = $this->get_client_ip();
            $getLoc = Location::get($PublicIP);
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
                if(auth()->user()->id_inv_code == 0){
                    $action = "Mitra Bisnis : Rekening Inquiry Fail";
                } else {
                    $action = "Tenant : Rekening Inquiry Fail";
                }
                $this->createHistoryUser($action, $e, 0);
            }
        }
        return view('tenant.tenant_withdraw', compact('qrisWallet', 'dataRekening', 'rekening', 'biayaAdmin'));
    }

    public function withdrawProcess(Request $request){
        DB::connection()->enableQueryLog();
        $url = 'https://erp.pt-best.com/api/rek_transfer';
        $client = new GuzzleHttpClient();
        $ip = "125.164.243.227";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($PublicIP);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        
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

                $qrisWalletTenant = QrisWallet::where('id_user', auth()->user()->id)
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
                    if($qrisWalletTenant->saldo<$total_tarik_dana){
                        $notification = array(
                            'message' => 'Saldo anda tidak mencukupi untuk melakukan proses penarikan!',
                            'alert-type' => 'warning',
                        );
                        return redirect()->back()->with($notification);
                    } else {
                        $transfer = "";
                        $transfer = $this->prosesTarikDanaTenant($nominal_tarik, $total_tarik_dana);

                        if(!is_null($transfer) || !empty($transfer) || $transfer != "" || $transfer != NULL){
                            if($transfer != 0) {
                                $notification = array(
                                    'message' => 'Penarikan dana sukses!',
                                    'alert-type' => 'success',
                                );
                                return redirect()->route('tenant.finance.history_penarikan.invoice', array('id' => $transfer))->with($notification);
                            } else {
                                $notification = array(
                                    'message' => 'Penarikan dana gagal, harap hubungi admin!',
                                    'alert-type' => 'error',
                                );
                                return redirect()->route('tenant.withdraw')->with($notification);
                            }
                        } else {
                            $notification = array(
                                'message' => 'Penarikan dana gagal, harap hubungi admin!',
                                'alert-type' => 'warning',
                            );
                            return redirect()->route('tenant.withdraw')->with($notification);
                        }
                    }
                }
                
            }
        } catch(Exception $e){
            $action = "";
            if(auth()->user()->id_inv_code == 0){
                $action = "Mitra Bisnis : Withdrawal Process Error | OTP Error Problem";
            } else {
                $action = "Tenant : Withdrawal Process Error | OTP Error Problem";
            }
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Penarikan dana gagal, harap hubungi admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    private function prosesTarikDanaTenant($nominal_tarik, $total_tarik){
        $url = 'https://erp.pt-best.com/api/rek_transfer';
        $client = new GuzzleHttpClient();
        $ip = "125.164.243.227";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($PublicIP);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $transferFee = BiayaAdminTransferDana::get();
        $biayaAdmin = $transferFee->sum('nominal');
        $aplikator = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Admin')->first();
        $mitra = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Mitra Aplikasi')->first();
        $agregateMaintenance = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Agregate Server')->first();
        $agregateTransfer = BiayaAdminTransferDana::select(['nominal', 'id'])->where('jenis_insentif', 'Insentif Transfer')->first();
        DB::connection()->enableQueryLog();

        $rekeningTenant = Rekening::select(['swift_code', 'no_rekening', 'id', 'atas_nama', 'nama_bank'])
                                    ->where('id_user', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->first();
        $qrisWalletTenant = QrisWallet::where('id_user', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
        $agregateWalletforMaintenance = AgregateWallet::find(1);
        $agregateWalletforTransfer = AgregateWallet::find(2);
        $qrisAdmin = QrisWallet::where('email', 'adminsu@visipos.id')->find(1);
        $marketing = "";
        $saldoMitra = "";

        if(auth()->user()->id_inv_code != 0){
            $marketing = InvitationCode::select([
                                            'invitation_codes.id',
                                            'invitation_codes.id_marketing',
                                        ])
                                        ->with(['marketing' => function ($query){
                                            $query->select([
                                                        'marketings.id',
                                                        'marketings.email'
                                                    ])
                                                    ->get();
                                        }])
                                        ->find(auth()->user()->id_inv_code);

            $saldoMitra = QrisWallet::where('id_user', $marketing->marketing->id)
                                    ->where('email', $marketing->marketing->email)
                                    ->first();
        }
        $agregateSaldoforMaintenance = $agregateWalletforMaintenance->saldo;
        $agregateSaldoforTransfer = $agregateWalletforTransfer->saldo;

        try{
            $nominal_penarikan = filter_var($nominal_tarik, FILTER_SANITIZE_NUMBER_INT);
            $total_penarikan = filter_var($total_tarik, FILTER_SANITIZE_NUMBER_INT);
            $saldoTenant = $qrisWalletTenant->saldo;
            if($saldoTenant < $total_penarikan){
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
                            'bankCode' => $rekeningTenant->swift_code,
                            'accountNo' => $rekeningTenant->no_rekening,
                            'amount' => $nominal_penarikan,
                            'secret_key' => "Vpos71237577Transfer"
                        ]
                    ]);
                    $responseCode = $postResponse->getStatusCode();
                    $data = json_decode($postResponse->getBody());
                    $responseCode = $data->responseCode;
                    $responseMessage = $data->responseMessage;
                    if($responseCode == 2001800 && $responseMessage == "Request has been processed successfully") {
                        $jenis_penarikan = "";
                        if(auth()->user()->id_inv_code != 0){
                            $jenis_penarikan = "Penarikan Dana Tenant";
                        } else if(auth()->user()->id_inv_code == 0){
                            $jenis_penarikan = "Penarikan Dana Mitra Bisnis";
                        }
                        $withDraw = Withdrawal::create([
                            'id_user' => auth()->user()->id,
                            'id_rekening' => $rekeningTenant->id,
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
                                'atas_nama' => $rekeningTenant->atas_nama,
                                'nama_bank' => $rekeningTenant->nama_bank,
                                'no_rekening' => $rekeningTenant->no_rekening,
                            ]);
                            $qrisWalletTenant->update([
                                'saldo' => $saldoTenant-$total_penarikan
                            ]);
                            $adminSaldo = $qrisAdmin->saldo;
                            if(auth()->user()->id_inv_code != 0){
                                $qrisAdmin->update([
                                    'saldo' => $adminSaldo+$aplikator->nominal
                                ]);

                                $mitraSaldo = $saldoMitra->saldo;
                                $saldoMitra->update([
                                    'saldo' => $mitraSaldo+$mitra->nominal
                                ]);
                            } else if(auth()->user()->id_inv_code == 0){
                                $qrisAdmin->update([
                                    'saldo' => $adminSaldo+$aplikator->nominal+$mitra->nominal
                                ]);
                            }

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

                            $action = "";
                            if(auth()->user()->id_inv_code == 0){
                                $action = "Mitra Bisnis : Withdrawal Process Success";
                            } else {
                                $action = "Tenant : Withdrawal Process Success";
                            }

                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Penarikan dana Qris sebesar *Rp. ".$nominal_tarik."* ke rekening bank *".$rekeningTenant->nama_bank."* atas nama *".$rekeningTenant->atas_nama."* ke rekenung tujuan *".$rekeningTenant->no_rekening."* sukses pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body);

                            return $withDraw->id;

                        } else {

                            $action = "";
                            if(auth()->user()->id_inv_code == 0){
                                $action = "Mitra Bisnis : Withdrawal Process Failed";
                            } else {
                                $action = "Tenant : Withdrawal Process Failed";
                            }
                            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
                            $date = Carbon::now()->format('d-m-Y H:i:s');
                            $body = "Penarikan dana Qris sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                            $this->sendNotificationToUser($body);
                            
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

                        $action = "";
                        if(auth()->user()->id_inv_code == 0){
                            $action = "Mitra Bisnis : Withdrawal Transaction fail invalid";
                        } else {
                            $action = "Tenant : Withdrawal Transaction fail invalid";
                        }

                        $this->createHistoryUser($action, $responseMessage, 0);
                        $date = Carbon::now()->format('d-m-Y H:i:s');
                        $body = "Penarikan dana Qris sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                        $this->sendNotificationToUser($body);
                        
                        return 0;
                    }
                } catch (Exception $e) {
                    $action = "";
                    if(auth()->user()->id_inv_code == 0){
                        $action = "Mitra Bisnis : Withdraw Process | Error (HTTP API Error)";
                    } else {
                        $action = "Tenant : Withdraw Process | Error (HTTP API Error)";
                    }
                    $this->createHistoryUser($action, $e, 0);
                    $date = Carbon::now()->format('d-m-Y H:i:s');
                    $body = "Penarikan dana Qris sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
                    $this->sendNotificationToUser($body);
                    
                    return 0;
                }
            }
        } catch (Exception $e){
            $action = "";
            if(auth()->user()->id_inv_code == 0){
                $action = "Mitra Bisnis : Withdraw Process | Error";
            } else {
                $action = "Tenant : Withdraw Process | Error";
            }
            $this->createHistoryUser($action, $e, 0);
            $date = Carbon::now()->format('d-m-Y H:i:s');
            $body = "Penarikan dana Qris sebesar Rp. ".$nominal_penarikan." gagal pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            $this->sendNotificationToUser($body);

            return 0;
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
            $action = "";
            if(auth()->user()->id_inv_code == 0){
                $action = "Mitra Bisnis : Send Whatsapp OTP Fail";
            } else {
                $action = "Tenant : Send Whatsapp OTP Fail";
            }
            $this->createHistoryUser($action, $ex, 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
        $responseCode = $postResponse->getStatusCode();
        if(is_null($responseCode) || empty($responseCode)){
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
        if($responseCode == 200){
            $action = "";
            if(auth()->user()->id_inv_code == 0){
                $action = "Mitra Bisnis : Send Whatsapp OTP Success";
            } else {
                $action = "Tenant : Send Whatsapp OTP Success";
            }
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'OTP Sukses dikirim!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } else {
            $action = "";
            if(auth()->user()->id_inv_code == 0){
                $action = "Mitra Bisnis : Send Whatsapp OTP Fail | Status : ".$responseCode;
            } else {
                $action = "Tenant : Send Whatsapp OTP Fail | Status : ".$responseCode;
            }
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function whatsappOTPSubmit(Request $request){
        $action = "";
        if(auth()->user()->id_inv_code == 0){
            $action = "Mitra Bisnis : Whatsapp Number Verification Process";
        } else {
            $action = "Tenant : Whatsapp Number Verification Process";
        }
        DB::connection()->enableQueryLog();
        if(!empty(auth()->user()->phone_number_verified_at) || !is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at != NULL || auth()->user()->phone_number_verified_at != "") {
            return redirect()->route('tenant.dashboard');
        } else {
            try{
                $kode = (int) $request->otp;
                $otp = (new Otp)->validate(auth()->user()->phone, $kode);
                if(!$otp->status){
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
                    $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
                    $notification = array(
                        'message' => 'Nomor anda telah diverifikasi!',
                        'alert-type' => 'success',
                    );
                    return redirect()->back()->with($notification);
                }
            } catch(Exception $e){
                $this->createHistoryUser($action, $e, 0);
                $notification = array(
                    'message' => 'Whatsapp Verification Error!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }
        }
    }
}
