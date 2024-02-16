<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\DetailAdmin;

class ProfileController extends Controller {
    public function profile(){
        return view('admin.admin_profile');
    }

    public function profileAccountUpdate(Request $request){
        $id = auth()->user()->id;
        $account = Admin::find($id);
        $account->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        $notification = array(
            'message' => 'Data akun berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function profileInfoUpdate(Request $request) {
        $id = auth()->user()->detail->id;
        $accountInfo = DetailAdmin::find($id);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $namaFile = auth()->user()->name;
            $storagePath = Storage::path('public/images/profile');
            $ext = $file->getClientOriginalExtension();
            $filename = $namaFile.'-'.time().'.'.$ext;

            if(empty($accountInfo->photo)){
                try {
                    $file->move($storagePath, $filename);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            } else {
                Storage::delete('public/images/profile/'.$accountInfo->photo);
                $file->move($storagePath, $filename);
            }

            $accountInfo->update([
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
            $accountInfo->update([
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
        return view('admin.auth.password_update');
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

        Admin::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        $notification = array(
            'message' => 'Password berhasil diperbarui!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    } 
}
