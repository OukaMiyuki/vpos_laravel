<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $restrictedIps = ['102.129.158.0'];
        if(in_array($request->ip(), $restrictedIps)){
        App::abort(403, 'Request forbidden');
        }
        return $next($request);
    }
}
