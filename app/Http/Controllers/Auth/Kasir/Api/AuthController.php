<?php

namespace App\Http\Controllers\Auth\Kasir\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Kasir;

class AuthController extends Controller {   
    public function login(Request $request) {
        if (! Auth::guard('kasir')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $kasir = Kasir::where('email', $request->email)->firstOrFail();

        $token = $kasir->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function user(){
        $user = Auth::user();
        return response()->json(['data' => $user]);
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
