<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (Auth::guard('admin')->check()) {
                    return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
                } else if(Auth::guard('marketing')->check()){
                    return redirect(RouteServiceProvider::MARKETING_DASHBOARD);
                } else if(Auth::guard('tenant')->check()){
                    return redirect(RouteServiceProvider::TENANT_DASHBOARD);
                } else if(Auth::guard('kasir')->check()){
                    return redirect(RouteServiceProvider::KASIR_DASHBOARD);
                }
            } else {
                if (Auth::guard('admin')->check()) {
                    return redirect(RouteServiceProvider::ADMIN_DASHBOARD);
                } else if(Auth::guard('marketing')->check()){
                    return redirect(RouteServiceProvider::MARKETING_DASHBOARD);
                } else if(Auth::guard('tenant')->check()){
                    return redirect(RouteServiceProvider::TENANT_DASHBOARD);
                } else if(Auth::guard('kasir')->check()){
                    return redirect(RouteServiceProvider::KASIR_DASHBOARD);
                }
            }
        }

        return $next($request);
    }
}
