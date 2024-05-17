<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CheckTenantLevel {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if(auth()->user()->id_inv_code != 0){
            $notification = array(
                'message' => 'Anda tidak mempunyai hak akses untuk masuk ke halaman tersebut!',
                'alert-type' => 'warning',
            );
            return redirect()->intended(RouteServiceProvider::WELCOME)->with($notification);
        }
        return $next($request);
    }
}
