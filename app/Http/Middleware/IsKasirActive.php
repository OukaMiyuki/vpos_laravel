<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class IsKasirActive {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next) {
        if(auth()->user()->is_active == 0){
            Auth::guard('kasir')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $notification = array(
                'message' => 'Login gagal! Akun anda telah dinonaktifkan!',
                'alert-type' => 'error',
            );
            return redirect()->route('kasir.login')->with($notification);
        }
        return $next($request);
    }
}
