<?php

namespace App\Http\Controllers\Auth\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Kasir;
use App\Models\DetailKasir;

class ProfileController extends Controller {
    public function kasirSettings(){
        return view('kasir.kasir_settings');
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
        $profileInfo = DetailKasir::where('email', auth()->user()->email)
                                ->find(auth()->user()->detail->id);

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

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);

        } else {
            $profileInfo->update([
                'no_ktp' => $request->no_ktp,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'updated_at' => Carbon::now()
            ]);

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function password(){
        return view('kasir.auth.password_update');
    }

    public function passwordUpdate(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

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

        $notification = array(
            'message' => 'Password berhasil diperbarui!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
}