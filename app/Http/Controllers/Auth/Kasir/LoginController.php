<?php

namespace App\Http\Controllers\Auth\Kasir;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginController extends Controller {
    public function create(): View {
        return view('kasir.auth.login');
    }

    public function store(Request $request): RedirectResponse {
        $this->ensureIsNotRateLimited();
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if(! Auth::guard('kasir')->attempt($request->only('email', 'password'), $request->boolean('remember'))){
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        $notification = array(
            'message' => 'Anda berhasil login!',
            'alert-type' => 'success',
        );
        $request->session()->regenerate();
        RateLimiter::clear($this->throttleKey());
        return redirect()->route('kasir.dashboard')->with($notification);
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
        Auth::guard('kasir')->logout();

        $request->session()->flush();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/kasir/login');
    }
}
