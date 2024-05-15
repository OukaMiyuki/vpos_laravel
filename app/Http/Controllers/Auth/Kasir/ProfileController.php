<?php

namespace App\Http\Controllers\Auth\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    function get_client_ip() {
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

    // Tidak digunakan karena akun tidak bisa diubah
    public function profileAccountUpdate(Request $request){
        $profileInfo = Kasir::where('email', auth()->user()->email)
                        ->find(auth()->user()->id);

        $profileInfo->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $notification = array(
            'message' => 'Data akun berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
    // Tidak digunakan karena akun tidak bisa diubah

    public function profileInfoUpdate(Request $request){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
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
                        return $e->getMessage();
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
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change profile information : Success",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                'status' => 1
            ]);
            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change profile information : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

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
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
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
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change Password : Success!",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                'status' => 1
            ]);
            $notification = array(
                'message' => 'Password berhasil diperbarui!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change Password : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Update Password Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }
}