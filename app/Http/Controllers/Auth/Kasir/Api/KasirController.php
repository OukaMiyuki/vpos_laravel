<?php

namespace App\Http\Controllers\Auth\Kasir\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\StoreDetail;
use App\Models\TunaiWallet;
use App\Models\ProductStock;
use App\Models\ShoppingCart;
use App\Models\Invoice;
use App\Models\InvoiceField;
use App\Models\Discount;
use App\Models\Tax;
use App\Models\TenantField;
use App\Models\ProductCategory;
use App\Models\TenantQrisAccount;
use App\Models\AppVersion;
use App\Models\History;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Exception;

class KasirController extends Controller {

    private function getAppversion(){
        $appVersion = AppVersion::find(1);
        return $appVersion->versi;
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

    public function productList() : JsonResponse{
        $stock = "";
        try {
            $stock = ProductStock::with(['product' => function ($query) {
                                        $query->where('harga_jual', '!=',0);
                                }])
                                ->where(function ($query) {
                                        $query->where('stok', '!=', 0)
                                              ->where('harga_beli', '!=', 0);
                                })
                                ->where('store_identifier', auth()->user()->id_store)
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

        if($stock->count() == 0 || $stock == ""){
            return response()->json([
                'message' => 'Fetch Success!',
                'data-status' => 'No data found in this collection!',
                'dataStokProduk' => $stock,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'dataStokProduk' => $stock,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function productDetail(Request $request) : JsonResponse {
        $stock = "";
        $id = $request->id;
        try {
            $stock = ProductStock::with(['product' => function ($query) {
                        $query->with('category')->get();
                    }])
                    ->where(function ($query){
                            $query->where('stok', '!=', 0);
                    })->where('store_identifier', auth()->user()->id_store)
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

    public function productCategory() : JsonResponse {
        $productCategory = "";
        try {
            $productCategory = ProductCategory::select(['id','name'])->where('store_identifier', auth()->user()->id_store)->latest()->get();
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

    public function filterCategory(Request $request) : JsonResponse {
        $category = $request->id_category;
        $stock = "";
        try {
            $stock = ProductStock::with('product')
                        ->whereHas('product', function($q) use ($category) {
                                $q->where('id_category', $category);
                        })->where(function ($query){
                                $query->where('stok', '!=', 0);
                        })->where('store_identifier', auth()->user()->id_store)
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

        if($stock->count() == 0 || $stock == ""){
            return response()->json([
                'message' => 'Fetch Success',
                'data-status' => 'No product found in this category!',
                'dataStokProduk' => $stock,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } else {
            return response()->json([
                'message' => "Fetch Success!",
                'dataStokProduk' => $stock,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function searchProduct(Request $request) : JsonResponse {
        $keyword = $request->product_name;
        $stock = "";
        if($keyword){
            try {
                $stock = ProductStock::with('product')
                                    ->whereHas('product', function($q) use($keyword) {
                                        $q->where('product_name', 'LIKE', '%'.$keyword.'%');
                                    })->where(function ($query){
                                            $query->where('stok', '!=', 0);
                                    })->where('store_identifier', auth()->user()->id_store)
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

            if($stock->count() == 0 || $stock == ""){
                return response()->json([
                    'message' => 'Fetch Success',
                    'data-status' => 'No product found!',
                    'dataStokProduk' => $stock,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            } else {
                return response()->json([
                    'message' => "Fetch Success!",
                    'dataStokProduk' => $stock,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }
        }
    }

    public function searchBarcode(Request $request) : JsonResponse {
        $barcode = $request->barcode;
        $stock = "";
        if($barcode){
            try {
                $stock = ProductStock::with('product')
                                    ->where(function ($query){
                                            $query->where('stok', '!=', 0);
                                    })
                                    ->where('barcode', $barcode)
                                    ->where('store_identifier', auth()->user()->id_store)
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
                    'dataStokProduk' => $stock,
                    'status' => 200,
                    'app-version' => $this->getAppversion()
                ]);
            }

            return response()->json([
                'message' => "Fetch Success!",
                'dataStokProduk' => $stock,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function addCart(Request $request) : JsonResponse {
        DB::beginTransaction();
        $cartCheckup = "";
        $stock = "";
        $stoktemp = "";
        $cart = "";
        try {
            $cartCheckup = ShoppingCart::where('id_kasir', auth()->user()->id)
                                    ->whereNull('id_invoice')
                                    ->get();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Data chekup fail, please check the server or query!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }

        try {
            $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->where('stok', '!=', 0)->findOrFail($request->id_stok);
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
                        'id_kasir' => auth()->user()->id,
                        'id_product' => $request->id_stok,
                        'product_name' => $request->product_name,
                        'qty' => 1,
                        'harga' => $request->harga,
                        'tipe_barang' => $request->tipe_barang,
                        'sub_total' => $request->harga
                    ]);
                } else if($request->tipe_barang == "Pack" || $request->tipe_barang == "PCS"){
                    $cart = ShoppingCart::create([
                        'id_kasir' => auth()->user()->id,
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
                            $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->where('stok', '!=', 0)->findOrFail($request->id_stok)->lockForUpdate();
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
                            'id_kasir' => auth()->user()->id,
                            'id_product' => $request->id_stok,
                            'product_name' => $request->product_name,
                            'qty' => 1,
                            'harga' => $request->harga,
                            'tipe_barang' => $request->tipe_barang,
                            'sub_total' => $request->harga
                        ]);
                    } else if($request->tipe_barang == "Pack" || $request->tipe_barang == "PCS"){
                        $cart = ShoppingCart::create([
                            'id_kasir' => auth()->user()->id,
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
                        $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->where('stok', '!=', 0)->findOrFail($request->id_stok)->lockForUpdate();
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
                    'message' => 'Failed to find data stock. make sure the id is correct!',
                    'error-message' => $e->getMessage(),
                    'status' => 500,
                ]);
                exit;
            }
        }
    }

    public function deleteCart(Request $request) : JsonResponse {
        $id_cart = $request->id_cart;
        try {
            $cart = ShoppingCart::where('id_kasir', auth()->user()->id)->find($id_cart);
            if(is_null($cart) || empty($cart)){
                return response()->json([
                    'message' => 'Data not found!',
                    'status' => 404
                ]);
            }
            if($cart->tipe_barang == "PCS"){
                try{
                    $qty = $cart->qty;
                    $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->findOrFail($cart->id_product)->lockForUpdate();
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
                                                    'shopping_carts.id_kasir',
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
                                    ->where('id_kasir', auth()->user()->id)
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
                                                    'shopping_carts.id_kasir',
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
                                    ->where('id_kasir', auth()->user()->id)
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
        $alias = "";
        try {
            $alias = TenantField::where('store_identifier', auth()->user()->id_store)->first();
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

    //Try Catch Not Yet Applied
    public function processCart(Request $request) : JsonResponse {
        DB::connection()->enableQueryLog();
        $subtotal = 0;
        $nominalpajak = 0;
        $nominaldiskon = 0;
        $nominaldiskon = 0;
        $temptotal = 0;
        $nominalpajak = 0;
        $total = 0;
        $diskon = Discount::where('store_identifier', auth()->user()->id_store)
                            ->where('is_active', 1)->first();
        $disc = 0;
        $tax = Tax::where('store_identifier', auth()->user()->id_store)
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
                                                    'shopping_carts.id_kasir',
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
                                    ->where('id_kasir', auth()->user()->id)
                                    ->whereNull('id_invoice')
                                    ->latest()
                                    ->get();
            $subtotal = $cartContent->sum('sub_total');

            // foreach($cartContent as $cart){
            //     $subtotal+= (int) $cart->sub_total;
            // }

            if($subtotal>=$disc){
                $nominaldiskon = ($disc/100)*$subtotal;
            }

            $temptotal = $subtotal-$nominaldiskon;
            $nominalpajak = ($pajak/100)*$temptotal;
            $total = $temptotal+$nominalpajak;

            $invoice = Invoice::create([
                'store_identifier' => auth()->user()->id_store,
                'email' => auth()->user()->store->email,
                'id_tenant' => auth()->user()->store->id_tenant,
                'id_kasir' => auth()->user()->id,
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
                    $invoice->fieldSave($invoice, auth()->user()->id_store, auth()->user()->id);
                    foreach($cartContent as $cart){
                        $cart->update([
                            'id_invoice' => $invoice->id
                        ]);
                    } 
                } else {
                    $action = "Kasir API : Proses Cart Invoice Failed";
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
            $action = "Kasir API : Proses Cart Invoice Success";
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            return response()->json([
                'message' => 'Transaction has been processed successfully',
                'invoice' => $invoice,
                'cartData' => $cartContent,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } catch(Exception $e) {
            $action = "Kasir API : Proses Cart Invoice Failed";
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Create Transaction failed, server error',
                'status' => 500,
                'app-version' => $this->getAppversion()
            ]);
        }

    }
    //Try Catch Not Yet Applied

    public function transactionList(Request $request) : JsonResponse {
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $invoice = "";
        $showdate = "";

        if($tgl_awal && $tgl_akhir) {
            try {
                $invoice = Invoice::where('store_identifier', auth()->user()->id_store)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->whereBetween('tanggal_transaksi', [$tgl_awal, $tgl_akhir])
                                    ->latest()
                                    ->get();
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
                $invoice = Invoice::where('store_identifier', auth()->user()->id_store)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->whereDate('tanggal_transaksi', Carbon::today())
                                    ->latest()
                                    ->get();
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
        $alias1 = $request->alias1;
        $alias2 = $request->alias2;
        $alias3 = $request->alias3;
        $alias4 = $request->alias4;
        $alias5 = $request->alias5;
        // $id_user = $request->id_user;
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
                                                    ->where('store_identifier', auth()->user()->id_store)
                                                    ->where('id_kasir', auth()->user()->id)
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
                'message' => 'Fetch Success',
                // 'date-type' => $showdate,
                'transaction-number' => $invoiceAliasSearch->count(),
                'transaction-data' => $invoiceAliasSearch,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function transactionListAliasSearchInvoice(Request $request) : JsonResponse {
        $identifier = auth()->user()->id_store;
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
                                        ->where('store_identifier', auth()->user()->id_store)
                                        ->where('id_kasir', auth()->user()->id)
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
        $invoice = "";
        try {
            $invoice = Invoice::where('status_pembayaran', 0)
                                ->where('store_identifier', auth()->user()->id_store)
                                ->where('id_kasir', auth()->user()->id)
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
        $cart = "";
        $tempqty = "";
        try {
            $invoice = Invoice::with('shoppingCart')
                                ->where('store_identifier', auth()->user()->id_store)
                                ->where('id_kasir', auth()->user()->id)
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
            $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->find($request->id_stok);
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
                    'id_kasir' => auth()->user()->id,
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
                    'id_kasir' => auth()->user()->id,
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
                $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->find($request->id_stok)->lockForUpdate();
                $stoktemp = $stock->stok;
                $stock->update([
                    'stok' => (int) $stoktemp-$request->qty
                ]);
                DB::commit();
            } catch(EXception $e){
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

    public function transactionPendingUpdate(Request $request) : JsonResponse {
        DB::connection()->enableQueryLog();
        try{
            $invoice = Invoice::with('shoppingCart')
                                ->where('store_identifier', auth()->user()->id_store)
                                ->where('id_kasir', auth()->user()->id)
                                ->find($request->id_invoice);

            $diskon = Discount::where('store_identifier', auth()->user()->id_store)
                                ->where('is_active', 1)->first();
            $disc = 0;
            $tax = Tax::where('store_identifier', auth()->user()->id_store)
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

            $storeDetail = StoreDetail::select(['status_umi'])->where('store_identifier', $invoice->store_identifier)->first();
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
                    $invoice->update([
                        'mdr' => 0,
                        'nominal_mdr' => 0,
                        'nominal_terima_bersih' => $invoice->nominal_bayar
                    ]);
                } else {
                    $nominal_mdr = $total*0.007;
                    $invoice->update([
                        'nominal_mdr' => $nominal_mdr,
                        'nominal_terima_bersih' => $total-$nominal_mdr
                    ]);
                }
            } else {
                $nominal_mdr = $total*0.007;
                $invoice->update([
                    'nominal_mdr' => $nominal_mdr,
                    'nominal_terima_bersih' => $total-$nominal_mdr
                ]);
            }
            $action = "Kasir API : Update Transaction Invoice Success";
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            return response()->json([
                'message' => 'Transaction Updated',
                'invoice' => $invoice,
                'cartData' => $invoice->shoppingCart,
                'status' => 200,
                'app-version' => $this->getAppversion()
            ]);
        } catch(Exception $e){
            $action = "Kasir API : Update Transaction Invoice Failed";
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Transaction Update Failed, Server Error',
                'status' => 500,
                'app-version' => $this->getAppversion()
            ]);
        }
    }

    public function transactionCartDelete(Request $request) : JsonResponse {
        try {
            $invoice = Invoice::with('shoppingCart')
                                ->where('store_identifier', auth()->user()->id_store)
                                ->where('id_kasir', auth()->user()->id)
                                ->find($request->id_invoice);
            $cart = $invoice->shoppingCart->find($request->id_cart);
            if($cart->tipe_barang == "PCS"){
                try{
                    $qty = $cart->qty;
                    $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->find($cart->id_product)->lockForUpdate();
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

    public function transactionPendingDelete(Request $request) : JsonResponse {
        DB::connection()->enableQueryLog();
        try {
            $invoice = Invoice::where('status_pembayaran', 0)->find($request->id_invoice);
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
            $action = "Kasir API : Transaction Pending Delete Failed";
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Failed to delete data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        $action = "Kasir API : Transaction Pending Delete Success";
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        return response()->json([
            'message' => 'Transaction deleted',
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function transactionChangePayment(Request $request) : JsonResponse {
        DB::connection()->enableQueryLog();
        $invoice = "";
        try {
            $invoice = Invoice::where('status_pembayaran', 0)->find($request->id_invoice);
            $invoice->update([
                'tanggal_pelunasan' => Carbon::now(),
                'jenis_pembayaran' => "Tunai",
                'qris_data' => NULL,
                'status_pembayaran' => 1
            ]);
            $tunaiWallet = TunaiWallet::where('id_tenant', auth()->user()->store->id_tenant)
                                        ->where('email', auth()->user()->store->email)
                                        ->first();
            $totalSaldo = $tunaiWallet->saldo+$invoice->nominal_bayar;
            $tunaiWallet->update([
                'saldo' => $totalSaldo
            ]);
        } catch (Exception $e) {
            $action = "Kasir API : Change Payment Failed";
            $this->createHistoryUser($action, $e, 0);
            return response()->json([
                'message' => 'Failed to update data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        $action = "Kasir API : Change Payment Success";
        $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
        return response()->json([
            'message' => 'Payment Success',
            'transaction-data' => $invoice,
            'status' => 200,
            'app-version' => $this->getAppversion()
        ]);
    }

    public function transactionDetail($id) : JsonResponse {
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
            $storeDetail = StoreDetail::where('store_identifier', auth()->user()->id_store)->firstOrFail();
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
}
