<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Kasir;
use App\Models\Supplier;
use App\Models\ProductCategory;
use App\Models\Batch;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Tax;
use App\Models\Discount;
use App\Models\TenantField;
use App\Models\Invoice;
use App\Models\QrisWallet;
use App\Models\TunaiWallet;

class TenantController extends Controller {

    public function index(){
        $todayTransaction = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                    ->where('id_tenant', auth()->user()->id)
                                    ->count();
        $todayTransactionFinish = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                    ->where('id_tenant', auth()->user()->id)
                                    ->where('status_pembayaran', 1)
                                    ->count();
        $invoice = Invoice::where('id_tenant', auth()->user()->id)->count();
        $latestInvoice = Invoice::with('kasir')
                                ->where('id_tenant', auth()->user()->id)
                                ->where('status_pembayaran', 1)
                                ->latest()
                                ->take(10)
                                ->get();
        $qrisWallet = QrisWallet::where('id_tenant', auth()->user()->id)->first();
        $tunaiWallet = TunaiWallet::where('id_tenant', auth()->user()->id)->first();
        $totalSaldo = (int)filter_var($qrisWallet->saldo, FILTER_SANITIZE_NUMBER_INT) + (int) filter_var($tunaiWallet->saldo, FILTER_SANITIZE_NUMBER_INT);
        $pemasukanHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                            ->where('id_tenant', auth()->user()->id)
                            ->where('status_pembayaran', 1)
                            ->sum('sub_total');
        $pajakHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                            ->where('id_tenant', auth()->user()->id)
                            ->where('status_pembayaran', 1)
                            ->sum('pajak');
        $totalHariIni = (int)filter_var($pemasukanHariIni, FILTER_SANITIZE_NUMBER_INT) + (int)filter_var($pajakHariIni, FILTER_SANITIZE_NUMBER_INT);
        return view('tenant.dashboard', compact('todayTransaction', 'invoice', 'todayTransactionFinish', 'latestInvoice', 'totalSaldo', 'totalHariIni'));
    }

    public function tenantKasirDashboard(){
        return view('tenant.tenant_kasir');
    }

    public function kasirList(){
        $kasir = Kasir::with('detail')
                        ->select(['id','name', 'email', 'is_active'])
                        ->where('id_tenant', auth()->user()->id)
                        ->latest()
                        ->get();
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
        $kasir = Kasir::where('id_tenant', auth()->user()->id)
                        ->select(['id','name', 'email', 'is_active', 'phone'])
                        ->with('detail')
                        ->find($id);
        return view('tenant.tenant_kasir_detail', compact('kasir'));
    }

    public function tenantMenuToko(){
        return view('tenant.tenant_toko');
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
        return view('tenant.tenant_product_add');
    }

