<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Kasir;
use App\Models\Supplier;
use App\Models\ProductCategory;
use App\Models\Batch;
use App\Models\Product;

class TenantController extends Controller {

    public function index(){
        return view('tenant.dashboard');
    }

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
        $kasir = Kasir::where('id_tenant', auth()->user()->id)->with('detail')->find($id);
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

    public function batchProductList(){
        $product = Product::where('id_tenant', auth()->user()->id)->latest()->get();
        return view('tenant.tenant_product_list', compact('product'));
    }

    public function batchProductAdd(){
        return view('tenant.tenant_tambah_product');
    }

    public function batchProductInsert(Request $request){
        $file = $request->file('photo');
        $namaFile = $request->p_name;
        $storagePath = Storage::path('public/images/product');
        $ext = $file->getClientOriginalExtension();
        $filename = $namaFile.'-'.time().'.'.$ext;

        try {
            $file->move($storagePath, $filename);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        Product::create([
            'id_tenant' => auth()->user()->id,
            'id_batch' => $request->batch,
            'product_name' => $request->p_name,
            'id_supplier' => $request->supplier,
            'photo' => $filename,
            'nomor_gudang' => $request->gudang,
            'nomor_rak' => $request->rak,
            'tanggal_beli' => $request->t_beli,
            'tanggal_expired' => $request->t_expired,
            'harga_beli' => $request->h_beli,
            'harga_jual' => $request->h_jual
        ]);

        $notification = array(
            'message' => 'Data produk berhasil ditambahkan!',
            'alert-type' => 'success',
        );
        return redirect()->route('tenant.product.batch.list')->with($notification);
    }

    public function batchProductDetail($id){
        $product = Product::where('id_tenant', auth()->user()->id)->find($id);
        return view('tenant.tenant_product_detail', compact('product'));
    }

    public function batchProductEdit($id){
        $product = Product::where('id_tenant', auth()->user()->id)->find($id);
        return view('tenant.tenant_product_edit', compact('product'));
    }

    public function batchProductUpdate(Request $request){
        $product = Product::find($request->id);

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $namaFile = $product->p_name;
            $storagePath = Storage::path('public/images/product');
            $ext = $file->getClientOriginalExtension();
            $filename = $namaFile.'-'.time().'.'.$ext;

            if(empty($product->photo)){
                try {
                    $file->move($storagePath, $filename);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            } else {
                Storage::delete('public/images/product/'.$product->photo);
                $file->move($storagePath, $filename);
            }

            $product->update([
                'id_batch' => $request->batch,
                'product_name' => $request->p_name,
                'id_supplier' => $request->supplier,
                'photo' => $filename,
                'nomor_gudang' => $request->gudang,
                'nomor_rak' => $request->rak,
                'tanggal_beli' => $request->t_beli,
                'tanggal_expired' => $request->t_expired,
                'harga_beli' => $request->h_beli,
                'harga_jual' => $request->h_jual
            ]);

            $notification = array(
                'message' => 'Data produk berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.product.batch.list')->with($notification);

        } else {
            $product->update([
                'id_batch' => $request->batch,
                'product_name' => $request->p_name,
                'id_supplier' => $request->supplier,
                'nomor_gudang' => $request->gudang,
                'nomor_rak' => $request->rak,
                'tanggal_beli' => $request->t_beli,
                'tanggal_expired' => $request->t_expired,
                'harga_beli' => $request->h_beli,
                'harga_jual' => $request->h_jual
            ]);

            $notification = array(
                'message' => 'Data produk berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.product.batch.list')->with($notification);
        }
    }

    public function batchProductDelete($id){
        $product = Product::where('id_tenant', auth()->user()->id)->find($id);
        $product->delete();
        $notification = array(
            'message' => 'Data produk berhasil dihapus!',
            'alert-type' => 'success',
        );
        return redirect()->route('tenant.product.batch.list')->with($notification);
    }

    public function productList(){

    }

    public function productInsert(){
        
    }

    public function productDetail($id){

    }

    public function productUpdate(Request $request){

    }

    public function productDelete($id) {

    }
}
