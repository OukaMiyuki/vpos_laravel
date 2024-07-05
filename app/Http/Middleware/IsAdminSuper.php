<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Providers\RouteServiceProvider;

class IsAdminSuper {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        if(auth()->user()->access_level == 1){
            $notification = array(
                'message' => 'Anda tidak mempunyai hak akses untuk masuk ke halaman tersebut!',
                'alert-type' => 'warning',
            );
            return redirect()->intended(RouteServiceProvider::ADMIN_DASHBOARD)->with($notification);
        }
        return $next($request);
    }
}
