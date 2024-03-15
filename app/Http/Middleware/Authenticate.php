<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string{
        // return $request->expectsJson() ? null : route('welcome');
        if($request->is('api/*')) {
            $ErrorResponse = [
                'status' => 401,
                'success' => false,
                'message' =>'Invalid Token, You are unauthenticated!',
            ];
            abort(response()->json($ErrorResponse, 403));
        }
    
        if (! $request->expectsJson()) {
            return route('welcome');
        } 
        // if($request->expectsJson()){
        //     return $request->expectsJson();
        // } else {
        //     // if (Auth::guard('admin')->check()) {
        //     //     return route('admin.login');
        //     // } else if(Auth::guard('marketing')->check()){
        //     //     return route('marketing.login');
        //     // } else if(Auth::guard('tenant')->check()){
        //     //     return route('tenant.login');
        //     // } else if(Auth::guard('kasir')->check()){
        //     //     return route('kasir.login');
        //     // }

        //     if (empty(auth()->user()->email_verified_at)) {

        //         return '/verify-email';            
        //     }
        //     // return route('welcome');
        // }
    }
}
