<?php

namespace App\Http\Controllers\Auth\Kasir\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Kasir;
use App\Models\AppVersion;
use App\Models\History;
use Illuminate\Http\JsonResponse;
use Exception;
// use App\Models\Admin;
// use App\Models\Tenant;

class AuthController extends Controller {

    private function getAppversion(){
        $appVersion = AppVersion::find(1);
        return $appVersion->versi;
    }

    private function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    private function createHistoryUser($action, $log, $status){
        $user_id = auth()->user()->id;
        $user_email = auth()->user()->email;
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($PublicIP);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $PublicIP, $log, $status);
        }
    }

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
            'token_type' => 'Bearer',
            'status' => 200,
            'app-version' => $this->getAppversion()
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
            'status' => 200,
            'app-version' => $this->getAppversion()
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
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function userUpdatePassword(Request $request){
        DB::connection()->enableQueryLog();
        $rules = [
            'password' => 'required|confirmed|min:8',
            'old_password' => 'required|min:8'
        ];
    
        $customMessages = [
            'required' => 'Inputan tidak boleh kosong!',
            'confirmed' => 'Konfimasi password tidak sesuai'
        ];
    
        $validator = $this->validate($request, $rules, $customMessages);

        if($validator){
            $password = $request->password;
            $old_password = $request->old_password;
            if(!Hash::check($old_password, auth::user()->password)){
                return response()->json([
                    'message' => 'Password lama tidak sesuai!',
                    'status' => 401
                ]);
            }

            Kasir::whereId(auth()->user()->id)->update([
                'password' => Hash::make($password),
            ]);

            $action = "Kasir : Update Password | Using Application";
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            return response()->json([
                'message' => 'Password berhasil diupdate!',
                'status' => 200
            ]);
        }
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success',
            'status' => 200
        ]);
    }
}
