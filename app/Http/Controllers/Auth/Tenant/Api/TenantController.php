<?php

namespace App\Http\Controllers\Auth\Tenant\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Marketing;
use App\Models\Tenant;
use App\Models\Kasir;
use App\Models\StoreDetail;
use App\Models\Rekening;
use App\Models\ProductStock;
use App\Models\TenantField;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Invoice;
use App\Models\InvoiceField;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Exception;

class TenantController extends Controller {
    public function getStoreIdentifier(){
        $store = StoreDetail::select(['store_identifier'])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $identifier = $store->store_identifier;
        return $identifier;
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'storeData' => $store,
                'status' => 200
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
            return response()->json([
                'message' => 'Data has ben updated!',
                'storeData' => $store,
                'status' => 200
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
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $alias = "";

        try {
            $alias = TenantField::where('store_identifier', $store->store_identifier)->first();
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'alias-data' => $alias,
                'status' => 200
            ]);
        }
    }

    public function aliasUpdate(Request $request) : JsonResponse {
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();

        $alias = "";
        try {
            $alias = TenantField::where('store_identifier', $store->store_identifier)->first();
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
                'status' => 200
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
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        try {
            $kasir = Kasir::select(['id','name', 'email', 'is_active'])
                            ->where('id_store', $store->store_identifier)
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'kasir-list' => $kasir,
                'status' => 200
            ]);
        }
    }

    public function kasirDetail(Request $request) : JsonResponse {
        $id = $request->id_kasir;
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $kasir = "";
        try {
            $kasir = Kasir::with('detail')
                            ->where('id_store', $store->store_identifier)
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
            'status' => 200
        ]);
    }

    public function kasirRegister(Request $request) : JsonResponse {
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'phone' => ['required', 'string', 'numeric', 'digits_between:1,20', 'unique:'.Admin::class, 'unique:'.Marketing::class, 'unique:'.Tenant::class,  'unique:'.Kasir::class],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        try {
            $kasir = Kasir::create([
                'id_store' => $store->store_identifier,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
            if(!is_null($kasir)) {
                $kasir->detailKasirStore($kasir);
            }
            return response()->json([
                'message' => 'Data has been added!',
                'kasir-data' => $kasir,
                'status' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to add data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
    }

    public function productList() : JsonResponse{
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $product = "";
        try {
            $product = Product::where('store_identifier', $store->store_identifier)
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'data-product' => $product,
                'status' => 200
            ]);
        }
    }

    public function productCategory() : JsonResponse {
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $productCategory = "";
        try {
            $productCategory = ProductCategory::select(['id','name'])->where('store_identifier', $store->store_identifier)->latest()->get();
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                'productCategory' => $productCategory,
                'status' => 200
            ]);
        }
    }

    public function filterCategory(Request $request) : JsonResponse {
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $category = $request->id_category;
        $product = "";
        try {
            $product = Product::where('id_category', $category)
                                ->where('store_identifier', $store->store_identifier)
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => "Fetch Success walaaa!",
                'data-product' => $product,
                'status' => 200
            ]);
        }
    }

    public function searchProduct(Request $request) : JsonResponse {
        $store = StoreDetail::where('id_tenant', auth()->user()->id)
                                ->where('email', auth()->user()->email)
                                ->first();
        $keyword = $request->product_name;
        $product = "";
        if($keyword){
            try {
                $product = Product::where('store_identifier', $store->store_identifier)
                                    ->where('product_name', 'LIKE', '%'.$keyword.'%')
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
                    'dataStokProduk' => $product,
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => "Fetch Success!",
                    'dataStokProduk' => $product,
                    'status' => 200
                ]);
            }
        }
    }

    public function rekList() : JsonResponse {
        $rek = "";
        try {
            $rek = Rekening::where('id_user', auth()->user()->id)
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
        if($rek->count() == 0 || $rek == "" || empty($rek) || is_null($rek)){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'No data found in this collection!',
                'alias-data' => $rek,
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'alias-data' => $rek,
                'status' => 200
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
                ]);
            } else {
                return response()->json([
                    'message' => 'Fetch Success',
                    'date-type' => $showdate,
                    'transaction-number' => $invoice->count(),
                    'transaction-data' => $invoice,
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
                ]);
            } else {
                return response()->json([
                    'message' => 'Fetch Success',
                    'date-type' => $showdate,
                    'transaction-number' => $invoice->count(),
                    'transaction-data' => $invoice,
                ]);
            }
        }
    }

    public function transactionListAlias(Request $request) : JsonResponse {
        $identifier = $this->getStoreIdentifier();
        $alias1 = $request->alias1;
        $alias2 = $request->alias2;
        $alias3 = $request->alias3;
        $alias4 = $request->alias4;
        $alias5 = $request->alias5;
        $id_user = $request->id_user;
        $invoiceAliasSearch = "";
        try {
           $invoiceAliasSearch = InvoiceField::with(['invoice'])
                                            ->where('store_identifier', $identifier)
                                            ->where('content1', $alias1)
                                            ->orWhere('content2', $alias2)
                                            ->orWhere('content3', $alias3)
                                            ->orWhere('content4', $alias4)
                                            ->orWhere('content5', $alias5)
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
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                // 'date-type' => $showdate,
                'transaction-number' => $invoiceAliasSearch->count(),
                'transaction-data' => $invoiceAliasSearch,
            ]);
        }
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
            'store-detail' => $storeDetail
        ]);
    }
}
