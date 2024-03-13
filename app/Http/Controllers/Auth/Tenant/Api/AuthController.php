<?php

namespace App\Http\Controllers\Auth\Tenant\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Marketing;
use App\Models\Tenant;
use App\Models\Kasir;
use App\Models\DetailAdmin;
use App\Models\DetailMarketing;
use App\Models\DetailTenant;
use App\Models\DetailKasir;
use App\Models\InvitationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;

class AuthController extends Controller {
    
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'no_ktp' => ['required', 'string', 'numeric', 'digits:16', 'unique:'.DetailAdmin::class, 'unique:'.DetailMarketing::class, 'unique:'.DetailTenant::class, 'unique:'.DetailKasir::class],
            'phone' => ['required', 'string', 'numeric', 'digits_between:1,20', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'jenis_kelamin' => ['required'],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'alamat' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
            'inv_code' => ['required', Rule::exists('invitation_codes')->where(function ($query) {
                            return $query->where('inv_code', request()->get('inv_code'));
                        })],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $invitationcodeid = InvitationCode::where('inv_code', $request->inv_code)->first();

        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'id_inv_code' => $invitationcodeid->id
        ]);

        if(!is_null($tenant)) {
            $tenant->detailTenantStore($tenant);
            $tenant->storeInsert($tenant);
        }

        event(new Registered($tenant));

        $token = $tenant->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $tenant,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request) {
        if (! Auth::guard('tenant')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $tenant = Tenant::where('email', $request->email)->firstOrFail();

        $token = $tenant->createToken('auth_token')->plainTextToken;

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
