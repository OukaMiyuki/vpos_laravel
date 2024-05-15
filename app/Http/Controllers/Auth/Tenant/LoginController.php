<?php

namespace App\Http\Controllers\Auth\Tenant;

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
    public function create(): View {
        return view('tenant.auth.login');
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

    public function store(Request $request): RedirectResponse {
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();
        
        $this->ensureIsNotRateLimited();

        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

  
        if(! Auth::guard('tenant')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
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
        
        $notification = array(
            'message' => 'Anda berhasil login!',
            'alert-type' => 'info',
        );
        return redirect()->intended(RouteServiceProvider::TENANT_DASHBOARD)->with($notification);

    }

    public function ensureIsNotRateLimited(): void {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

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
        Auth::guard('tenant')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/tenant/login');
    }
}
