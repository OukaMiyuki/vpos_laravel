<?php

namespace App\Http\Controllers\Auth\Tenant\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Marketing;
use App\Models\Tenant;
use App\Models\Kasir;
use App\Models\StoreDetail;
use App\Models\ProductStock;
use App\Models\TenantField;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TenantQrisAccount;
use App\Models\TunaiWallet;
use App\Models\Invoice;
use App\Models\InvoiceField;
use App\Models\ShoppingCart;
use App\Models\Tax;
use App\Models\Discount;
use App\Models\Withdrawal;
use App\Models\AppVersion;
use App\Models\History;
use App\Models\Supplier;
use App\Models\Batch;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Exception;

class TenantController extends Controller {

    private function getAppversion(){
        $appVersion = AppVersion::find(1);
        return $appVersion->versi;
    }

    public function getStoreIdentifier(){
        $store = StoreDetail::select(['store_identifier'])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $identifier = $store->store_identifier;
        return $identifier;
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
        $user_id = auth()->user()->id;
        $user_email = auth()->user()->email;
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($PublicIP);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        $user_location = "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")";

        $history = History::create([
            'id_user' => $user_id,
            'email' => $user_email
        ]);

        if(!is_null($history) || !empty($history)) {
            $history->createHistory($history, $action, $user_location, $PublicIP, $log, $status);
        }
    }

    public function storeInfo() : JsonResponse {
        $store = "";
        try {
            $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if($store->count() == 0 || $store == "" || empty($store) || is_null($store)){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'Data toko masih kosong!',
                'storeData' => $store,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'storeData' => $store,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function storeUpdate(Request $request) : JsonResponse {
        $nama_toko = $request->nama_toko;
        $no_telp_toko = $request->no_telp_toko;
        $jenis_usaha = $request->jenis_usaha;
        $alamat_toko = $request->alamat_toko;
        $kab_kota = $request->kab_kota;
        $kode_pos = $request->kode_pos;
        $catatan_kaki = $request->catatan_kaki;
        DB::connection()->enableQueryLog();

        try {
            $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
            $store->update([
                'name' => $nama_toko,
                'alamat' => $alamat_toko,
                'kabupaten' => $kab_kota,
                'kode_pos' => $kode_pos,
                'no_telp_toko' => $no_telp_toko,
                'jenis_usaha' => $jenis_usaha,
                'catatan_kaki' => $catatan_kaki,
            ]);
            $action = "Tenant API : Update Store Information";
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            return response()->json([
                'message' => 'Data has ben updated!',
                'storeData' => $store,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
    }

    public function aliasList() : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $alias = "";

        try {
            $alias = TenantField::where('store_identifier', $identifier)->first();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if($alias->count() == 0 || $alias == "" || empty($alias) || is_null($alias)){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'No data found in this collection!',
                'alias-data' => $alias,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'alias-data' => $alias,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function aliasUpdate(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();

        $alias = "";
        try {
            $alias = TenantField::where('store_identifier', $identifier)->first();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Checkup Failed!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        $baris1 = $request->baris1;
        $baris2 = $request->baris2;
        $baris3 = $request->baris3;
        $baris4 = $request->baris4;
        $baris5 = $request->baris5;
        $baris1_activation = 1;
        $baris2_activation = 1;
        $baris3_activation = 1;
        $baris4_activation = 1;
        $baris5_activation = 1;

        if(is_null($baris1)){
            $baris1_activation = 0;
        } else {
            $baris1_activation = 1;
        }
        if(is_null($baris2)){
            $baris2_activation = 0;
        } else {
            $baris2_activation = 1;
        }
        if(is_null($baris3)){
            $baris3_activation = 0;
        } else {
            $baris3_activation = 1;
        }
        if(is_null($baris4)){
            $baris4_activation = 0;
        } else {
            $baris4_activation = 1;
        }
        if(is_null($baris5)){
            $baris5_activation = 0;
        } else {
            $baris5_activation = 1;
        }

        try {
            $alias->update([
                'baris1' => $baris1,
                'baris2' => $baris2,
                'baris3' => $baris3,
                'baris4' => $baris4,
                'baris5' => $baris5,
                'baris_1_activation' => $baris1_activation,
                'baris_2_activation' => $baris2_activation,
                'baris_3_activation' => $baris3_activation,
                'baris_4_activation' => $baris4_activation,
                'baris_5_activation' => $baris5_activation,
            ]);
            return response()->json([
                'message' => 'Updated Success!',
                'alias-data' => $alias,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Checkup Failed!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
    }

    public function kasirList() : JsonResponse {
        $kasir = "";
        $identifier = $this->getStoreIdentifier();
        try {
            $kasir = Kasir::select(['id','name', 'email', 'is_active'])
                            ->where('id_store', $identifier)
                            ->latest()
                            ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if($kasir->count() == 0 || $kasir == "" || is_null($kasir) || empty($kasir)){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'No data found in this collection!',
                'dataStokProduk' => $kasir,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'kasir-list' => $kasir,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function kasirDetail(Request $request) : JsonResponse {
        $id = $request->id_kasir;
        $identifier = $this->getStoreIdentifier();
        $kasir = "";
        try {
            $kasir = Kasir::with('detail')
                            ->where('id_store', $identifier)
                            ->findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        return response()->json([
            'message' => 'Fetch Success!',
            'kasir-detail' => $kasir,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function kasirRegister(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        DB::connection()->enableQueryLog();
        $action = "Tenant API : Register New Cashier";
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'phone' => ['required', 'string', 'numeric', 'digits_between:1,20', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        try {
            $kasir = Kasir::create([
                'id_store' => $identifier,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
            if(!is_null($kasir)) {
                $kasir->detailKasirStore($kasir);
            }
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            return response()->json([
                'message' => 'Data has been added!',
                'kasir-data' => $kasir,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } catch (Exception $e) { 
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Failed to add data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
    }

    public function kasirActivation(Request $request) : JsonResponse{
        DB::connection()->enableQueryLog();
        $action = "Tenant API : Update Kasir Activation";
        try{
            $identifier = $this->getStoreIdentifier();
            $kasir = Kasir::where('id_store', $identifier)->find($request->id_kasir);

            if(is_null($kasir) || empty($kasir)){
                return response()->json([
                    'message' => 'Account not Found!',
                    'status' => 404,
                ]);
            }

            if($kasir->is_active == 0){
                $kasir->update([
                    'is_active' => 1
                ]);
            } else if($kasir->is_active == 1){
                $kasir->update([
                    'is_active' => 0
                ]);
            }
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            return response()->json([
                'message' => 'Update Success!',
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);

        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Database Error!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
        }
    }

    public function productList() : JsonResponse{
        $identifier = $this->getStoreIdentifier();
        $product = "";
        try {
            $product = ProductStock::with(['product' => function ($query) {
                                            $query->where('harga_jual', '!=',0);
                                    }])
                                    ->where(function ($query) {
                                            $query->where('stok', '!=', 0);
                                                // ->where('harga_beli', '!=', 0);
                                    })
                                    ->where('store_identifier', $identifier)
                                    ->latest()
                                    ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if($product->count() == 0 || $product == "" || is_null($product) || empty($product)){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'No data found in this collection!',
                'data-product' => $product,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'data-product-stock' => $product,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function productType() : JsonResponse{
        $typeBarang = array(
            'PCS' => array(
                'Qty' => array(
                    'PCS'
                ),
                'Jumlah' => array(
                    'Lusin',
                    'Gross',
                    'Kodi',
                    'Rim'
                )
            ),
            'Pack' => array(
                'Berat' => array(
                    'Kg - (Kilogram)',
                    'g - (gram)',
                    'Ons',
                    'Mg - (Miligram)',
                    'Ton',
                    'Kw - (Kuintal)'
                ),
                'Jarak' => array(
                    'km - (Kilometer)'
                ),
                'Volume' => array(
                    'kl - (Kiloliter)',
                    'hl - (Hektaliter)',
                    'dal - (Dekaliter)',
                    'l - (Liter)',
                    'dl - (Desiliter)',
                    'cl - (Centiliter)',
                    'ml - (Mililiter)'
                ),
                'Panjang' => array(
                    'km - (Kilometer)',
                    'hm - (Hektometer)',
                    'dam - (Dekameter)',
                    'm - (Meter)',
                    'dm - (Desimeter)',
                    'cm - (Centimeter)',
                    'mm - (Milimeter)',
                    'inch - (Inchi)'
                )
            ),
            'Custom' => array(
                'Custom' => array(
                    'Custom'
                )
            )
        );

        return response()->json([
            'message' => 'Fetch Success!',
            'status' => 200,
            'tipe-barang' => $typeBarang,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function productInsert(Request $request) : JsonResponse {
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
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
                    return response()->json([
                        'message' => 'Gagal upload gambar!',
                        'status' => 500,
                        'app-version' => $this->getAppversion()
                    ]);
                }
    
                $satuanHargaJual = 0;
                if($request->tipe_barang != "Custom"){
                    $satuanHargaJual = $request->harga_jual;
                }
    
                $product = Product::create([
                    'store_identifier' => $identifier,
                    'id_batch' => $request->id_batch,
                    'id_category' => $request->id_category,
                    'product_name' => $request->product_name,
                    'id_supplier' => $request->id_supplier,
                    'photo' => $filename,
                    'nomor_gudang' => $request->nomor_gudang,
                    'nomor_rak' => $request->nomor_rak,
                    // 'tanggal_beli' => $request->t_beli,
                    // 'tanggal_expired' => $request->t_expired,
                    'harga_jual' => (int) $satuanHargaJual,
                    'tipe_barang' => $request->tipe_barang,
                    'satuan_barang' => $request->satuan_barang,
                    'satuan_unit' => $request->satuan_unit,
                ]);
                
                return response()->json([
                    'message' => 'Data product berhasil diinput!',
                    'status' => 200,
                    'product' => $product,
                    'app-version' => $this->getAppversion()
                ]);
            } catch(Exception $e){
                // return $e;
                return response()->json([
                    'message' => 'Gagal menginput barang!',
                    'status' => 500,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
    }

    public function productUdate (Request $request)  : JsonResponse {
        try{
            $identifier = $this->getStoreIdentifier();
            $product = Product::where('store_identifier', $identifier)->find($request->id_product);

            if(empty($product) || is_null($product)){
                return response()->json([
                    'message' => 'Data tidak ditemukan!',
                    'status' => 404,
                    'app-version' => $this->getAppversion()
                ]);
            }

            $satuanHargaJual = 0;
            if($request->tipe_barang != "Custom"){
                $satuanHargaJual = $request->harga_jual;
            }

            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $namaFile = $product->product_name;
                $storagePath = Storage::path('public/images/product');
                $ext = $file->getClientOriginalExtension();
                $filename = $namaFile.'-'.time().'.'.$ext;

                if(empty($product->photo)){
                    try {
                        $file->move($storagePath, $filename);
                    } catch (\Exception $e) {
                        return response()->json([
                            'message' => 'Gagal upload gambar!',
                            'status' => 500,
                            'app-version' => $this->getAppversion()
                        ]);
                    }
                } else {
                    Storage::delete('public/images/product/'.$product->photo);
                    $file->move($storagePath, $filename);
                }

                $product->update([
                    'id_batch' => $request->id_batch,
                    'id_category' => $request->id_category,
                    'product_name' => $request->product_name,
                    'id_supplier' => $request->id_supplier,
                    'photo' => $filename,
                    'nomor_gudang' => $request->nomor_gudang,
                    'nomor_rak' => $request->nomor_rak,
                    'harga_jual' => $satuanHargaJual,
                    'tipe_barang' => $request->tipe_barang,
                    'satuan_barang' => $request->satuan_barang,
                    'satuan_unit' => $request->satuan_unit,
                ]);
            } else {
                $product->update([
                    'id_batch' => $request->id_batch,
                    'id_category' => $request->id_category,
                    'product_name' => $request->product_name,
                    'id_supplier' => $request->id_supplier,
                    'nomor_gudang' => $request->nomor_gudang,
                    'nomor_rak' => $request->nomor_rak,
                    'harga_jual' => $satuanHargaJual,
                    'tipe_barang' => $request->tipe_barang,
                    'satuan_barang' => $request->satuan_barang,
                    'satuan_unit' => $request->satuan_unit,
                ]);
            }
            return response()->json([
                'message' => 'Data product berhasil diupdate!',
                'status' => 200,
                'product' => $product,
                'app-version' => $this->getAppversion()
            ]);
        } catch(Exception $e){
            return response()->json([
                'message' => 'Gagal mengupdate data barang!',
                'status' => 500,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function productDelete($id_product)  : JsonResponse {
        try{
            $identifier = $this->getStoreIdentifier();
            $product = Product::where('store_identifier', $identifier)
                                ->find($id_product);

            if(empty($product) || is_null($product)){
                return response()->json([
                    'message' => 'Data tidak ditemukan!',
                    'status' => 404,
                    'app-version' => $this->getAppversion()
                ]);
            }

            $stok = ProductStock::where('id_batch_product', $product->id)
                                ->where('store_identifier', $identifier)
                                ->get();
            foreach($stok as $stock){
                $stock->delete();
            }
            Storage::delete('public/images/product/'.$product->photo);
            $product->delete();
            return response()->json([
                'message' => 'Data product berhasil dihapus!',
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } catch(Exception $e){
            return response()->json([
                'message' => 'Gagal menghapus data barang!',
                'status' => 500,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function productDetail(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $stock = "";
        $id = $request->id;
        try {
            $stock = ProductStock::with(['product' => function ($query) {
                        $query->with('category')->get();
                    }])
                    ->where(function ($query){
                            $query->where('stok', '!=', 0);
                    })->where('store_identifier', $identifier)
                    ->findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        return response()->json([
            'message' => 'Fetch Success',
            'data-detail-stock' => $stock,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function supplierList() : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $supplierList = "";

        try {
            $supplierList = Supplier::select([
                                                'id',
                                                'nama_supplier', 
                                                'email_supplier', 
                                                'phone_supplier', 
                                                'alamat_supplier', 
                                                'keterangan'
                                            ])
                                            ->where('store_identifier', $identifier)
                                            ->latest()
                                            ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        if($supplierList->count() == 0 || $supplierList == ""){
            return response()->json([
                'message' => 'Fetch Success',
                'data-status' => 'No data found in this collection!',
                'productCategory' => $supplierList,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                'productCategory' => $supplierList,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function supplierInsert(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();

        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $supplier = Supplier::create([
                'store_identifier' => $identifier,
                'nama_supplier' => $request->nama_supplier,
                'email_supplier' => $request->email,
                'phone_supplier' => $request->phone,
                'alamat_supplier' => $request->alamat,
                'keterangan' => $request->keterangan
            ]);

            return response()->json([
                'message' => 'Input Data berhasil!',
                'status' => 200,
                'supplier' => $supplier,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function supplierUpdate(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();

        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $supplier = Supplier::where('store_identifier', $identifier)->find($request->id);
            if(is_null($supplier) || empty($supplier)){
                return response()->json([
                    'message' => 'Data tidak ditemukan!',
                    'status' => 404,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                $supplier->update([
                    'nama_supplier' => $request->nama_supplier,
                    'email_supplier' => $request->email,
                    'phone_supplier' => $request->phone,
                    'alamat_supplier' => $request->alamat,
                    'keterangan' => $request->keterangan
                ]);

                return response()->json([
                    'message' => 'Update Data berhasil!',
                    'status' => 200,
                    'supplier' => $supplier,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
    }

    public function supplierDelete($id) : JsonResponse {
        $identifier = $this->getStoreIdentifier();

        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $supplier = Supplier::where('store_identifier', $identifier)->find($id);
            if(is_null($supplier) || empty($supplier)){
                return response()->json([
                    'message' => 'Data tidak ditemukan!',
                    'status' => 404,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                $supplier->delete();

                return response()->json([
                    'message' => 'Data berhasil dihapus!',
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
    }

    public function batchList() : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $batchList = "";

        try {
            $batchList = Batch::select([
                                        'id',
                                        'batch_code', 
                                        'keterangan', 
                                    ])
                                    ->where('store_identifier', $identifier)
                                    ->latest()
                                    ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        if($batchList->count() == 0 || $batchList == ""){
            return response()->json([
                'message' => 'Fetch Success',
                'data-status' => 'No data found in this collection!',
                'productCategory' => $batchList,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                'productCategory' => $batchList,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function batchInsert(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $batch = Batch::create([
                'store_identifier' => $identifier,
                'batch_code' => $request->name,
                'keterangan' => $request->keterangan
            ]);

            return response()->json([
                'message' => 'Input Data berhasil!',
                'status' => 200,
                'supplier' => $batch,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function batchUpdate(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $batch = Batch::where('store_identifier', $identifier)->find($request->id);
            $batch->update([
                'batch_code' => $request->name,
                'keterangan' => $request->keterangan
            ]);

            return response()->json([
                'message' => 'Update Data berhasil!',
                'status' => 200,
                'supplier' => $batch,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function batchDelete($id) : JsonResponse {
        $identifier = $this->getStoreIdentifier();

        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $batch = Batch::where('store_identifier', $identifier)->find($id);
            if(is_null($batch) || empty($batch)){
                return response()->json([
                    'message' => 'Data tidak ditemukan!',
                    'status' => 404,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                $batch->delete();

                return response()->json([
                    'message' => 'Data berhasil dihapus!',
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
    }

    public function productCategory() : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $productCategory = "";
        try {
            $productCategory = ProductCategory::select(['id','name'])->where('store_identifier', $identifier)->latest()->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        if($productCategory->count() == 0 || $productCategory == ""){
            return response()->json([
                'message' => 'Fetch Success',
                'data-status' => 'No data found in this collection!',
                'productCategory' => $productCategory,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                'productCategory' => $productCategory,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function categoryInsert(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $category = ProductCategory::create([
                'store_identifier' => $identifier,
                'name' => $request->category
            ]);

            return response()->json([
                'message' => 'Input Data berhasil!',
                'status' => 200,
                'supplier' => $category,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function categoryUpdate(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $category = ProductCategory::where('store_identifier', $identifier)->find($request->id);

            $category->update([
                'name'  => $request->category
            ]);

            return response()->json([
                'message' => 'Update Data berhasil!',
                'status' => 200,
                'supplier' => $category,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function categoryDelete($id) : JsonResponse {
        $identifier = $this->getStoreIdentifier();

        if(empty(auth()->user()->phone_number_verified_at) || is_null(auth()->user()->phone_number_verified_at) || auth()->user()->phone_number_verified_at == NULL || auth()->user()->phone_number_verified_at == ""){
            return response()->json([
                'message' => 'Harap lakukan verifikasi nomor Whatsapp terlebih dahulu!',
                'status' => 401,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            $category = ProductCategory::where('store_identifier', $identifier)->find($id);
            if(is_null($category) || empty($category)){
                return response()->json([
                    'message' => 'Data tidak ditemukan!',
                    'status' => 404,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                $category->delete();

                return response()->json([
                    'message' => 'Data berhasil dihapus!',
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
    }

    public function filterCategory(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $category = $request->id_category;
        $product = "";
        try {
            $product = ProductStock::with('product')
                                    ->whereHas('product', function($q) use ($category) {
                                            $q->where('id_category', $category);
                                    })->where(function ($query){
                                            $query->where('stok', '!=', 0);
                                    })->where('store_identifier', $identifier)
                                    ->latest()
                                    ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if($product->count() == 0 || $product == "" || empty($product) || is_null($product)){
            return response()->json([
                'message' => 'Fetch Success',
                'data-status' => 'No product found in this category!',
                'data-product' => $product,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => "Fetch Success walaaa!",
                'data-product-stock' => $product,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function searchProduct(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $keyword = $request->product_name;
        $product = "";
        if($keyword){
            try {
                $product = ProductStock::with('product')
                                    ->whereHas('product', function($q) use($keyword) {
                                        $q->where('product_name', 'LIKE', '%'.$keyword.'%');
                                    })->where(function ($query){
                                            $query->where('stok', '!=', 0);
                                    })->where('store_identifier', $identifier)
                                    ->latest()
                                    ->get();

            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to fetch data!',
                    'error-message' => $e->getMessage(),
                    'status' => 500,
                ]);
                exit;
            }

            if($product->count() == 0 || $product == "" || empty($product) || is_null($product)){
                return response()->json([
                    'message' => 'Fetch Success',
                    'data-status' => 'No product found!',
                    'data-product-stock' => $product,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                return response()->json([
                    'message' => "Fetch Success!",
                    'data-product-stock' => $product,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
    }

    public function searchBarcode(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $barcode = $request->barcode;
        $stock = "";
        if($barcode){
            try {
                $stock = ProductStock::with('product')
                                    ->where(function ($query){
                                            $query->where('stok', '!=', 0);
                                    })
                                    ->where('barcode', $barcode)
                                    ->where('store_identifier', $identifier)
                                    ->first();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to fetch data!',
                    'error-message' => $e->getMessage(),
                    'status' => 500,
                ]);
                exit;
            }

            if(is_null($stock) || empty($stock)){
                return response()->json([
                    'message' => "Product Not Found!",
                    'data-product-stock' => $stock,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }

            return response()->json([
                'message' => "Fetch Success!",
                'data-product-stock' => $stock,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function addCart(Request $request) : JsonResponse {
        DB::beginTransaction();
        $identifier = $this->getStoreIdentifier();
        $cartCheckup = "";
        $stock = "";
        $stoktemp = "";
        $cart = "";
        try {
            $cartCheckup = ShoppingCart::where('id_tenant', auth()->user()->id)->whereNull('id_invoice')->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Data chekup fail, please check the server or query!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        try {
            $stock = ProductStock::where('store_identifier', $identifier)->findOrFail($request->id_stok);
            $stoktemp = $stock->stok;
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to find data stock. make sure the id is correct!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
            if($stoktemp == 0 || $stoktemp<$request->qty){
                return response()->json([
                    'message' => 'Stok barang tidak cukup!',
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
        if($cartCheckup->count() == 0 || $cartCheckup == "" || is_null($cartCheckup) || empty($cartCheckup)){
            try {
                if($request->tipe_barang == "Custom"){
                    $cart = ShoppingCart::create([
                        'id_tenant' => auth()->user()->id,
                        'id_product' => $request->id_stok,
                        'product_name' => $request->product_name,
                        'qty' => 1,
                        'harga' => $request->harga,
                        'tipe_barang' => $request->tipe_barang,
                        'sub_total' => $request->harga
                    ]);
                } else if($request->tipe_barang == "Pack" || $request->tipe_barang == "PCS"){
                    $cart = ShoppingCart::create([
                        'id_tenant' => auth()->user()->id,
                        'id_product' => $request->id_stok,
                        'product_name' => $request->product_name,
                        'qty' => $request->qty,
                        'harga' => $request->harga,
                        'tipe_barang' => $request->tipe_barang,
                        'sub_total' => $request->qty*$request->harga
                    ]);
                }
                if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
                    if($request->tipe_barang == "PCS"){
                        try{
                            $stock = ProductStock::where('store_identifier', $identifier)->findOrFail($request->id_stok)->lockForUpdate();
                            $stock->update([
                                'stok' => (int) $stoktemp-$cart->qty
                            ]);
                            DB::commit();
                        } catch(Exception $e){
                            DB::rollback();
                            return response()->json([
                                'message' => 'Duplicate add data, wait for the first process is done',
                                'status' => 200,
                                'app-version' => $this->getAppversion()
                            ]);
                        }
                    }
                } 
                return response()->json([
                    'message' => 'Added Success',
                    'cart' => $cart,
                    'data' => 'Add new cart',
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to insert data!',
                    'error-message' => $e->getMessage(),
                    'status' => 500,
                ]);
                exit;
            }
        } else {
            try {
                $cart = $cartCheckup->where('id_product' ,$request->id_stok)->first();
                if(empty($cart)){
                    if($request->tipe_barang == "Custom"){
                        $cart = ShoppingCart::create([
                            'id_tenant' => auth()->user()->id,
                            'id_product' => $request->id_stok,
                            'product_name' => $request->product_name,
                            'qty' => 1,
                            'harga' => $request->harga,
                            'tipe_barang' => $request->tipe_barang,
                            'sub_total' => $request->harga
                        ]);
                    } else if($request->tipe_barang == "Pack" || $request->tipe_barang == "PCS"){
                        $cart = ShoppingCart::create([
                            'id_tenant' => auth()->user()->id,
                            'id_product' => $request->id_stok,
                            'product_name' => $request->product_name,
                            'qty' => $request->qty,
                            'harga' => $request->harga,
                            'tipe_barang' => $request->tipe_barang,
                            'sub_total' => $request->qty*$request->harga
                        ]);
                    }
                } else {
                    if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
                        $tempqty = $cart->qty;
                        if($stoktemp == 0 || $stoktemp<($request->qty+$tempqty)){
                            return response()->json([
                                'message' => 'Stok barang tidak cukup!',
                                'status' => 200,
                                'app-version' => $this->getAppversion()
                            ]);
                        }
                        $cart->update([
                            'qty' => $tempqty+$request->qty,
                            'sub_total' => ($tempqty+$request->qty)*$cart->harga
                        ]);
                    } else {
                        if($request->tipe_barang == "Custom"){
                            $cart->update([
                                'qty' => 1,
                                'harga' => $request->harga,
                                'sub_total' => $request->harga
                            ]);
                        } else if($request->tipe_barang == "Pack"){
                            $cart->update([
                                'qty' => $request->qty,
                                'harga' => $request->harga,
                                'sub_total' => $request->qty*$request->harga
                            ]);
                        }
                    }
                }
                if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
                    try{
                        $stock = ProductStock::where('store_identifier', $identifier)->findOrFail($request->id_stok)->lockForUpdate();
                        $stock->update([
                            'stok' => (int) $stoktemp-$request->qty
                        ]);
                        DB::commit();
                    } catch(Exception $e){
                        DB::rollback();
                        return response()->json([
                            'message' => 'Duplicate add data, wait for the first process is done',
                            'status' => 200,
                            'app-version' => $this->getAppversion()
                        ]);
                    }
                }
                return response()->json([
                    'message' => 'Added Success',
                    'cart' => $cart,
                    'data' => 'Uodate cart',
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to find data stock. make sure the id is correct! | '.$request->id_stok.' | '.$request->product_name.' | '.$request->qty.' | '.$request->harga,
                    'id_stock' => $request->id_stok,
                    'product_name' => $request->product_name,
                    'qty' => $request->qty,
                    'harga' => $request->harga,
                    'error-message' => $e->getMessage(),
                    'status' => 500,
                ]);
                exit;
            }
        }
    }

    public function deleteCart(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        DB::beginTransaction();
        $id_cart = $request->id_cart;
        try {
            $cart = ShoppingCart::where('id_tenant', auth()->user()->id)->find($id_cart);
            if(is_null($cart) || empty($cart)){
                return response()->json([
                    'message' => 'Data not found!',
                    'status' => 404
                ]);
            }
            if($cart->tipe_barang == "PCS"){
                try{
                    $qty = $cart->qty;
                    $stock = ProductStock::where('store_identifier', $identifier)->findOrFail($cart->id_product)->lockForUpdate();
                    $stoktemp = $stock->stok;
                    $stock->update([
                        'stok' => (int) $stoktemp+$qty
                    ]);
                    DB::commit();
                } catch(Exception $e){
                    DB::rollback();
                    return response()->json([
                        'message' => 'Duplicate add data, wait for the first process is done',
                        'status' => 200,
                        'app-version' => $this->getAppversion()
                    ]);
                }
            }
            $cart->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete cart',
                'error-message' => $e->getMessage(),
                'status' => $e->getCode(),
            ]);
            exit;
        }

        return response()->json([
            'message' => 'Success Deleted',
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function listCart() : JsonResponse {
        $cartContent = "";
        try {
            $cartContent = ShoppingCart::select(['shopping_carts.id',
                                                    'shopping_carts.id_invoice',
                                                    'shopping_carts.id_product',
                                                    'shopping_carts.product_name',
                                                    'shopping_carts.qty',
                                                    'shopping_carts.harga',
                                                    'shopping_carts.sub_total',
                                                    'shopping_carts.id_tenant',
                                                    ])
                                    ->with(['stock' => function ($query){
                                        $query->select(['product_stocks.id',
                                                        'product_stocks.id_batch_product'
                                        ])
                                        ->with(['product' => function ($query){
                                            $query->select(['products.id',
                                                            'products.photo'
                                            ])->get();
                                        }])->get();
                                    }])
                                    ->where('id_tenant', auth()->user()->id)
                                    ->whereNull('id_invoice')
                                    ->latest()
                                    ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if(empty($cartContent) || $cartContent->count() == 0 || $cartContent == ""){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'Cart is empty!',
                'dataStokProduk' => $cartContent,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                'cartData' => $cartContent,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function processCart(Request $request) : JsonResponse {
        DB::connection()->enableQueryLog();
        $identifier = $this->getStoreIdentifier();
        $subtotal = 0;
        $nominalpajak = 0;
        $nominaldiskon = 0;
        $nominaldiskon = 0;
        $temptotal = 0;
        $nominalpajak = 0;
        $total = 0;
        $diskon = Discount::where('store_identifier', $identifier)
                            ->where('is_active', 1)->first();
        $disc = 0;
        $tax = Tax::where('store_identifier', $identifier)
                            ->where('is_active', 1)->first();
        $pajak = 0;

        if(!empty($tax)){
            $pajak = $tax->pajak;
        } else {
            $pajak = 0;
        }

        if(!empty($diskon)){
            $disc = $diskon->diskon;
        } else {
            $disc = 0;
        }

        try{
            $cartContent = ShoppingCart::select(['shopping_carts.id',
                                                    'shopping_carts.id_invoice',
                                                    'shopping_carts.id_product',
                                                    'shopping_carts.product_name',
                                                    'shopping_carts.qty',
                                                    'shopping_carts.harga',
                                                    'shopping_carts.sub_total',
                                                    'shopping_carts.id_tenant',
                                                    ])
                                    ->with(['stock' => function ($query){
                                        $query->select(['product_stocks.id',
                                                        'product_stocks.id_batch_product'
                                        ])
                                        ->with(['product' => function ($query){
                                            $query->select(['products.id',
                                                            'products.photo'
                                            ])->get();
                                        }])->get();
                                    }])
                                    ->where('id_tenant', auth()->user()->id)
                                    ->whereNull('id_invoice')
                                    ->latest()
                                    ->get();
            $subtotal = $cartContent->sum('sub_total');

            if($subtotal>=$disc){
                $nominaldiskon = ($disc/100)*$subtotal;
            }

            $temptotal = $subtotal-$nominaldiskon;
            $nominalpajak = ($pajak/100)*$temptotal;
            $total = $temptotal+$nominalpajak;

            $invoice = Invoice::create([
                'store_identifier' => $identifier,
                'email' => auth()->user()->email,
                'id_tenant' => auth()->user()->id,
                'id_kasir' => NULL,
                'jenis_pembayaran' => "Qris",
                'status_pembayaran' => 0,
                'sub_total' => $temptotal,
                'pajak' => $nominalpajak,
                'diskon' => $nominaldiskon,
                'nominal_bayar' => $total,
                'tanggal_transaksi' => Carbon::now(),
            ]);

            if(!is_null($invoice)) {
                if($invoice->qris_response == 211000 || $invoice->qris_response == "211000"){
                    $invoice->fieldSave($invoice, $identifier, NULL);
                    foreach($cartContent as $cart){
                        $cart->update([
                            'id_invoice' => $invoice->id
                        ]);
                    }
                } else {
                    $action = "Tenant API : Create Transaction | Error";
                    $this->createHistoryUser($action, $invoice->qris_response, 0);
                    $invoiceCreated = Invoice::find($invoice->id);
                    $invoiceCreated->delete();
                    return response()->json([
                        'message' => 'Create Transaction failed, http server error',
                        'status' => 500,
                        'app-version' => $this->getAppversion()
                    ]);
                }
            }
            $action = "Tenant API : Proses Cart Invoice Success";
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            return response()->json([
                'message' => 'Transaction has been processed successfully',
                'invoice' => $invoice,
                'cartData' => $cartContent,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } catch (Exception $e){
            $action = "Tenant API : Proses Cart Invoice Failed";
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Create Transaction failed, server error',
                'status' => 500,
                'app-version' => $this->getAppversion()
            ]);
        }

    }

    public function listCartInvoice(Request $request) : JsonResponse {
        $cartContent = "";
        $invoice = $request->id_invoice;
        try {
            $cartContent = ShoppingCart::select(['shopping_carts.id',
                                                    'shopping_carts.id_invoice',
                                                    'shopping_carts.id_product',
                                                    'shopping_carts.product_name',
                                                    'shopping_carts.qty',
                                                    'shopping_carts.harga',
                                                    'shopping_carts.sub_total',
                                                    'shopping_carts.id_tenant',
                                                    ])
                                    ->with(['stock' => function ($query){
                                        $query->select(['product_stocks.id',
                                                        'product_stocks.id_batch_product'
                                        ])
                                        ->with(['product' => function ($query){
                                            $query->select(['products.id',
                                                            'products.photo'
                                            ])->get();
                                        }])->get();
                                    }])
                                    ->where('id_tenant', auth()->user()->id)
                                    ->where('id_invoice', $invoice)
                                    ->latest()
                                    ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if(empty($cartContent) || $cartContent->count() == 0 || $cartContent == ""){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'Cart is empty!',
                'dataStokProduk' => $cartContent,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                'cartData' => $cartContent,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function getAlias() : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $alias = "";
        try {
            $alias = TenantField::where('store_identifier', $identifier)->first();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if(empty($alias) || $alias == "" || is_null($alias) || $alias->count() == 0 ){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'No data found in this collection!',
                'alias-data' => $alias,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'alias-data' => $alias,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function transactionList(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $invoice = "";
        $showdate = "";

        if($tgl_awal && $tgl_akhir) {
            try {
                $invoice = Invoice::where('store_identifier', $identifier)
                                    ->whereBetween('tanggal_transaksi', [$tgl_awal, $tgl_akhir])
                                    ->latest()
                                    ->get();// ->where('id_kasir', auth()->user()->id_kasir)
                $showdate = 'Data transaksi dari tanggal '.$tgl_awal.' s/d tanggal '.$tgl_akhir;
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to fetch data!',
                    'error-message' => $e->getMessage(),
                    'status' => 500,
                ]);
                exit;
            }
            if($invoice->count() == 0 || $invoice == ""){
                return response()->json([
                    'message' => 'Fetch Success',
                    'date-type' => 'Data transaksi tidak ditemukan',
                    'transaction-number' => $invoice->count(),
                    'transaction-data' => $invoice,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                return response()->json([
                    'message' => 'Fetch Success',
                    'date-type' => $showdate,
                    'transaction-number' => $invoice->count(),
                    'transaction-data' => $invoice,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        } else {
            try {
                $invoice = Invoice::where('store_identifier', $identifier)
                                    ->whereDate('tanggal_transaksi', Carbon::today())
                                    ->latest()
                                    ->get();// ->where('id_kasir', auth()->user()->id_kasir)
                $showdate = "Data transaksi per-hari ini.";
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to fetch data!',
                    'error-message' => $e->getMessage(),
                    'status' => 500,
                ]);
                exit;
            }
            if($invoice->count() == 0  || $invoice == ""){
                return response()->json([
                    'message' => 'Fetch Success',
                    'date-type' => 'Data transaksi tidak ditemukan',
                    'transaction-number' => $invoice->count(),
                    'transaction-data' => $invoice,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                return response()->json([
                    'message' => 'Fetch Success',
                    'date-type' => $showdate,
                    'transaction-number' => $invoice->count(),
                    'transaction-data' => $invoice,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
    }

    public function transactionListAliasSearch(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $alias1 = $request->alias1;
        $alias2 = $request->alias2;
        $alias3 = $request->alias3;
        $alias4 = $request->alias4;
        $alias5 = $request->alias5;
        $id_user = $request->id_user;
        $invoiceAliasSearch = "";
        try {
            $invoiceAliasSearch = InvoiceField::select([
                                                    'content1',
                                                    'content2',
                                                    'content3',
                                                    'content4',
                                                    'content5',
                                                ])
                                                ->distinct('content1', 'content2', 'content3', 'content4', 'content5')
                                                ->where('store_identifier', $identifier)
                                                ->when($alias1, function($query) use ($alias1){
                                                    $query->where('content1', 'LIKE', '%'.$alias1.'%');
                                                })
                                                ->when($alias2, function($query) use ($alias2){
                                                    $query->where('content2', 'LIKE', '%'.$alias2.'%');
                                                })
                                                ->when($alias3, function($query) use ($alias3){
                                                    $query->where('content3', 'LIKE', '%'.$alias3.'%');
                                                })
                                                ->when($alias4, function($query) use ($alias4){
                                                    $query->where('content4', 'LIKE', '%'.$alias4.'%');
                                                })
                                                ->when($alias5, function($query) use ($alias5){
                                                    $query->where('content5', 'LIKE', '%'.$alias5.'%');
                                                })
                                                ->groupBy([
                                                    'content1',
                                                    'content2',
                                                    'content3',
                                                    'content4',
                                                    'content5',
                                                ])
                                                ->latest()
                                                ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if($invoiceAliasSearch->count() == 0 || $invoiceAliasSearch == ""){
            return response()->json([
                'message' => 'Fetch Success',
                'date-type' => 'Data transaksi tidak ditemukan',
                'transaction-number' => $invoiceAliasSearch->count(),
                'transaction-data' => $invoiceAliasSearch,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success Alias Found',
                // 'date-type' => $showdate,
                'transaction-number' => $invoiceAliasSearch->count(),
                'transaction-data' => $invoiceAliasSearch,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function transactionListAliasSearchInvoice(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $alias1 = $request->alias1;
        $alias2 = $request->alias2;
        $alias3 = $request->alias3;
        $alias4 = $request->alias4;
        $alias5 = $request->alias5;
        $id_user = $request->id_user;
        $invoiceAliasSearch = "";
        try {
            $invoiceAliasSearch = Invoice::select([
                                            'invoices.id',
                                            'invoices.store_identifier',
                                            'invoices.id_tenant',
                                            'invoices.id_kasir',
                                            'invoices.nomor_invoice',
                                            'invoices.tanggal_transaksi',
                                            'invoices.tanggal_pelunasan',
                                            'invoices.jenis_pembayaran',
                                            'invoices.qris_data',
                                            'invoices.status_pembayaran',
                                            'invoices.sub_total',
                                            'invoices.pajak',
                                            'invoices.diskon',
                                            'invoices.kembalian',
                                            'invoices.mdr',
                                            'invoices.nominal_mdr',
                                            'invoices.nominal_terima_bersih',
                                            'invoices.settlement_status',
                                            'invoices.created_at',
                                            'invoices.updated_at',
                                        ])
                                        ->with([
                                            'invoiceField' => function($query){
                                                $query->select([
                                                    'invoice_fields.id',
                                                    'invoice_fields.id_invoice',
                                                    'invoice_fields.id_kasir',
                                                    'invoice_fields.store_identifier',
                                                    'invoice_fields.content1',
                                                    'invoice_fields.content2',
                                                    'invoice_fields.content3',
                                                    'invoice_fields.content4',
                                                    'invoice_fields.content5',
                                                ]);
                                            }
                                        ])
                                        ->whereHas(
                                            'invoiceField', function($query) use ($alias1, $alias2, $alias3, $alias4, $alias5,  $identifier){
                                                $query->where('store_identifier', $identifier)
                                                        ->when($alias1, function($query) use ($alias1){
                                                                $query->where('content1', 'LIKE', '%'.$alias1.'%');
                                                        })
                                                        ->when($alias2, function($query) use ($alias2){
                                                                $query->where('content2', 'LIKE', '%'.$alias2.'%');
                                                        })
                                                        ->when($alias3, function($query) use ($alias3){
                                                                $query->where('content3', 'LIKE', '%'.$alias3.'%');
                                                        })
                                                        ->when($alias4, function($query) use ($alias4){
                                                                $query->where('content4', 'LIKE', '%'.$alias4.'%');
                                                        })
                                                        ->when($alias5, function($query) use ($alias5){
                                                                $query->where('content5', 'LIKE', '%'.$alias5.'%');
                                                        });
                                            }
                                        )
                                        ->where('store_identifier', $identifier)
                                        ->where('id_tenant', auth()->user()->id)
                                        ->latest()
                                        ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if($invoiceAliasSearch->count() == 0 || $invoiceAliasSearch == ""){
            return response()->json([
                'message' => 'Fetch Success',
                'date-type' => 'Data transaksi tidak ditemukan',
                'transaction-number' => $invoiceAliasSearch->count(),
                'transaction-data' => $invoiceAliasSearch,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success Alias Found',
                'transaction-number' => $invoiceAliasSearch->count(),
                'transaction-data' => $invoiceAliasSearch,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function transactionPending() : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $invoice = "";
        try {
            $invoice = Invoice::where('status_pembayaran', 0)
                                ->where('store_identifier', $identifier)
                                ->where('id_tenant', auth()->user()->id)
                                ->latest()
                                ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        return response()->json([
            'message' => 'Fetch Success',
            'transaction-data' => $invoice,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function transactionCartAdd(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $cart = "";
        $tempqty = "";
        try {
            $invoice = Invoice::with('shoppingCart')
                                ->where('store_identifier', $identifier)
                                ->where('id_tenant', auth()->user()->id)
                                ->find($request->id_invoice);
            $cart = $invoice->shoppingCart->where('id_product' ,$request->id_stok)->first();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        if(empty($cart) || $cart->count() == 0 || $cart == "" || is_null($cart)){
            $stock = ProductStock::where('store_identifier', $identifier)->find($request->id_stok);
            if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
                if($stock->stok == 0 || $stock->stok<$request->qty){
                    return response()->json([
                        'message' => 'Stok barang tidak cukup!',
                        'status' => 200,
                        'app-version' => $this->getAppversion()
                    ]);
                }
            }
            if($request->tipe_barang == "Custom"){
                $cart = ShoppingCart::create([
                    'id_tenant' => auth()->user()->id,
                    'id_invoice' =>  $request->id_invoice,
                    'id_product' => $request->id_stok,
                    'product_name' => $request->product_name,
                    'tipe_barang' => $request->tipe_barang,
                    'qty' => 1,
                    'harga' => $request->harga,
                    'sub_total' => $request->harga
                ]);
            } else if($request->tipe_barang == "Pack" || $request->tipe_barang == "PCS"){
                $cart = ShoppingCart::create([
                    'id_tenant' => auth()->user()->id,
                    'id_invoice' =>  $request->id_invoice,
                    'id_product' => $request->id_stok,
                    'product_name' => $request->product_name,
                    'tipe_barang' => $request->tipe_barang,
                    'qty' => $request->qty,
                    'harga' => $request->harga,
                    'sub_total' => $request->qty*$request->harga
                ]);
            }
        } else {
            if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
                $tempqty = $cart->qty;
                $cart->update([
                    'qty' => $tempqty+$request->qty,
                    'sub_total' => ($tempqty+$request->qty)*$cart->harga
                ]);
            } else {
                if($request->tipe_barang == "Custom"){
                    $cart->update([
                        'qty' => 1,
                        'harga' => $request->harga,
                        'sub_total' => $request->harga
                    ]);
                } else if($request->tipe_barang == "Pack"){
                    $cart->update([
                        'qty' => $request->qty,
                        'sub_total' => $request->qty*$cart->harga
                    ]);
                }
            }
        }

        if($request->tipe_barang == "PCS"){
            try{
                $stock = ProductStock::where('store_identifier', $identifier)->find($request->id_stok)->lockForUpdate();
                $stoktemp = $stock->stok;
                $stock->update([
                    'stok' => (int) $stoktemp-$request->qty
                ]);
                DB::commit();
            } catch(Exception $e){
                DB::rollback();
                return response()->json([
                    'message' => 'Duplicate add data, wait for the first process is done',
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }

        return response()->json([
            'message' => 'Added Success',
            'cart' => $cart,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }


    public function transactionCartDelete(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        try {
            $invoice = Invoice::with('shoppingCart')
                                ->where('store_identifier', $identifier)
                                ->where('id_tenant', auth()->user()->id)
                                ->find($request->id_invoice);
            $cart = $invoice->shoppingCart->find($request->id_cart);
            if($cart->tipe_barang == "PCS"){
                try{
                    $qty = $cart->qty;
                    $stock = ProductStock::where('store_identifier', $identifier)->find($cart->id_product)->lockForUpdate();
                    $stoktemp = $stock->stok;
                    $stock->update([
                        'stok' => (int) $stoktemp+$qty
                    ]);
                    DB::commit();
                } catch(Exception $e){
                    DB::rollback();
                    return response()->json([
                        'message' => 'Duplicate add data, wait for the first process is done',
                        'status' => 200,
                        'app-version' => $this->getAppversion()
                    ]);
                }
            }
            $cart->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        return response()->json([
            'message' => 'Success Deleted',
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function transactionPendingUpdate(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        DB::connection()->enableQueryLog();
        try{
            $invoice = Invoice::with('shoppingCart')
                                ->where('store_identifier', $identifier)
                                ->where('id_tenant', auth()->user()->id)
                                ->find($request->id_invoice);

            $diskon = Discount::where('store_identifier', $identifier)
                                ->where('is_active', 1)->first();
            $disc = 0;
            $tax = Tax::where('store_identifier', $identifier)
                        ->where('is_active', 1)->first();
            $pajak = 0;

            if(!empty($tax)){
                $pajak = $tax->pajak;
            } else {
                $pajak = 0;
            }

            if(!empty($diskon)){
                $disc = $diskon->diskon;
            } else {
                $disc = 0;
            }

            $subtotal = 0;
            $nominalpajak = 0;
            $nominaldiskon = 0;
            foreach($invoice->shoppingCart as $cart){
                $subtotal+= $cart->sub_total;
            }
            $nominaldiskon = 0;
            if($subtotal>=$disc){
                $nominaldiskon = ($disc/100)*$subtotal;
            }
            $temptotal = $subtotal-$nominaldiskon;
            $nominalpajak = ($pajak/100)*$temptotal;
            $total = $temptotal+$nominalpajak;

            $storeDetail = StoreDetail::with(['jenisMDR'])->where('store_identifier', $invoice->store_identifier)->first();
            $qrisAccount = TenantQrisAccount::where('store_identifier', $invoice->store_identifier)->first();

            $data = "";
            $postResponse = "";
            $client = new Client();
            $url = 'https://erp.pt-best.com/api/dynamic_qris_wt_new';
            if(is_null($qrisAccount) || empty($qrisAccount)){
                $postResponse = $client->request('POST',  $url, [
                    'form_params' => [
                        'amount' => $total,
                        'transactionNo' => $invoice->nomor_invoice,
                        'pos_id' => "IN01",
                        'secret_key' => "Vpos71237577"
                    ]
                ]);
            } else {
                $qrisLogin = $qrisAccount->qris_login_user;
                $qrisPassword = $qrisAccount->qris_password;
                $qrisMerchantID = $qrisAccount->qris_merchant_id;
                $qrisStoreID = $qrisAccount->qris_store_id;
                $postResponse = $client->request('POST',  $url, [
                    'form_params' => [
                        'login' => $qrisLogin,
                        'password' => $qrisPassword,
                        'merchantID' => $qrisMerchantID,
                        'storeID' => $qrisStoreID,
                        'amount' => $total,
                        'transactionNo' => $invoice->nomor_invoice,
                        'pos_id' => "IN01",
                        'secret_key' => "Vpos71237577"
                    ]
                ]);
            }
            $qris_data = "";
            $data = json_decode($postResponse->getBody());
            if(!is_null($data) || !empty($data)){
                if($data->data->responseCode == 211000 || $data->data->responseCode == "211000"){
                    $qris_data = $data->data->data->qrisData;
                    $invoice->update([
                        'qris_response' => $data->data->responseCode
                    ]);
                } else {
                    $invoice->update([
                        'qris_response' => $data->data->responseCode
                    ]);
                    $action = "Tenant : Transaction Pending Process Error | ".$invoice->nomor_invoice;
                    $this->createHistoryUser($action, $data->data->responseCode, 0);
                    $notification = array(
                        'message' => 'Gagal memproses transaksi, harap hubungi Admin!',
                        'alert-type' => 'warning',
                    );
                    return redirect()->back()->with($notification);
                }
            }
            $invoice->update([
                'qris_data' => $qris_data,
                'sub_total' => $temptotal,
                'pajak' => $nominalpajak,
                'diskon' => $nominaldiskon,
                'nominal_bayar' => $total
            ]);

            if($storeDetail->status_umi == 1){
                if($invoice->nominal_bayar <= 100000){
                    $mdr = $storeDetail->jenisMDR->presentase_minimal_mdr;
                    $mdrCount = $mdr/100;
                    $nominal_mdr = $invoice->nominal_baya*$mdrCount;
                    $invoice->update([
                        'mdr' => $mdr,
                        'nominal_mdr' => $nominal_mdr,
                        'nominal_terima_bersih' => $invoice->nominal_bayar-$nominal_mdr
                    ]);
                } else {
                    $mdr = $storeDetail->jenisMDR->presentase_maksimal_mdr;
                    $mdrCount = $mdr/100;
                    $nominal_mdr = $invoice->nominal_bayar*$mdrCount;
                    $invoice->update([
                        'mdr' => $mdr,
                        'nominal_mdr' => $nominal_mdr,
                        'nominal_terima_bersih' => $invoice->nominal_bayar-$nominal_mdr
                    ]);
                }
            } else {
                $mdr = $storeDetail->jenisMDR->presentase_maksimal_mdr;
                $mdrCount = $mdr/100;
                $nominal_mdr = $invoice->nominal_bayar*$mdrCount;
                $invoice->update([
                    'mdr' => $mdr,
                    'nominal_mdr' => $nominal_mdr,
                    'nominal_terima_bersih' => $invoice->nominal_bayar-$nominal_mdr
                ]);
            }
            $action = "Tenant API : Update Transaction Invoice Success";
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            return response()->json([
                'message' => 'Transaction Updated',
                'invoice' => $invoice,
                'cartData' => $invoice->shoppingCart,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } catch(Exception $e) {
            $action = "Tenant API : Update Transaction Invoice Failed";
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Transaction Update Failed, Server Error',
                'status' => 500,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function transactionPendingDelete(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        DB::connection()->enableQueryLog();
        try {
            $invoice = Invoice::where('status_pembayaran', 0)
                                ->where('id_tenant', auth()->user()->id)
                                ->where('store_identifier', $identifier)
                                ->find($request->id_invoice);
            $cartContent = ShoppingCart::with('stock')->where('id_invoice', $request->id_invoice)->get();
            foreach($cartContent as $cart){
                if($cart->tipe_barang == "PCS"){
                    $productStock = ProductStock::find($cart->id_product);
                    $stok = $cart->qty + $productStock->stok;
                    $productStock->update([
                        'stok' => $stok
                    ]);
                }
                $cart->delete();
            }
            $invoice->delete();
        } catch (Exception $e) {
            $action = "Tenant API : Transaction Pending Delete Failed";
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Failed to delete data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        $action = "Tenant API : Transaction Pending Delete Success";
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        return response()->json([
            'message' => 'Transaction deleted',
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function transactionChangePayment(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        DB::connection()->enableQueryLog();
        $invoice = "";
        try {
            $invoice = Invoice::where('status_pembayaran', 0)
                                ->where('id_tenant', auth()->user()->id)
                                ->where('store_identifier', $identifier)
                                ->find($request->id_invoice);
            $invoice->update([
                'tanggal_pelunasan' => Carbon::now(),
                'jenis_pembayaran' => "Tunai",
                'qris_data' => NULL,
                'mdr' => 0,
                'nominal_mdr' => 0,
                'nominal_terima_bersih' => 0,
                'status_pembayaran' => 1
            ]);
            $tunaiWallet = TunaiWallet::where('id_tenant', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
            $totalSaldo = $tunaiWallet->saldo+$invoice->nominal_bayar;

            $tunaiWallet->update([
                'saldo' => $totalSaldo
            ]);
        } catch (Exception $e) {
            $action = "Tenant API : Change Payment Failed";
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Failed to update data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        $action = "Tenant API : Change Payment Success";
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        return response()->json([
            'message' => 'Payment Success',
            'transaction-data' => $invoice,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function transactionDetail($id) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $invoice = "";
        $storeDetail = "";
        $alias = "";
        try {
            $invoice = Invoice::with(['shoppingCart' => function($query){
                                $query->with(['stock' => function($query){
                                    $query->with(['product'])->get();
                                }
                                ])->get();
                            }
                        ])->findOrFail($id);
            $storeDetail = StoreDetail::where('store_identifier', $identifier)->firstOrFail();
            $alias = InvoiceField::where('id_invoice', $id)->first();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        return response()->json([
            'message' => 'Fetch Success',
            'transaction-data' => $invoice,
            'data-alias' => $alias,
            'store-detail' => $storeDetail,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function withdrawList(){
        $withdrawData = Withdrawal::select([
                                    'withdrawals.id',
                                    'withdrawals.invoice_pemarikan',
                                    'withdrawals.id_user',
                                    'withdrawals.email',
                                    'withdrawals.tanggal_penarikan',
                                    'withdrawals.nominal',
                                    'withdrawals.biaya_admin',
                                    'withdrawals.status',
                                    'withdrawals.created_at',
                                ])
                                ->with([
                                    'rekening' => function($query){
                                        $query->select([
                                            'rekening_withdraws.id',
                                            'rekening_withdraws.id_penarikan',
                                            'rekening_withdraws.atas_nama',
                                            'rekening_withdraws.nama_bank',
                                            'rekening_withdraws.no_rekening',
                                        ]);
                                    }
                                ])
                                ->where('id_user', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->latest()
                                ->get();

        return response()->json([
            'message' => 'Fetch Success',
            'withdraw-data' => $withdrawData,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }
}
