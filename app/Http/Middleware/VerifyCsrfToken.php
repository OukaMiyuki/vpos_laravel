<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Str;

class VerifyCsrfToken extends Middleware {
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    protected function tokensMatch($request) {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
    
        if (!$token && $header = $request->header('X-XSRF-TOKEN')) {
            $token = $this->encrypter->decrypt($header);
        }
    
        $tokensMatch = $request->session()->token();
    
        if($tokensMatch == $token) $request->session()->regenerateToken();
    
        return $tokensMatch;
    }
}
