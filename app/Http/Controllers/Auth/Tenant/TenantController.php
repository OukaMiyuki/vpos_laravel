<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Kasir;
use App\Models\Supplier;

class TenantController extends Controller {
    public function kasirList(){
        $kasir = Kasir::with('detail')->where('id_tenant', auth()->user()->id)->latest()->get();
        return view('tenant.tenant_kasir_list', compact('kasir'));
    }

    public function kasirRegister(Request $request){
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
        //     'no_ktp' => ['required', 'string', 'numeric', 'digits:16', 'unique:'.DetailAdmin::class, 'unique:'.DetailMarketing::class, 'unique:'.DetailTenant::class, 'unique:'.DetailKasir::class],
        //     'phone' => ['required', 'string', 'numeric', 'digits_between:1,20', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
        //     'jenis_kelamin' => ['required'],
        //     'tempat_lahir' => ['required'],
        //     'tanggal_lahir' => ['required'],
        //     'alamat' => ['required', 'string', 'max:255'],
        //     'password' => ['required', 'confirmed', 'min:8'],
        // ]);

        $kasir = Kasir::create([
            'id_tenant' => auth()->user()->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);


        if(!is_null($kasir)) {
            $kasir->detailKasirStore($kasir);
        }

        $notification = array(
            'message' => 'Akun kasir telah ditambahkan!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }
    
    public function kasirDetail($id){
        $kasir = Kasir::with('detail')->find($id);
        return view('tenant.tenant_kasir_detail', compact('kasir'));
    }

    public function supplierList(){
        $supplier = Supplier::where('id_tenant', auth()->user()->id)->latest()->get();
        return view('tenant.tenant_supplier_list', compact('supplier'));
    }

    public function supplierInsert(Request $request){
        Supplier::create([
            'id_tenant' => auth()->user()->id,
            'nama_supplier' => $request->nama_supplier,
            'email_supplier' => $request->email,
            'phone_supplier' => $request->phone,
            'alamat_supplier' => $request->alamat,
            'keterangan' => $request->keterangan
        ]);

        $notification = array(
            'message' => 'Data berhasil ditambahkan!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function supplierUpdate(Request $request) {
        $supplier = Supplier::find($request->id);

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'email_supplier' => $request->email,
            'phone_supplier' => $request->phone,
            'alamat_supplier' => $request->alamat,
            'keterangan' => $request->keterangan
        ]);

        
        $notification = array(
            'message' => 'Data berhasil ditambahkan!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }
}
