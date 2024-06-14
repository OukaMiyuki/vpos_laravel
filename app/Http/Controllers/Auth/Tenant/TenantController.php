<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Validator;
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
use App\Models\QrisWalletPending;
use App\Models\TunaiWallet;
use App\Models\StoreDetail;
use App\Models\Withdrawal;
use App\Models\History;
use App\Models\Rekening;
use App\Models\Tenant;
use App\Models\Marketing;
use App\Models\Admin;
use App\Models\DetailAdmin;
use App\Models\DetailMarketing;
use App\Models\DetailTenant;
use App\Models\DetailKasir;
use Exception;

class TenantController extends Controller {

    public function __construct() {
        $this->middleware('isTenantIsMitra', ['except' => [
                                'historyPenarikan', 'invoiceTarikDana'
                            ]]);
    }

    public function getStoreIdentifier(){
        $store = StoreDetail::select(['store_identifier'])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $identifier = $store->store_identifier;
        return $identifier;
    }

    private function createHistoryUser($action, $log, $status){
        $user_id = auth()->user()->id;
        $user_email = auth()->user()->email;
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $ip, $log, $status);
        }
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

    public function index(){
        $identifier = $this->getStoreIdentifier();
        $todayTransaction = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                    ->where('store_identifier', $identifier)
                                    ->count();
        $todayTransactionFinish = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                    ->where('store_identifier', $identifier)
                                    ->where('status_pembayaran', 1)
                                    ->count();
        $invoice = Invoice::where('id_tenant', auth()->user()->id)->count();
        $latestInvoice = Invoice::with('kasir')
                                ->where('store_identifier', $identifier)
                                ->where('status_pembayaran', 1)
                                ->latest()
                                ->take(10)
                                ->get();
        $qrisWallet = QrisWallet::where('id_user', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->first();
        $tunaiWallet = TunaiWallet::where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->first();
        $totalSaldo = $qrisWallet->saldo + $tunaiWallet->saldo;

        $pemasukanQrisHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                            ->where('store_identifier', $identifier)
                            ->where('status_pembayaran', 1)
                            ->where('jenis_pembayaran', 'Qris')
                            ->sum('nominal_terima_bersih');
        $pemasukanUnaiHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                            ->where('store_identifier', $identifier)
                            ->where('status_pembayaran', 1)
                            ->where('jenis_pembayaran', 'Tunai')
                            ->sum(DB::raw('sub_total + pajak'));
        //dd($pemasukanQrisHariIni);
        $pemasukanHariIni = $pemasukanQrisHariIni+$pemasukanUnaiHariIni;
        return view('tenant.dashboard', compact('todayTransaction', 'todayTransactionFinish', 'invoice', 'latestInvoice', 'totalSaldo', 'pemasukanHariIni'));
    }

    public function tenantKasirDashboard(){
        $store = StoreDetail::select(['store_identifier'])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $semuaKasirCount = Kasir::where('id_store', $store->store_identifier)->count();
        $kasirAktifCount = Kasir::where('id_store', $store->store_identifier)
                                    ->where('is_active', 1)
                                    ->count();
        $kasirNonAktiFCount = Kasir::where('id_store', $store->store_identifier)
                                    ->where('is_active', 0)
                                    ->count();
        return view('tenant.tenant_kasir', compact('semuaKasirCount', 'kasirAktifCount', 'kasirNonAktiFCount'));
    }

    public function kasirList(){
        $kasir = StoreDetail::select(['store_details.id', 'store_details.store_identifier'])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->with(['kasir' => function($query){
                                $query->select(['kasirs.id',
                                                'kasirs.name',
                                                'kasirs.email',
                                                'kasirs.phone',
                                                'kasirs.is_active',
                                                'kasirs.id_store'])
                                        ->with(['detail' => function($query){
                                            $query->select(['detail_kasirs.id',
                                                            'detail_kasirs.id_kasir',
                                                            'detail_kasirs.no_ktp',
                                                            'detail_kasirs.jenis_kelamin'

                                            ])
                                            ->get();
                                        }])
                                        ->get();
                            }])
                            ->get();
        return view('tenant.tenant_kasir_list', compact('kasir'));
    }

    public function kasirListActive(){
        $kasirListActive = StoreDetail::select(['store_details.id', 'store_details.store_identifier'])
                                    ->where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->with(['kasir' => function($query){
                                        $query->select(['kasirs.id',
                                                        'kasirs.name',
                                                        'kasirs.email',
                                                        'kasirs.phone',
                                                        'kasirs.is_active',
                                                        'kasirs.id_store'])
                                                ->with(['detail' => function($query){
                                                    $query->select(['detail_kasirs.id',
                                                                    'detail_kasirs.id_kasir',
                                                                    'detail_kasirs.no_ktp',
                                                                    'detail_kasirs.jenis_kelamin'

                                                    ])
                                                    ->get();
                                                }])
                                                ->where('kasirs.is_active', 1)
                                                ->get();
                                    }])
                                    ->get();
        return view('tenant.tenant_kasir_list_active', compact('kasirListActive'));
    }

    public function kasirListNonActive(){
        $kasirListNonActive = StoreDetail::select(['store_details.id', 'store_details.store_identifier'])
                                    ->where('id_tenant', auth()->user()->id)
                                    ->where('email', auth()->user()->email)
                                    ->with(['kasir' => function($query){
                                        $query->select(['kasirs.id',
                                                        'kasirs.name',
                                                        'kasirs.email',
                                                        'kasirs.phone',
                                                        'kasirs.is_active',
                                                        'kasirs.id_store'])
                                                ->with(['detail' => function($query){
                                                    $query->select(['detail_kasirs.id',
                                                                    'detail_kasirs.id_kasir',
                                                                    'detail_kasirs.no_ktp',
                                                                    'detail_kasirs.jenis_kelamin'

                                                    ])
                                                    ->get();
                                                }])
                                                ->where('kasirs.is_active', 0)
                                                ->get();
                                    }])
                                    ->get();
        return view('tenant.tenant_kasir_list_non_active', compact('kasirListNonActive'));
    }

    public function kasirRegister(Request $request){
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $rules = array(
            'email' => 'required|string|lowercase|email|max:255|unique:'.Admin::class.'|unique:'.Marketing::class.'|unique:'.Tenant::class.'|unique:'.Kasir::class,
            'phone' => 'required|string|numeric|digits_between:1,20|unique:'.Admin::class.'|unique:'.Marketing::class.'|unique:'.Tenant::class.'|unique:'.Kasir::class,
        );

        $messages = array(
                        // 'email.unique' => "Email sudah terdaftar di sistem kami, harap gunakan email lain!",
                        // 'phone.unique' => "No Telpon / Whatsapp suda terdaftar di sistem kami, harap gunakan nomor lain!"
                        'unique' => "Email atau nomor telah terdaftar di sistem kami, harap gunakan yang lain!"
                    );
        $validator = Validator::make( $request->all(), $rules, $messages );

        if ($validator->fails()) {
            $notification = array(
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $action = "Tambah Kasir Baru";
        DB::connection()->enableQueryLog();

        try {
            $store = StoreDetail::select(['store_identifier'])
                                ->where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
            $kasir = Kasir::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'id_store' => $store->store_identifier
            ]);

            if(!is_null($kasir)) {
                $kasir->detailKasirStore($kasir);
            }
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Akun kasir telah ditambahkan!',
                'alert-type' => 'info',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Tambah Kasir Baru Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function kasirDetail($id){
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $kasir = Kasir::where('id_store', $store->store_identifier)
                        ->select(['id','name', 'email', 'is_active', 'phone'])
                        ->with('detail')
                        ->find($id);
        if(is_null($kasir) || empty($kasir)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'info',
            );

            return redirect()->route('tenant.kasir.list')->with($notification);
        }
        return view('tenant.tenant_kasir_detail', compact('kasir'));
    }

    public function kasirActivate($id){
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $kasir = Kasir::where('id_store', $store->store_identifier)->find($id);

        if(is_null($kasir) || empty($kasir)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'info',
            );

            return redirect()->route('tenant.kasir.list')->with($notification);
        }

        $action = "Kasir Activation";
        DB::connection()->enableQueryLog();

        if($kasir->is_active == 0){
            $kasir->update([
                'is_active' => 1
            ]);
        } else {
            $kasir->update([
                'is_active' => 0
            ]);
        }
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        $notification = array(
            'message' => 'Kasir berhasil dinonaktifkan!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function tenantMenuToko(){
        $identifier = $this->getStoreIdentifier();
        $supplierCount = Supplier::where('store_identifier', $identifier)->count();
        $batchCount = Batch::where('store_identifier', $identifier)->count();
        $categoryCount = ProductCategory::where('store_identifier', $identifier)->count();
        $batchProductCount = Product::where('store_identifier', $identifier)->count();
        $barcodeCount = ProductStock::where('store_identifier', $identifier)->count();
        return view('tenant.tenant_toko', compact('supplierCount', 'batchCount', 'categoryCount', 'batchProductCount', 'barcodeCount'));
    }

    public function supplierList(){
        $identifier = $this->getStoreIdentifier();
        $supplier = Supplier::where('store_identifier', $identifier)
                            ->latest()
                            ->get();
        return view('tenant.tenant_supplier_list', compact('supplier'));
    }

    public function supplierInsert(Request $request){
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        } else {
            $action = "Tenant : Add Supplier";
            DB::connection()->enableQueryLog();

            try{
                $identifier = $this->getStoreIdentifier();
                Supplier::create([
                    'store_identifier' => $identifier,
                    'nama_supplier' => $request->nama_supplier,
                    'email_supplier' => $request->email,
                    'phone_supplier' => $request->phone,
                    'alamat_supplier' => $request->alamat,
                    'keterangan' => $request->keterangan
                ]);

                $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

                $notification = array(
                    'message' => 'Data berhasil diinput!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            } catch(Exception $e){
                $this->createHistoryUser($action, $e, 0);
                $notification = array(
                    'message' => 'Tambah Supplier Gagal!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }
        }
    }

    public function supplierUpdate(Request $request) {
        $action = "Tenant : Update Supplier";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $supplier = Supplier::where('store_identifier', $identifier)
                                ->find($request->id);

            if(empty($supplier) || is_null($supplier)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $supplier->update([
                'nama_supplier' => $request->nama_supplier,
                'email_supplier' => $request->email,
                'phone_supplier' => $request->phone,
                'alamat_supplier' => $request->alamat,
                'keterangan' => $request->keterangan
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data berhasil diupdate!',
                'alert-type' => 'info',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Update Supplier Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function supplierDelete($id){
        $action = "Tenant : Delete Supplier";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $supplier = Supplier::where('store_identifier', $identifier)
                                ->find($id);
            if(empty($supplier) || is_null($supplier)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }
            $supplier->delete();
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Data berhasil dihapus!',
                'alert-type' => 'info',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Delete Supplier Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function batchList(){
        $identifier = $this->getStoreIdentifier();
        $batch = Batch::where('store_identifier', $identifier)
                        ->latest()
                        ->get();
        return view('tenant.tenant_batch_list', compact('batch'));
    }

    public function batchInsert(Request $request){
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
        $action = "Tenant : Batch New Batch";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            Batch::create([
                'store_identifier' => $identifier,
                'batch_code' => $request->name,
                'keterangan' => $request->keterangan
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data berhasil ditambahkan!',
                'alert-type' => 'info',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Add Batch Code Error!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function batchUpdate(Request $request){
        $action = "Tenant : Batch Update";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $batch = Batch::where('store_identifier', $identifier)
                            ->find($request->id);

            if(empty($batch) || is_null($batch)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $batch->update([
                'batch_code' => $request->name,
                'keterangan' => $request->keterangan
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data berhasil diupdate!',
                'alert-type' => 'info',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Data Batch gagal diupdate!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function batchDelete($id){
        $action = "Tenant : Batch Delete";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $batch = Batch::where('store_identifier', $identifier)
                            ->find($id);

            if(empty($batch) || is_null($batch)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $batch->delete();

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data berhasil dihapus!',
                'alert-type' => 'info',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Data gagal dihapus!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function categoryList(){
        $identifier = $this->getStoreIdentifier();
        $category = ProductCategory::where('store_identifier', $identifier)
                                    ->latest()
                                    ->get();
        return view('tenant.tenant_category_list', compact('category'));
    }

    public function categoryInsert(Request $request) {
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $action = "Tenant : Add new Category";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            ProductCategory::create([
                'store_identifier' => $identifier,
                'name' => $request->category
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data berhasil ditambahkan!',
                'alert-type' => 'info',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Tambah data kategori gagal!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function categoryUpdate(Request $request){
        $action = "Tenant : Category Update";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $category = ProductCategory::where('store_identifier', $identifier)
                                    ->find($request->id);

            if(empty($category) || is_null($category)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $category->update([
                'name'  => $request->category
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data berhasil diupdate!',
                'alert-type' => 'info',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Update data kategori gagal!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function categoryDelete($id){
        $action = "Tenant : Category Delete";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $category = ProductCategory::where('store_identifier', $identifier)
                                    ->find($id);

            if(empty($category) || is_null($category)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $category->delete();

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data berhasil dihapus!',
                'alert-type' => 'info',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Hapus data kategori gagal!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function batchProductList(){
        $identifier = $this->getStoreIdentifier();
        $product = Product::with(['category'])
                            ->where('store_identifier', $identifier)
                            ->latest()
                            ->get();
        return view('tenant.tenant_product_list', compact('product'));
    }

    public function batchProductAdd(){
        return view('tenant.tenant_product_add');
    }

    public function batchProductInsert(Request $request){
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $action = "Tenant : Batch Product Add";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
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
                'store_identifier' => $identifier,
                'id_batch' => $request->batch,
                'id_category' => $request->category,
                'product_name' => $request->p_name,
                'id_supplier' => $request->supplier,
                'photo' => $filename,
                'nomor_gudang' => $request->gudang,
                'nomor_rak' => $request->rak,
                'tanggal_beli' => $request->t_beli,
                'tanggal_expired' => $request->t_expired,
                'harga_jual' => (int) $request->h_jual
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data produk berhasil ditambahkan!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.product.batch.list')->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Tambah Batch Produk baru gagal!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function batchProductDetail($id){
        $identifier = $this->getStoreIdentifier();
        $product = Product::where('store_identifier', $identifier)->find($id);

        if(empty($product) || is_null($product)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );

            return redirect()->back()->with($notification);
        }

        $stockList = ProductStock::with('product')->where('store_identifier', $identifier)->where('id_batch_product', $id)->latest()->get();
        return view('tenant.tenant_product_detail', compact('product', 'stockList'));
    }

    public function batchProductEdit($id){
        $identifier = $this->getStoreIdentifier();
        $product = Product::where('store_identifier', $identifier)
                            ->find($id);

        if(empty($product) || is_null($product)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );

            return redirect()->back()->with($notification);
        }

        return view('tenant.tenant_product_edit', compact('product'));
    }

    public function batchProductUpdate(Request $request){
        $action = "Tenant : Batch Product Update";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $product = Product::where('store_identifier', $identifier)
                                ->find($request->id);

            if(empty($product) || is_null($product)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

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
            }

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data produk berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.product.batch.list')->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Update data Batch Product gagal!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function batchProductDelete($id){
        $action = "Tenant : Batch Product Delete";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $product = Product::where('store_identifier', $identifier)
                                ->find($id);

            if(empty($product) || is_null($product)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $stok = ProductStock::where('id_batch_product', $product->id)
                                ->where('store_identifier', $identifier)
                                ->get();
            foreach($stok as $stock){
                $stock->delete();
            }
            $product->delete();
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Data produk berhasil dihapus!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.product.batch.list')->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Data produk gagal dihapus!',
                'alert-type' => 'error',
            );
            return redirect()->route('tenant.product.batch.list')->with($notification);
        }
    }

    public function productStockList(){
        $identifier = $this->getStoreIdentifier();
        $stock = ProductStock::with('product')
                            ->where('store_identifier', $identifier)
                            ->latest()
                            ->get();
        return view('tenant.tenant_stock_list', compact('stock'));
    }

    public function productStockAdd(){
        return view('tenant.tenant_stock_add');
    }

    public function productStockInsert(Request $request){
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $action = "Tenant : Add New Stock";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            ProductStock::create([
                'store_identifier' => $identifier,
                'id_batch_product' => $request->id_batch_product,
                'barcode' => $request->barcode,
                'tanggal_beli' => $request->t_beli,
                'tanggal_expired' => $request->t_expired,
                'harga_beli' => $request->h_beli,
                'stok' => $request->stok
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data produk stok berhasil ditambahkan!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.product.stock.list')->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Data produk stok gagal ditambahkan',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function productStockEdit($id){
        $identifier = $this->getStoreIdentifier();
        $stock = ProductStock::with('product')
                            ->where('store_identifier', $identifier)
                            ->find($id);

        if(empty($stock) || is_null($stock)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );

            return redirect()->back()->with($notification);
        }

        return view('tenant.tenant_stock_edit', compact('stock'));
    }

    public function productStockUpdate(Request $request){
        $action = "Tenant : Stock Update";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $stock = ProductStock::where('store_identifier', $identifier)
                                ->find($request->id);

            if(empty($stock) || is_null($stock)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $stock->update([
                'barcode' => $request->barcode,
                'tanggal_beli' => $request->t_beli,
                'tanggal_expired' => $request->t_expired,
                'harga_beli' => $request->h_beli,
                'stok' => $request->stok
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data stok produk berhasil diupdate!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.product.stock.list')->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Data stok produk gagal dihapus!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function productStockDelete($id){
        $action = "Tenant : STock Delete";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $stock = ProductStock::where('store_identifier', $identifier)
                                ->find($id);

            if(empty($stock) || is_null($stock)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $stock->delete();
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Data produk stok berhasil dihapus!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.product.stock.list')->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Data produk stok gagal dihapus!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function productStockBarcode($id){
        $identifier = $this->getStoreIdentifier();
        $stok = ProductStock::select(['barcode'])
                            ->where('store_identifier', $identifier)
                            ->find($id);

        if(empty($stok) || is_null($stok)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'warning',
            );

            return redirect()->back()->with($notification);
        }

        return view('tenant.tenant_barcode_show', compact('stok'));
    }

    public function storeManagement(){
        return view('tenant.tenant_dashboard_store_management');
    }

    public function discountModify(){
        $identifier = $this->getStoreIdentifier();
        $diskon = Discount::where('store_identifier', $identifier)->first();
        return view('tenant.tenant_discount_modify', compact('diskon'));
    }

    public function discountModifyInsert(Request $request){
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $action = "Tenant : Modify Discount";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $diskon = Discount::where('store_identifier', $identifier)
                                ->first();

            if(empty($diskon) || is_null($diskon)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $diskon->update([
                'min_harga' => $request->min_harga,
                'diskon' => $request->diskon,
                'start_date' => $request->t_mulai,
                'end_date' => $request->t_akhir,
                'is_active' => $request->status
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data diskon berhasil dimodifikasi!',
                'alert-type' => 'success',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Data diskon gagal dimodifikasi!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function pajakModify(){
        $identifier = $this->getStoreIdentifier();
        $tax = Tax::where('store_identifier', $identifier)
                    ->first();
        return view('tenant.tenant_tax_modify', compact('tax'));
    }

    public function pajakModifyInsert(Request $request){
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $action = "Tenant : Modify Pajak";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $tax = Tax::where('store_identifier', $identifier)
                        ->first();

            if(empty($tax) || is_null($tax)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $tax->update([
                'pajak' => $request->pajak,
                'is_active' => $request->status,
            ]);
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Data pajak berhasil dimodifikasi!',
                'alert-type' => 'success',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);

            $notification = array(
                'message' => 'Data pajak gagal dimodifikasi!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function customField(){
        $identifier = $this->getStoreIdentifier();
        $customField = TenantField::where('store_identifier', $identifier)
                                    ->first();
        return view('tenant.tenant_custom_field_list', compact('customField'));
    }

    public function customFieldInsert(Request $request) {
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            $notification = array(
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $action = "Tenant : Custom Field Insert";
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $customField = TenantField::where('store_identifier', $identifier)
                                        ->find($request->id);

            if(empty($customField) || is_null($customField)){
                $notification = array(
                    'message' => 'Data tidak ditemukan!',
                    'alert-type' => 'warning',
                );

                return redirect()->back()->with($notification);
            }

            $aktivasi_baris_1 = $request->aktivasi_baris_1;
            $aktivasi_baris_2 = $request->aktivasi_baris_2;
            $aktivasi_baris_3 = $request->aktivasi_baris_3;
            $aktivasi_baris_4 = $request->aktivasi_baris_4;
            $aktivasi_baris_5 = $request->aktivasi_baris_5;
            if(is_null($request->baris1)){
                $aktivasi_baris_1 = 0;
            }
            if(is_null($request->baris2)){
                $aktivasi_baris_2 = 0;
            }
            if(is_null($request->baris3)){
                $aktivasi_baris_3 = 0;
            }
            if(is_null($request->baris4)){
                $aktivasi_baris_4 = 0;
            }
            if(is_null($request->baris5)){
                $aktivasi_baris_5 = 0;
            }

            $customField->update([
                'baris1' => $request->baris1,
                'baris2' => $request->baris2,
                'baris3' => $request->baris3,
                'baris4' => $request->baris4,
                'baris5' => $request->baris5,
                'baris_1_activation' => $aktivasi_baris_1,
                'baris_2_activation' => $aktivasi_baris_2,
                'baris_3_activation' => $aktivasi_baris_3,
                'baris_4_activation' => $aktivasi_baris_4,
                'baris_5_activation' => $aktivasi_baris_5,
            ]);

            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);

            $notification = array(
                'message' => 'Data berhasil diupdate!',
                'alert-type' => 'success',
            );

            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Data gagal diupdate!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function tenantTransaction(){
        $identifier = $this->getStoreIdentifier();
        $allTransaksiCount = Invoice::where('store_identifier', $identifier)
                                    ->count();
        $transaksiHariIniCount= Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                    ->where('store_identifier', $identifier)
                                    ->count();
        $transaksiPendingCount= Invoice::where('store_identifier', $identifier)
                                    ->whereNull('jenis_pembayaran')
                                    ->count();
        $paymentPendingCount= Invoice::where('store_identifier', $identifier)
                                    ->where('status_pembayaran', 0)
                                    ->count();
        $invoiceFinishCount = Invoice::where('store_identifier', $identifier)
                                    ->where('status_pembayaran', 1)
                                    ->count();
        $invoicePaymentQrisFinish = Invoice::where('store_identifier', $identifier)
                                    ->where('jenis_pembayaran', 'Qris')
                                    ->where('status_pembayaran', 1)
                                    ->count();
        return view('tenant.tenant_transaction', compact('allTransaksiCount', 'transaksiHariIniCount', 'transaksiPendingCount', 'paymentPendingCount', 'invoiceFinishCount', 'invoicePaymentQrisFinish'));
    }

    public function transactionList(){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::where('store_identifier', $identifier)
                            ->select(['invoices.id',
                                        'invoices.id_kasir',
                                        'invoices.nomor_invoice',
                                        'invoices.tanggal_transaksi',
                                        'invoices.tanggal_pelunasan',
                                        'invoices.jenis_pembayaran',
                                        'invoices.status_pembayaran',
                                        'invoices.sub_total',
                                        'invoices.pajak',
                                        'invoices.diskon',
                                        'invoices.nominal_bayar',
                                        'invoices.kembalian',
                                        'invoices.mdr',
                                        'invoices.nominal_mdr',
                                        'invoices.nominal_terima_bersih',
                                    ])
                            ->with(['kasir' => function($query){
                                $query->select(['kasirs.id', 'kasirs.name']);
                            }])
                            ->latest()
                            ->get();
        return view('tenant.tenant_transaction_list', compact('invoice'));
    }

    public function tenantThisDayTransaction(){
        $identifier = $this->getStoreIdentifier();
        $transaksiHariIni= Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                    ->where('store_identifier', $identifier)
                                    ->select(['invoices.id',
                                                'invoices.id_kasir',
                                                'invoices.nomor_invoice',
                                                'invoices.tanggal_transaksi',
                                                'invoices.tanggal_pelunasan',
                                                'invoices.jenis_pembayaran',
                                                'invoices.status_pembayaran',
                                                'invoices.sub_total',
                                                'invoices.pajak',
                                                'invoices.diskon',
                                                'invoices.mdr',
                                                'invoices.nominal_mdr',
                                                'invoices.nominal_terima_bersih',
                                            ])
                                    ->with(['kasir' => function($query){
                                        $query->select(['kasirs.id', 'kasirs.name']);
                                    }])
                                    ->latest()
                                    ->get();
        return view('tenant.tenant_transaction_transaksi_hari_ini', compact('transaksiHariIni'));
    }

    public function transactionFinishList(){
        $identifier = $this->getStoreIdentifier();
        $invoiceFinish = Invoice::where('store_identifier', $identifier)
                                    ->where('status_pembayaran', 1)
                                    ->select(['invoices.id',
                                                'invoices.id_kasir',
                                                'invoices.nomor_invoice',
                                                'invoices.tanggal_transaksi',
                                                'invoices.tanggal_pelunasan',
                                                'invoices.jenis_pembayaran',
                                                'invoices.status_pembayaran',
                                                'invoices.sub_total',
                                                'invoices.pajak',
                                                'invoices.diskon',
                                                'invoices.mdr',
                                                'invoices.nominal_mdr',
                                                'invoices.nominal_terima_bersih',
                                            ])
                                    ->with(['kasir' => function($query){
                                        $query->select(['kasirs.id', 'kasirs.name']);
                                    }])
                                    ->latest()
                                    ->get();
        return view('tenant.tenant_transaction_finish_list', compact('invoiceFinish'));
    }

    public function transactionQrisFinishList(){
        $identifier = $this->getStoreIdentifier();
        $invoiceQrisFinish = Invoice::where('store_identifier', $identifier)
                                    ->where('jenis_pembayaran', 'Qris')
                                    ->where('status_pembayaran', 1)
                                    ->select(['invoices.id',
                                                'invoices.id_kasir',
                                                'invoices.nomor_invoice',
                                                'invoices.tanggal_transaksi',
                                                'invoices.tanggal_pelunasan',
                                                'invoices.jenis_pembayaran',
                                                'invoices.status_pembayaran',
                                                'invoices.sub_total',
                                                'invoices.pajak',
                                                'invoices.diskon',
                                                'invoices.mdr',
                                                'invoices.nominal_mdr',
                                                'invoices.nominal_terima_bersih',
                                            ])
                                    ->with(['kasir' => function($query){
                                        $query->select(['kasirs.id', 'kasirs.name']);
                                    }])
                                    ->latest()
                                    ->get();
        return view('tenant.tenant_transaction_qris_finish_list', compact('invoiceQrisFinish'));
    }

    public function transactionListPending(){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::with(['customer' => function($query){
                                $query->select(['customer_identifiers.id_invoice', 'customer_identifiers.customer_info', 'customer_identifiers.description']);
                            }])
                            ->where('store_identifier', $identifier)
                            ->where('jenis_pembayaran', NULL)
                            ->where('status_pembayaran', 0)
                            ->select(['invoices.id', 'invoices.id_kasir', 'invoices.nomor_invoice', 'invoices.tanggal_transaksi', 'invoices.jenis_pembayaran', 'invoices.status_pembayaran'])
                            ->with(['kasir' => function($query){
                                $query->select(['kasirs.id', 'kasirs.name', 'kasirs.id_store']);
                            }])
                            ->latest()
                            ->get();
        return view('tenant.tenant_transaction_list_pending', compact('invoice'));
    }

    public function transactionListPendingPayment(){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::where('store_identifier', $identifier)
                        ->where('jenis_pembayaran', "Qris")
                        ->where('status_pembayaran', 0)
                        ->select(['invoices.id',
                                    'invoices.id_kasir',
                                    'invoices.nomor_invoice',
                                    'invoices.tanggal_transaksi',
                                    'invoices.tanggal_pelunasan',
                                    'invoices.jenis_pembayaran',
                                    'invoices.status_pembayaran',
                                    'invoices.sub_total',
                                    'invoices.pajak',
                                    'invoices.diskon',
                                    'invoices.mdr',
                                    'invoices.nominal_mdr',
                                    'invoices.nominal_terima_bersih',
                                ])
                        ->with(['kasir' => function($query){
                            $query->select(['kasirs.id', 'kasirs.name']);
                        }])
                        ->latest()
                        ->get();
        return view('tenant.tenant_transaction_list_pending_payment', compact('invoice'));
    }

    public function transactionInvoiceView($id){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::with('shoppingCart', 'invoiceField', 'kasir')
                            ->where('store_identifier', $identifier)
                            ->whereNotNull('jenis_pembayaran')
                            ->find($id);

        if(is_null($invoice) || empty($invoice)){
            $notification = array(
                'message' => 'Transaksi tidak ditemukan atau belum diproses!',
                'alert-type' => 'warning',
            );

            return redirect()->route('tenant.transaction.list')->with($notification);
        }

        return view('tenant.tenant_invoice_detail', compact('invoice'));
    }

    public function financeDashboard(){
        return view('tenant.tenant_finance');
    }

    public function financePemasukan(){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::where('store_identifier', $identifier)
                            ->select(['invoices.id',
                                        'invoices.id_kasir',
                                        'invoices.nomor_invoice',
                                        'invoices.tanggal_transaksi',
                                        'invoices.tanggal_pelunasan',
                                        'invoices.jenis_pembayaran',
                                        'invoices.status_pembayaran',
                                        'invoices.sub_total',
                                        'invoices.pajak',
                                        'invoices.diskon',
                                        'invoices.mdr',
                                        'invoices.nominal_mdr',
                                        'invoices.nominal_terima_bersih',
                                    ])
                            ->with(['kasir' => function($query){
                                $query->select(['kasirs.id', 'kasirs.name']);
                            }])
                            ->where('status_pembayaran', 1)
                            ->latest()
                            ->get();


        $pemasukanQrisHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                        ->where('store_identifier', $identifier)
                                        ->where('status_pembayaran', 1)
                                        ->where('jenis_pembayaran', 'Qris')
                                        ->sum('nominal_terima_bersih');
        $pemasukanUnaiHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                        ->where('store_identifier', $identifier)
                                        ->where('status_pembayaran', 1)
                                        ->where('jenis_pembayaran', 'Tunai')
                                        ->sum(DB::raw('sub_total + pajak'));

        $pemasukanQrisBulanIni = Invoice::whereMonth('tanggal_transaksi', Carbon::now()->month)
                                        ->where('store_identifier', $identifier)
                                        ->where('status_pembayaran', 1)
                                        ->where('jenis_pembayaran', 'Qris')
                                        ->sum('nominal_terima_bersih');
        $pemasukanUnaiBulanIni = Invoice::whereMonth('tanggal_transaksi', Carbon::now()->month)
                                        ->where('store_identifier', $identifier)
                                        ->where('status_pembayaran', 1)
                                        ->where('jenis_pembayaran', 'Tunai')
                                        ->sum(DB::raw('sub_total + pajak'));

        $totalPemasukanTunai = Invoice::where('store_identifier', $identifier)
                                        ->where('jenis_pembayaran', 'Tunai')
                                        ->where('status_pembayaran', 1)
                                        ->sum(DB::raw('sub_total + pajak'));
        $totalPemasukanQris = Invoice::where('store_identifier', $identifier)
                                        ->where('jenis_pembayaran', 'Qris')
                                        ->where('status_pembayaran', 1)
                                        ->sum('nominal_terima_bersih');

        $totalPemasukan = $totalPemasukanTunai+$totalPemasukanQris;
        $totalPemasukanHariini = $pemasukanQrisHariIni+$pemasukanUnaiHariIni;
        $totalPemasukanBulanIni = $pemasukanQrisBulanIni+$pemasukanUnaiBulanIni;

        return view('tenant.tenant_finance_pemasukan', compact(['invoice', 'totalPemasukan', 'totalPemasukanHariini', 'totalPemasukanBulanIni']));
    }

    public function pemasukanTunai(){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::where('store_identifier', $identifier)
                            ->select(['invoices.id', 'invoices.id_kasir', 'invoices.nomor_invoice', 'invoices.tanggal_transaksi', 'invoices.jenis_pembayaran', 'invoices.status_pembayaran', 'invoices.sub_total', 'invoices.pajak'])
                            ->with(['kasir' => function($query){
                                $query->select(['kasirs.id', 'kasirs.name']);
                            }])
                            ->where('invoices.jenis_pembayaran', 'Tunai')
                            ->where('status_pembayaran', 1)
                            ->latest()
                            ->get();

        $totalPemasukanTunai = Invoice::where('store_identifier', $identifier)
                                        ->where('invoices.jenis_pembayaran', 'Tunai')
                                        ->where('status_pembayaran', 1)
                                        ->sum(DB::raw('sub_total + pajak'));

        $totalPemasukanTunaiHariini = Invoice::where('store_identifier', $identifier)
                                                ->where('invoices.jenis_pembayaran', 'Tunai')
                                                ->where('status_pembayaran', 1)
                                                ->whereDate('tanggal_transaksi', Carbon::today())
                                                ->sum(DB::raw('sub_total + pajak'));

        $totalPemasukanTunaiBulanIni = Invoice::where('store_identifier', $identifier)
                                                ->where('invoices.jenis_pembayaran', 'Tunai')
                                                ->where('status_pembayaran', 1)
                                                ->whereMonth('tanggal_transaksi', Carbon::now()->month)
                                                ->sum(DB::raw('sub_total + pajak'));

        return view('tenant.tenant_finnance_pemasukan_tunai', compact(['invoice', 'totalPemasukanTunai', 'totalPemasukanTunaiHariini', 'totalPemasukanTunaiBulanIni']));
    }

    public function pemasukanQrisPending(){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::where('store_identifier', $identifier)
                            ->select(['invoices.id',
                                        'invoices.id_kasir',
                                        'invoices.nomor_invoice',
                                        'invoices.tanggal_transaksi',
                                        'invoices.tanggal_pelunasan',
                                        'invoices.jenis_pembayaran',
                                        'invoices.status_pembayaran',
                                        'invoices.sub_total',
                                        'invoices.pajak',
                                        'invoices.diskon',
                                        'invoices.mdr',
                                        'invoices.nominal_mdr',
                                        'invoices.nominal_terima_bersih',
                                    ])
                            ->with(['kasir' => function($query){
                                $query->select(['kasirs.id', 'kasirs.name']);
                            }])
                            ->whereDate('tanggal_transaksi', Carbon::yesterday())
                            ->where('status_pembayaran', 1)
                            ->where('invoices.jenis_pembayaran', 'Qris')
                            ->latest()
                            ->get();
        return view('tenant.tenant_finnance_pemasukan_qris_pending', compact('invoice'));
    }

    public function pemasukanQrisToday(){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::where('store_identifier', $identifier)
                            ->select(['invoices.id',
                                'invoices.id_kasir',
                                'invoices.nomor_invoice',
                                'invoices.tanggal_transaksi',
                                'invoices.tanggal_pelunasan',
                                'invoices.jenis_pembayaran',
                                'invoices.status_pembayaran',
                                'invoices.sub_total',
                                'invoices.pajak',
                                'invoices.diskon',
                                'invoices.mdr',
                                'invoices.nominal_mdr',
                                'invoices.nominal_terima_bersih',
                            ])
                            ->with(['kasir' => function($query){
                                $query->select(['kasirs.id', 'kasirs.name']);
                            }])
                            ->whereDate('tanggal_transaksi', Carbon::now())
                            ->where('status_pembayaran', 1)
                            ->where('invoices.jenis_pembayaran', 'Qris')
                            ->latest()
                            ->get();
        return view('tenant.tenant_finnance_pemasukan_qris_today', compact('invoice'));
    }

    public function pemasukanQris(){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::where('store_identifier', $identifier)
                            ->select(['invoices.id',
                                'invoices.id_kasir',
                                'invoices.nomor_invoice',
                                'invoices.tanggal_transaksi',
                                'invoices.tanggal_pelunasan',
                                'invoices.jenis_pembayaran',
                                'invoices.status_pembayaran',
                                'invoices.sub_total',
                                'invoices.pajak',
                                'invoices.diskon',
                                'invoices.mdr',
                                'invoices.nominal_mdr',
                                'invoices.nominal_terima_bersih',
                            ])
                            ->with(['kasir' => function($query){
                                $query->select(['kasirs.id', 'kasirs.name']);
                            }])
                            ->where('status_pembayaran', 1)
                            ->where('invoices.jenis_pembayaran', 'Qris')
                            ->latest()
                            ->get();

        $totalPemasukanQris = Invoice::where('store_identifier', $identifier)
                                        ->where('invoices.jenis_pembayaran', 'Qris')
                                        ->where('status_pembayaran', 1)
                                        ->sum(DB::raw('nominal_terima_bersih'));

        $totalPemasukanQrisHariini = Invoice::where('store_identifier', $identifier)
                                                ->where('invoices.jenis_pembayaran', 'Qris')
                                                ->where('status_pembayaran', 1)
                                                ->whereDate('tanggal_transaksi', Carbon::today())
                                                ->sum('nominal_terima_bersih');

        $totalPemasukanQrisBulanIni = Invoice::where('store_identifier', $identifier)
                                                ->where('invoices.jenis_pembayaran', 'Qris')
                                                ->where('status_pembayaran', 1)
                                                ->whereMonth('tanggal_transaksi', Carbon::now()->month)
                                                ->sum('nominal_terima_bersih');

        return view('tenant.tenant_finnance_pemasukan_qris', compact(['invoice', 'totalPemasukanQris', 'totalPemasukanQrisHariini', 'totalPemasukanQrisBulanIni']));
    }

    public function saldoData(){
        $identifier = $this->getStoreIdentifier();
        $tunai = TunaiWallet::where('id_tenant', auth()->user()->id)->first();
        $qris = QrisWallet::where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $qrisPending = Invoice::where('store_identifier', $identifier)
                                ->whereDate('tanggal_transaksi', Carbon::yesterday())
                                ->where('jenis_pembayaran', 'Qris')
                                ->where('status_pembayaran', 1)
                                ->sum('nominal_terima_bersih');
        $qrisHariIni = Invoice::where('store_identifier', $identifier)
                                ->whereDate('tanggal_transaksi', Carbon::now())
                                ->where('jenis_pembayaran', 'Qris')
                                ->where('status_pembayaran', 1)
                                ->sum('nominal_terima_bersih');
        $invoiceQrisSukses = Invoice::where('store_identifier', $identifier)
                                    ->select(['invoices.id',
                                        'invoices.id_kasir',
                                        'invoices.nomor_invoice',
                                        'invoices.tanggal_transaksi',
                                        'invoices.tanggal_pelunasan',
                                        'invoices.jenis_pembayaran',
                                        'invoices.status_pembayaran',
                                        'invoices.sub_total',
                                        'invoices.pajak',
                                        'invoices.diskon',
                                        'invoices.mdr',
                                        'invoices.nominal_mdr',
                                        'invoices.nominal_terima_bersih',
                                    ])
                                    ->with(['kasir' => function($query){
                                        $query->select(['kasirs.id', 'kasirs.name']);
                                    }])
                                    ->where('status_pembayaran', 1)
                                    ->whereDate('tanggal_transaksi', Carbon::today())
                                    ->latest()
                                    ->get();
        return view('tenant.tenant_finance_saldo', compact('tunai', 'qris', 'qrisPending', 'invoiceQrisSukses', 'qrisHariIni'));
    }

    public function historyPenarikan(){
        $withdrawData = Withdrawal::where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->latest();
        $allData = $withdrawData->get();
        $penarikanTerbaru = $withdrawData->latest()->first();
        $allDataSum = $withdrawData->sum('nominal');

        return view('tenant.tenant_finance_penarikan', compact(['allData', 'penarikanTerbaru', 'allDataSum']));
    }

    public function invoiceTarikDana($id){
        $withdrawData = Withdrawal::select([ 'withdrawals.id',
                                             'withdrawals.email',
                                             'withdrawals.tanggal_penarikan',
                                             'withdrawals.nominal',
                                             'withdrawals.biaya_admin',
                                             'withdrawals.tanggal_masuk',
                                             'withdrawals.status'
                                            ])
                                ->where('email', auth()->user()->email)
                                ->find($id);
        if(is_null($withdrawData) || empty($withdrawData)){
            $notification = array(
                'message' => 'Data tidak ditemukan!',
                'alert-type' => 'info',
            );

            return redirect()->route('tenant.finance.history_penarikan')->with($notification);
        }
        $rekening = Rekening::select(['swift_code', 'no_rekening'])
                            ->where('id_user', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        return view('tenant.tenant_penarikan_invoice', compact(['withdrawData', 'withdrawData', 'rekening']));
    }
}
