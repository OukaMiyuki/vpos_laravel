<?php

namespace App\Http\Controllers\Auth\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Kasir;
use App\Models\DetailKasir;
use App\Models\History;
use Exception;

class ProfileController extends Controller {
    public function kasirSettings(){
        return view('kasir.kasir_settings');
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
        $environment = App::environment();
        $isDebug = config('app.debug');
        $user_id = auth()->user()->id;
        $user_email = auth()->user()->email;
        $ip_testing = "125.164.244.223";
        $ip_production = $this->get_client_ip();
        $PublicIP = "";
        $lat = "";
        $long = "";
        $user_location = "";
        if ($environment === 'production' && !$isDebug) {
            $PublicIP = $ip_production;
        } else if ($environment === 'local' && $isDebug) {
            $PublicIP = $ip_testing;
        }

        if(!is_null($PublicIP) || !empty($PublicIP)){
            $getLoc = Location::get($PublicIP);
            if(!is_null($getLoc->latitude) && !is_null($getLoc->longitude)){
                $lat = $getLoc->latitude;
                $long = $getLoc->longitude;
                $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";
            }
        }

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $PublicIP, $log, $status);
        }
    }

    public function profile(){
        $profilKasir = Kasir::select(['kasirs.id', 'kasirs.name', 'kasirs.email', 'kasirs.phone', 'kasirs.is_active', 'kasirs.id_store'])
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
        return view('kasir.kasir_profile', compact('profilKasir'));
    }

    public function profileInfoUpdate(Request $request){
        $ip = "125.164.244.223";
        $action = "Kasir : Update Profile";
        DB::connection()->enableQueryLog();

        try{
            $profileInfo = DetailKasir::where('email', auth()->user()->email)
                                        ->find(auth()->user()->detail->id);

            $account = Kasir::where('id', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $namaFile = $profileInfo->name;
                $storagePath = Storage::path('public/images/profile');
                $ext = $file->getClientOriginalExtension();
                $filename = $namaFile.'-'.time().'.'.$ext;

                if(empty($profileInfo->detail->photo)){
                    try {
                        $file->move($storagePath, $filename);
                    } catch (\Exception $e) {
                        $this->createHistoryUser($action, $e, 0);
                    }
                } else {
                    Storage::delete('public/images/profile/'.$profileInfo->detail->photo);
                    $file->move($storagePath, $filename);
                }

                $profileInfo->update([
                    'no_ktp' => $request->no_ktp,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'photo' => $filename,
                    'updated_at' => Carbon::now()
                ]);
            } else {
                $profileInfo->update([
                    'no_ktp' => $request->no_ktp,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'updated_at' => Carbon::now()
                ]);
            }
            $account->update([
                'name' => $request->name
            ]);
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Error data gagal diupdate!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function password(){
        return view('kasir.auth.password_update');
    }

    public function passwordUpdate(Request $request){
        $action = "Kasir : Password Update";
        DB::connection()->enableQueryLog();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        try{
            if(!Hash::check($request->old_password, auth::user()->password)){
                $notification = array(
                    'message' => 'Password lama tidak sesuai!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }

            Kasir::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password),
            ]);
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Password berhasil diperbarui!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Update Password Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }
}
