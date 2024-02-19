<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\DetailTenant;
use App\Models\StoreDetail;

class ProfileController extends Controller{
    public function profile(){
        return view('tenant.tenant_profile');
    }

    public function profileAccountUpdate(Request $request){
        $profileInfo = Tenant::find($request->id);

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

    public function profileInfoUpdate(Request $request){
        $profileInfo = DetailTenant::find($request->id);

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
        return view('tenant.auth.password_update');
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

        Tenant::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        $notification = array(
            'message' => 'Password berhasil diperbarui!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
    
    public function storeProfileSettings(){
        $tenantStore = StoreDetail::where('id_tenant', auth()->user()->id)->first();
        return view('tenant.tenant_store_detail', compact('tenantStore'));
    }

    public function storeProfileSettingsUPdate(Request $request) {
        $tenantStore = StoreDetail::where('id_tenant', auth()->user()->id)->first();
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $namaFile = $request->nama;
            $storagePath = Storage::path('public/images/profile');
            $ext = $file->getClientOriginalExtension();
            $filename = $namaFile.'-'.time().'.'.$ext;

            if(empty($tenantStore->photo)){
                try {
                    $file->move($storagePath, $filename);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            } else {
                Storage::delete('public/images/profile/'.$tenantStore->photo);
                $file->move($storagePath, $filename);
            }

            $tenantStore->update([
                'name' => $request->name,
                'alamat' => $request->alamat,
                'jenis_usaha' => $request->jenis,
                'status_umi' => $request->umi,
                'photo' => $filename
            ]);;

            $notification = array(
                'message' => 'Data akun berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } else {
            $tenantStore->update([
                'name' => $request->name,
                'alamat' => $request->alamat,
                'jenis_usaha' => $request->jenis,
                'status_umi' => $request->umi,
            ]);

            $notification = array(
                'message' => 'Data berhasil diperbarui!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }
}
