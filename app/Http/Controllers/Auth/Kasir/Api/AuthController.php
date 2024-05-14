<?php

namespace App\Http\Controllers\Auth\Kasir\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Kasir;
use Illuminate\Http\JsonResponse;
use Exception;
// use App\Models\Admin;
// use App\Models\Tenant;

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

    public function userDetail(Request $request) : JsonResponse {
        $user = "";
        // $id = $request->id;
        try {
            $user = Kasir::select(['kasirs.id', 'kasirs.name', 'kasirs.email', 'kasirs.phone', 'kasirs.is_active', 'kasirs.id_store'])
                                    ->with(['detail' => function($query){
                                        $query->select(['detail_kasirs.id', 
                                                        'detail_kasirs.id_kasir', 
                                                        'detail_kasirs.no_ktp',
                                                        'detail_kasirs.tempat_lahir',
                                                        'detail_kasirs.tanggal_lahir',
                                                        'detail_kasirs.jenis_kelamin',
                                                        'detail_kasirs.alamat',
                                                        'detail_kasirs.photo'])
                                                ->where('detail_kasirs.id_kasir', auth()->user()->id)
                                                ->where('detail_kasirs.email', auth()->user()->email)
                                                ->first();
                                    }
                                    ])
                                    ->find(auth()->user()->id);
            //$user = Kasir::with('detail')->where('id', Auth::user()->id)->firstOrFail();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        return response()->json([
            'message' => 'Fetch Success',
            'data-detail-user' => $user,
            'status' => 200
        ]);
    }

    public function userUpdate(Request $request) : JsonResponse {
        $name = $request->name;
        $password = $request->password;
        $kasir = "";
        try {
            $kasir = Kasir::with('detail')->where('id', Auth::user()->id)->firstOrFail();

            if($password == null || $password == ''){
                $kasir->update(['name' => $name,]);
            }else{
                $kasir->update(['name' => $name,'password' => Hash::make($password),]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        return response()->json([
            'message' => 'Update Success',
        ]);
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ]);
    }
}