    public function batchProductInsert(Request $request){
        $harga = "";
        if($request->j_produk == "Fixed"){
            $harga = $request->h_jual;
        } else if($request->j_produk == "Custom"){
            $harga = 0;
            //return $harga;
        } else {
            return "salah";
        }
        $file = $request->file('photo');
        $namaFile = $request->p_name;
        $storagePath = Storage::path('public/images/product');
        $ext = $file->getClientOriginalExtension();
        $filename = $namaFile.'-'.time().'.'.$ext;
        $harga = "";

        try {
            $file->move($storagePath, $filename);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        Product::create([
            'id_tenant' => auth()->user()->id,
            'id_batch' => $request->batch,
            'id_category' => $request->category,
            'product_name' => $request->p_name,
            'id_supplier' => $request->supplier,
            'photo' => $filename,
            'nomor_gudang' => $request->gudang,
            'nomor_rak' => $request->rak,
            'tanggal_beli' => $request->t_beli,
            'tanggal_expired' => $request->t_expired,
            'harga_jual' => (int) $harga
        ]);

        $notification = array(
            'message' => 'Data produk berhasil ditambahkan!',
            'alert-type' => 'success',
        );
        return redirect()->route('tenant.product.batch.list')->with($notification);
    }

    public function batchProductDetail($id){
        $product = Product::where('id_tenant', auth()->user()->id)->find($id);
        $stockList = ProductStock::with('product')->where('id_tenant', auth()->user()->id)->where('id_batch_product', $id)->latest()->get();
        return view('tenant.tenant_product_detail', compact('product', 'stockList'));
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
                'id_category' => $request->category,
                'product_name' => $request->p_name,
                'id_supplier' => $request->supplier,
                'photo' => $filename,
                'nomor_gudang' => $request->gudang,
                'nomor_rak' => $request->rak,
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
                'id_category' => $request->category,
                'product_name' => $request->p_name,
                'id_supplier' => $request->supplier,
                'nomor_gudang' => $request->gudang,
                'nomor_rak' => $request->rak,
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

    public function productStockList(){
        $stock = ProductStock::with('product')->where('id_tenant', auth()->user()->id)->latest()->get();
        return view('tenant.tenant_stock_list', compact('stock'));
    }

    public function productStockAdd(){
        return view('tenant.tenant_stock_add');
    }

    public function productStockInsert(Request $request){
        $stokProduct = ProductStock::create([
            'id_tenant' => auth()->user()->id,
            'id_batch_product' => $request->id_batch_product,
            'barcode' => $request->barcode,
            'tanggal_beli' => $request->t_beli,
            'tanggal_expired' => $request->t_expired,
            'harga_beli' => $request->h_beli,
            'stok' => $request->stok
        ]);

        // if(!is_null($stokProduct)) {
        //     $stokProduct->productStockInsert($stokProduct);
        // }

        $notification = array(
            'message' => 'Data produk berhasil ditambahkan!',
            'alert-type' => 'success',
        );
        return redirect()->route('tenant.product.stock.list')->with($notification);
    }

    public function productStockEdit($id){
        $stock = ProductStock::with('product')->where('id_tenant', auth()->user()->id)->find($id);
        return view('tenant.tenant_stock_edit', compact('stock'));
    }

    public function productStockUpdate(Request $request){
        $stock = ProductStock::where('id_tenant', auth()->user()->id)->find($request->id);
        $stock_temp = $stock->stok;
        $stock->update([
            'barcode' => $request->barcode,
            'tanggal_beli' => $request->t_beli,
            'tanggal_expired' => $request->t_expired,
            'harga_beli' => $request->h_beli,
            'stok' => $request->stok
        ]);

        // if(!is_null($stock)) {
        //     $stock->productStockUpdate($stock, $stock_temp);
        // }

        // dd($stock_temp);

        $notification = array(
            'message' => 'Data produk berhasil diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->route('tenant.product.stock.list')->with($notification);
    }

    public function productStockDelete($id){
        $stock = ProductStock::where('id_tenant', auth()->user()->id)->find($id);
        $stock_temp = $stock->stok;

        $stock->delete();

        // if(!is_null($stock)) {
        //     $stock->productStockDelete($stock, $stock_temp);
        // }

        // dd($stock_temp);

        $notification = array(
            'message' => 'Data produk berhasil dihapus!',
            'alert-type' => 'success',
        );
        return redirect()->route('tenant.product.stock.list')->with($notification);
    }

    public function productStockBarcode($id){
        $stok = ProductStock::where('id_tenant', auth()->user()->id)->find($id);
        return view('tenant.tenant_barcode_show', compact('stok'));
    }

    public function discountModify(){
        $diskon = Discount::where('id_tenant', auth()->user()->id)->first();
        return view('tenant.tenant_discount_modify', compact('diskon'));
    }

    public function discountModifyInsert(Request $request){
        $diskon = Discount::where('id_tenant', auth()->user()->id)->first();
        if(empty($diskon)){
            Discount::create([
                'id_tenant' => auth()->user()->id,
                'min_harga' => $request->min_harga,
                'diskon' => $request->diskon,
                'start_date' => $request->t_mulai,
                'end_date' => $request->t_akhir,
                'is_active' => $request->status
            ]);
        } else {
            $diskon->update([
                'min_harga' => $request->min_harga,
                'diskon' => $request->diskon,
                'start_date' => $request->t_mulai,
                'end_date' => $request->t_akhir,
                'is_active' => $request->status
            ]);
        }

        $notification = array(
            'message' => 'Data diskon berhasil dimodifikasi!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function pajakModify(){
        $tax = Tax::where('id_tenant', auth()->user()->id)->first();
        return view('tenant.tenant_tax_modify', compact('tax'));
    }

    public function pajakModifyInsert(Request $request){
        $tax = Tax::where('id_tenant', auth()->user()->id)->find($request->id);
        if(empty($tax)){
            Tax::create([
                'id_tenant' => auth()->user()->id,
                'pajak' => $request->pajak,
                'is_active' => $request->status,
            ]);
        } else {
            $tax->update([
                'pajak' => $request->pajak,
                'is_active' => $request->status,
            ]);
        }

        $notification = array(
            'message' => 'Data pajak berhasil dimodifikasi!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function customField(){
        $customField = TenantField::where('id_tenant', auth()->user()->id)->first();
        return view('tenant.tenant_custom_field_list', compact('customField'));
    }

    public function customFieldInsert(Request $request) {
        $customField = TenantField::where('id_tenant', auth()->user()->id)->find($request->id);
        if(is_null($request->baris1)){
            $request->aktivasi_baris_1 = 0;
        }
        if(is_null($request->baris2)){
            $request->aktivasi_baris_2 = 0;
        }
        if(is_null($request->baris3)){
            $request->aktivasi_baris_3 = 0;
        }
        if(is_null($request->baris4)){
            $request->aktivasi_baris_4 = 0;
        }
        if(is_null($request->baris5)){
            $request->aktivasi_baris_5 = 0;
        }

        $customField->update([
            'baris1' => $request->baris1,
            'baris2' => $request->baris2,
            'baris3' => $request->baris3,
            'baris4' => $request->baris4,
            'baris5' => $request->baris5,
            'baris_1_activation' => $request->aktivasi_baris_1,
            'baris_2_activation' => $request->aktivasi_baris_2,
            'baris_3_activation' => $request->aktivasi_baris_3,
            'baris_4_activation' => $request->aktivasi_baris_4,
            'baris_5_activation' => $request->aktivasi_baris_5,
        ]);

        $notification = array(
            'message' => 'Data berhasil diupdate!',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function tenantTransaction(){
        return view('tenant.tenant_transaction');
    }

    public function transactionList(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id)->latest()->get();
        return view('tenant.tenant_transaction_list', compact('invoice'));
    }

    public function transactionListPending(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id)
                            ->where('jenis_pembayaran', NULL)
                            ->where('status_pembayaran', 0)
                            ->latest()
                            ->get();
        return view('tenant.tenant_transaction_list_pending', compact('invoice'));
    }

    public function transactionListPendingPayment(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id)
                        ->where('jenis_pembayaran', "Qris")
                        ->where('status_pembayaran', 0)
                        ->latest()
                        ->get();
        return view('tenant.tenant_transaction_list_pending_payment', compact('invoice'));
    }

    public function transactionInvoiceView($id){
        $invoice = Invoice::with('shoppingCart', 'invoiceField')->find($id);
        return view('tenant.tenant_invoice_preview', compact('invoice'));
    }

    public function saldoData(){
        $tunai = TunaiWallet::where('id_tenant', auth()->user()->id)->first();
        $qris = QrisWallet::where('id_tenant', auth()->user()->id)->first();
        return view('tenant.tenant_saldo', compact('tunai', 'qris'));
    }
}
