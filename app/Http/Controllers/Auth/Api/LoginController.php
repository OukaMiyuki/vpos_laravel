<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Kasir;
use App\Models\Tenant;

class LoginController extends Controller {
    public function login(Request $request) {
        if (! Auth::guard('tenant')->attempt($request->only('email', 'password'))) {
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
                'token_type' => 'Bearer',
                'data' => array(
                    'sup_user_id'           => $kasir->id,
                    'sup_user_name'         => $kasir->name,
                    'sup_user_company'      => $kasir->id_tenant,
                    'sup_user_email'        => $kasir->email,
                    'sup_user_type'         => 'kasir',
                    'sup_user_token'        => $token
                ),
                'status' => 200
            ]);
        }

        $tenant = Tenant::where('email', $request->email)->firstOrFail();

        if($tenant->id_inv_code != 0) {

            $token = $tenant->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login success',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'data' => array(
                    'sup_user_id'           => $tenant->id,
                    'sup_user_name'         => $tenant->name,
                    'sup_user_referal_code' => $tenant->id_inv_code,
                    'sup_user_company'      => null,
                    'sup_user_email'        => $tenant->email,
                    'sup_email_verification' => $tenant->email_verified_at,
                    'sup_phone_verification' => $tenant->phone_number_verified_at,
                    'sup_user_type'         => 'owner',
                    'sup_user_token'        => $token
                ),
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401
            ]);
        }
    }

    public function user(){
        $user = Auth::user();
        return response()->json(['data' => $user]);
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success',
            'status' => 200
        ]);
    }
}
