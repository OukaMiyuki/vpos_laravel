<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Kasir;
use App\Models\Supplier;
use App\Models\ProductCategory;
use App\Models\Batch;

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

    public function supplierDelete($id){
        $supplier = Supplier::find($id);
        $supplier->delete();
        $notification = array(
            'message' => 'Data berhasil dihapus!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function batchList(){
        $batch = Batch::where('id_tenant', auth()->user()->id)->latest()->get();
        return view('tenant.tenant_batch_list', compact('batch'));
    }


    public function batchInsert(Request $request){
        Batch::create([
            'id_tenant' => auth()->user()->id,
            'batch_code' => $request->name,
            'keterangan' => $request->keterangan
        ]);

        $notification = array(
            'message' => 'Data berhasil ditambahkan!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function batchUpdate(Request $request){
        $batch = Batch::find($request->id);

        $batch->update([
            'batch_code' => $request->name,
            'keterangan' => $request->keterangan
        ]);

        
        $notification = array(
            'message' => 'Data berhasil ditambahkan!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function batchDelete($id){
        $batch = Batch::find($id);
        $batch->delete();
        
        $notification = array(
            'message' => 'Data berhasil dihapus!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function categoryList(){
        $category = ProductCategory::where('id_tenant', auth()->user()->id)->latest()->get();
        return view('tenant.tenant_category_list', compact('category'));
    }

    public function categoryInsert(Request $request) {
        ProductCategory::create([
            'id_tenant' => auth()->user()->id,
            'name' => $request->category
        ]);

        $notification = array(
            'message' => 'Data berhasil ditambahkan!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function categoryUpdate(Request $request){
        $category = ProductCategory::find($request->id);
        $category->update([
            'name'  => $request->category
        ]);

        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }

    public function categoryDelete($id){
        $category = ProductCategory::find($request->id);
        $category->delete();

        $notification = array(
            'message' => 'Data berhasil dihapus!',
            'alert-type' => 'info',
        );

        return redirect()->back()->with($notification);
    }
}
