<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client as GuzzleHttpClient;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\History;
use App\Models\Marketing;
use App\Models\Tenant;
use App\Models\Kasir;
use App\Models\Admin;
use Illuminate\Validation\Rule;
use Exception;

class LoginController extends Controller {

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
        $clientIP = request()->header('X-Forwarded-For');
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
            $history->createHistory($history, $action, $user_location, $clientIP, $log, $status);
        }
    }

    public function index(): View {
        return view('auth.login');
    }

    public function resetPassword(): View {
        return view('auth.forgot_password');
    }

    public function store(Request $request) : RedirectResponse {
        DB::connection()->enableQueryLog();
        $this->ensureIsNotRateLimited($request);
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if(! Auth::guard('admin')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            if(! Auth::guard('marketing')->attempt($request->only('email', 'password'), $request->boolean('remember'))){
                if(! Auth::guard('tenant')->attempt($request->only('email', 'password'), $request->boolean('remember'))){
                    if(! Auth::guard('kasir')->attempt($request->only('email', 'password'), $request->boolean('remember'))){
                        $login_id = NULL;
                        $login_email = $request->email;
                        $action = "User Login Fail";
                        $this->createHistoryUser($login_id, $login_email, $action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 0);
                        RateLimiter::hit($this->throttleKey());
                        throw ValidationException::withMessages([
                            'email' => trans('auth.failed'),
                        ]);
                    }
                }
            }
        }
        $notification = array(
            'message' => 'Anda berhasil login!',
            'alert-type' => 'success',
        );
        $request->session()->regenerate();
        RateLimiter::clear($this->throttleKey());
        $login_id = NULL;
        $login_email = $request->email;
        $action = "User Login Success";
        $this->createHistoryUser($login_id, $login_email, $action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $noHp = "";
        $date = Carbon::now()->format('d-m-Y H:i:s');
        $body = "";
        if(Auth::guard('admin')->check()){
            $action = "Login User Admin";
            $user = Admin::select([
                                'admins.id',
                                'admins.email',
                                'admins.phone',
                                'admins.access_level'
                            ])
                            ->where('email', $login_email)
                            ->first();
            if($user->access_level == 0){
                $body = "Anda berhasil melakukan login sebagai Admin Super User pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            } else {
                $body = "Anda berhasil melakukan login sebagai Administrator pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            }
            $noHp = $user->phone;
            $id = $user->id;
            $email = $user->email;
            $this->sendWhatsappLoginNotification($id, $email, $noHp, $action, $body);
            return redirect()->intended(RouteServiceProvider::ADMIN_DASHBOARD)->with($notification);
        } else if(Auth::guard('marketing')->check()){
            $action = "Login User Mitra Aplikasi";
            $body = "Anda berhasil melakukan login sebagai Mitra Aplikasi pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            $user = Marketing::select([
                                    'marketings.id',
                                    'marketings.email',
                                    'marketings.phone'
                                ])
                                ->where('email', $login_email)
                                ->first();
            $noHp = $user->phone;
            $id = $user->id;
            $email = $user->email;
            $this->sendWhatsappLoginNotification($id, $email, $noHp, $action,$body);
            return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD)->with($notification);
        } else if(Auth::guard('tenant')->check()){
            $action = "Login User Tenant";
            $user = Tenant::select([
                                    'tenants.id',
                                    'tenants.email',
                                    'tenants.phone'
                                ])
                                ->where('email', $login_email)
                                ->first();
            if($user->id_inv_code == 0){
                $body = "Anda berhasil melakukan login sebagai Mitra Bisnis pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            } else {
                $body = "Anda berhasil melakukan login sebagai Mitra Tenant pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            }
            $noHp = $user->phone;
            $id = $user->id;
            $email = $user->email;
            $this->sendWhatsappLoginNotification($id, $email, $noHp, $action, $body);
            if(Auth::guard('tenant')->user()->id_inv_code == 0){
                return redirect()->intended(RouteServiceProvider::TENANT_MITRA_DASHBOARD)->with($notification);
            }
            return redirect()->intended(RouteServiceProvider::TENANT_DASHBOARD)->with($notification);
        } else if(Auth::guard('kasir')->check()){
            $action = "Login User Kasir";
            $body = "Anda berhasil melakukan login sebagai Kasir pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";
            $user = Kasir::select([
                            'kasirs.id',
                            'kasirs.email',
                            'kasirs.phone'
                        ])
                        ->where('email', $login_email)
                        ->first();
            $noHp = $user->phone;
            $id = $user->id;
            $email = $user->email;
            $this->sendWhatsappLoginNotification($id, $email, $noHp, $action, $body);
            return redirect()->intended(RouteServiceProvider::KASIR_DASHBOARD)->with($notification);
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

    public function resetPasswordSerachAccount(Request $request) {
        $phone = $request->phone;
        $user = "";
        $userType = "";

        $checkTenant = Tenant::select([
                                'tenants.id',
                                'tenants.phone',
                                'tenants.name',
                                'tenants.is_active'
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
        $checkMitraAplikasi = Marketing::select([
                                        'marketings.id',
                                        'marketings.phone',
                                        'marketings.name',
                                        'marketings.is_active'
                                    ])
                                    ->with([
                                        'detail' => function($query){
                                            $query->select([
                                                'detail_marketings.id',
                                                'detail_marketings.id_marketing',
                                                'detail_marketings.photo'
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
            if($checkTenant->id_inv_code == 0){
                $userType = "Mitra Bisnis";
            } else {
                $userType = "Tenant";
            }
        } else if($checkMitraAplikasi){
            $user = $checkMitraAplikasi;
            $userType = "Mitra Aplikasi";
        } else if($checkKasir){
            $user = $checkKasir;
            $userType = "Kasir";
        } else {
            $notification = array(
                'message' => 'Nomor anda tidak terdaftar! ',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification)->withInput();
        }

        return view('auth.otp_send', compact(['user', 'userType']));
    }

    public function resetPasswordSendOTP(Request $request){
        $api_key    = getenv("WHATZAPP_API_KEY");
        $sender  = getenv("WHATZAPP_PHONE_NUMBER");
        $client = new GuzzleHttpClient();
        $nohp = $request->phone;
        $hp = "";
        $postResponse = "";
        $otp = (new Otp)->generate($nohp, 'numeric', 6, 5);
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
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification)->withInput();
        }
        if(is_null($postResponse) || empty($postResponse) || $postResponse == NULL || $postResponse == ""){
            $action = "User Password Reset Send OTP Fail";
            $this->createHistoryUser(NULL, NULL, $action, "OTP Response NULL", 0);
            $notification = array(
                'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification)->withInput();
        } else {
            $responseCode = $postResponse->getStatusCode();
            if($responseCode == 200){
                $notification = array(
                    'message' => 'OTP Sukses dikirim!',
                    'alert-type' => 'success',
                );
                return view('auth.otp_verification', compact('nohp'))->with($notification);
            } else {
                $notification = array(
                    'message' => 'OTP Gagal dikirim! Pastikan nomor Whatsapp anda benar dan aktif! ',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification)->withInput();
            }
        }

    }

    public function resetPasswordOTPVerification(Request $request){
        $phone = $request->phone;
        $user = "";
        $kode = (int) $request->first.$request->second.$request->third.$request->fourth.$request->fifth.$request->sixth;
        $otp = (new Otp)->validate($phone, $kode);
        if(!$otp->status){
            $notification = array(
                'message' => 'OTP salah atau tidak sesuai!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        } else {
            return view('auth.change_password_otp', compact('phone'));
        }
    }

    public function resetPasswordChangePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
        ]);

        if($validator->fails()) {
            $notification = array(
                'message' => 'Password tidak sesuai, harap ulangi kembali!',
                'alert-type' => 'error',
            );
            return redirect()->route('access.login')->with($notification);
        }

        $phone = $request->phone;

        $checkTenant = Tenant::where('phone', $phone)->first();
        $checkMitraApp = Marketing::where('phone', $phone)->first();
        $checkKasir = Kasir::where('phone', $phone)->first();

        $action ="";
        $date = Carbon::now()->format('d-m-Y H:i:s');
        $body = "Password anda telah direset pada : ".$date.". Jika anda merasa ini adalah aktivitas mencurigakan, segera hubungi Admin untuk tindakan lebih lanjut!.";

        if($checkTenant){
            $checkTenant->update([
                'password' => Hash::make($request->password)
            ]);
            $action = "User Tenant Reset Password Success";
            $noHp = $checkTenant->phone;
            $id = $checkTenant->id;
            $email = $checkTenant->email;
            $this->sendWhatsappLoginNotification($id, $email, $noHp, $action, $body);
            $notification = array(
                'message' => 'Password berhasil diperbarui, silahkan login dengan password yang baru!',
                'alert-type' => 'success',
            );
            return redirect()->route('access.login')->with($notification);
        } else if($checkMitraApp) {
            $$checkMitraApp->update([
                'password' => Hash::make($request->password)
            ]);
            $action = "User Mitra Aplikasi Reset Password Success";
            $noHp = $checkMitraApp->phone;
            $id = $checkMitraApp->id;
            $email = $checkMitraApp->email;
            $this->sendWhatsappLoginNotification($id, $email, $noHp, $action, $body);
            $notification = array(
                'message' => 'Password berhasil diperbarui, silahkan login dengan password yang baru!',
                'alert-type' => 'success',
            );
            return redirect()->route('access.login')->with($notification);
        } else if( $checkKasir){
            $checkKasir->update([
                'password' => Hash::make($request->password)
            ]);
            $action = "User Kasir Reset Password Success";
            $noHp = $checkKasir->phone;
            $id = $checkKasir->id;
            $email = $checkKasir->email;
            $this->sendWhatsappLoginNotification($id, $email, $noHp, $action, $body);
            $notification = array(
                'message' => 'Password berhasil diperbarui, silahkan login dengan password yang baru!',
                'alert-type' => 'success',
            );
            return redirect()->route('access.login')->with($notification);
        } else {
            $notification = array(
                'message' => 'Update password gagal, silahkan hubungi admin!',
                'alert-type' => 'warning',
            );
            return redirect()->route('access.login')->with($notification);
        }
    }

    public function ensureIsNotRateLimited($request): void {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string {
        return Str::transliterate(Str::lower(request()->email).'|'.request()->ip);
    }

    public function destroy(Request $request): RedirectResponse {
        if(Auth::guard('admin')->check() || Auth::guard('marketing')->check() || Auth::guard('tenant')->check() || Auth::guard('kasir')->check()){
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login');
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
