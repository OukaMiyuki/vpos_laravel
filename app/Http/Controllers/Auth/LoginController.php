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
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Models\History;
use Exception;

class LoginController extends Controller {

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

    public function index(): View {
        return view('auth.login');
    }

    public function store(Request $request) : RedirectResponse {
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
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
                        History::create([
                            'id_user' => NULL,
                            'email' => $request->email,
                            'action' => "Login : Login Gagal (Username atau Password salah!)",
                            'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                            'deteksi_ip' => $ip,
                            'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                            'status' => 0
                        ]);
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
        History::create([
            'id_user' => NULL,
            'email' => $request->email,
            'action' => "Login : Success!",
            'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
            'deteksi_ip' => $ip,
            'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
            'status' => 1
        ]);
        if(Auth::guard('admin')->check()){
            return redirect()->intended(RouteServiceProvider::ADMIN_DASHBOARD)->with($notification);
        } else if(Auth::guard('marketing')->check()){
            return redirect()->intended(RouteServiceProvider::MARKETING_DASHBOARD)->with($notification);
        } else if(Auth::guard('tenant')->check()){
            if(Auth::guard('tenant')->user()->id_inv_code == 0){
                return redirect()->intended(RouteServiceProvider::TENANT_MITRA_DASHBOARD)->with($notification);
            }
            return redirect()->intended(RouteServiceProvider::TENANT_DASHBOARD)->with($notification);
        } else if(Auth::guard('kasir')->check()){
            return redirect()->intended(RouteServiceProvider::KASIR_DASHBOARD)->with($notification);
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
