<?php

namespace App\Http\Controllers\Auth\Kasir\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
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
use Rawilk\Printing\Receipts\ReceiptPrinter;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Exception;

class KasirController extends Controller {
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success!',
                'dataStokProduk' => $stock,
                'status' => 200
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
            'status' => 200
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => "Fetch Success!",
                'dataStokProduk' => $stock,
                'status' => 200
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
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => "Fetch Success!",
                    'dataStokProduk' => $stock,
                    'status' => 200
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
                    'status' => 200
                ]);
            }

            return response()->json([
                'message' => "Fetch Success!",
                'dataStokProduk' => $stock,
                'status' => 200
            ]);
        }
    }

    public function addCart(Request $request) : JsonResponse {
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

        if($stoktemp == 0 || $stoktemp<$request->qty){
            return response()->json([
                'message' => 'Stok barang tidak cukup!',
                'status' => 200,
            ]);
        } else {
            if($cartCheckup->count() == 0 || $cartCheckup == "" || is_null($cartCheckup) || empty($cartCheckup)){
                try {
                    $cart = ShoppingCart::create([
                        'id_kasir' => auth()->user()->id,
                        'id_product' => $request->id_stok,
                        'product_name' => $request->product_name,
                        'qty' => $request->qty,
                        'harga' => $request->harga,
                        'sub_total' => $request->qty*$request->harga
                    ]);
                    $stock->update([
                        'stok' => (int) $stoktemp-$cart->qty
                    ]);
                    return response()->json([
                        'message' => 'Added Success',
                        'cart' => $cart,
                        'data' => 'Add new cart',
                        'status' => 200
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
                        $cart = ShoppingCart::create([
                            'id_kasir' => auth()->user()->id,
                            'id_product' => $request->id_stok,
                            'product_name' => $request->product_name,
                            'qty' => $request->qty,
                            'harga' => $request->harga,
                            'sub_total' => $request->qty*$request->harga
                        ]);
                    } else {
                        $tempqty = $cart->qty;
                        if($stoktemp == 0 || $stoktemp<($request->qty+$tempqty)){
                            return response()->json([
                                'message' => 'Stok barang tidak cukup!',
                                'status' => 200,
                            ]);
                        }
                        $cart->update([
                            'qty' => $tempqty+$request->qty,
                            'sub_total' => ($tempqty+$request->qty)*$cart->harga
                        ]);
                    }
                } catch (Exception $e) {
                    return response()->json([
                        'message' => 'Failed to find data stock. make sure the id is correct!',
                        'error-message' => $e->getMessage(),
                        'status' => 500,
                    ]);
                    exit;
                }
                $stock->update([
                    'stok' => (int) $stoktemp-$request->qty
                ]);
                return response()->json([
                    'message' => 'Added Success',
                    'cart' => $cart,
                    'data' => 'Uodate cart',
                    'status' => 200
                ]);
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
            $qty = $cart->qty;
            $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->findOrFail($cart->id_product);
            $stoktemp = $stock->stok;
            $stock->update([
                'stok' => (int) $stoktemp+$qty
            ]);
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
            'status' => 200
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                'cartData' => $cartContent,
                'status' => 200
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                'cartData' => $cartContent,
                'status' => 200
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

    //Try Catch Not Yet Applied
    public function processCart(Request $request) : JsonResponse {
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

        foreach($cartContent as $cart){
            $cart->update([
                'id_invoice' => $invoice->id
            ]);
        }

        if(!is_null($invoice)) {
            $invoice->fieldSave($invoice);
        }

        return response()->json([
            'message' => 'Transaction has been processed successfully',
            'invoice' => $invoice,
            'cartData' => $cartContent,
            'status' => 200
        ]);

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
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Fetch Success',
                    'date-type' => $showdate,
                    'transaction-number' => $invoice->count(),
                    'transaction-data' => $invoice,
                    'status' => 200
                ]);
            }
        }
    }

    public function transactionListAlias(Request $request) : JsonResponse {
        $alias1 = $request->alias1;
        $alias2 = $request->alias2;
        $alias3 = $request->alias3;
        $alias4 = $request->alias4;
        $alias5 = $request->alias5;
        $id_user = $request->id_user;
        $invoiceAliasSearch = "";
        try {
           $invoiceAliasSearch = InvoiceField::with(['invoice'])
                                            ->where('store_identifier', auth()->user()->id_store)
                                            ->where('id_kasir', $id_user)
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
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Fetch Success',
                // 'date-type' => $showdate,
                'transaction-number' => $invoiceAliasSearch->count(),
                'transaction-data' => $invoiceAliasSearch,
                'status' => 200
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
            'status' => 200
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
            $cart = ShoppingCart::create([
                'id_kasir' => auth()->user()->id,
                'id_invoice' =>  $request->id_invoice,
                'id_product' => $request->id_stok,
                'product_name' => $request->product_name,
                'qty' => $request->qty,
                'harga' => $request->harga,
                'sub_total' => $request->qty*$request->harga
            ]);
        } else {
            $tempqty = $cart->qty;
            $cart->update([
                'qty' => $tempqty+$request->qty,
                'sub_total' => ($tempqty+$request->qty)*$cart->harga
            ]);
        }

        $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->find($request->id_stok);
        $stoktemp = $stock->stok;
        $stock->update([
            'stok' => (int) $stoktemp-$request->qty
        ]);

        return response()->json([
            'message' => 'Added Success',
            'cart' => $cart,
            'status' => 200
        ]);
    }

    //Try Catch Not Yet Applied
    public function transactionPendingUpdate(Request $request) : JsonResponse {
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
            $responseCode = $postResponse->getStatusCode();
            $data = json_decode($postResponse->getBody());
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

            $responseCode = $postResponse->getStatusCode();
            $data = json_decode($postResponse->getBody());
        }

        $invoice->update([
            'qris_data' => $data->data->data->qrisData,
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

        return response()->json([
            'message' => 'Transaction Updated',
            'invoice' => $invoice,
            'cartData' => $invoice->shoppingCart,
            'status' => 200
        ]);
    }
    //Try Catch Not Yet Applied

    public function transactionCartDelete(Request $request) : JsonResponse {
        try {
            $invoice = Invoice::with('shoppingCart')
                                ->where('store_identifier', auth()->user()->id_store)
                                ->where('id_kasir', auth()->user()->id)
                                ->find($request->id_invoice);
            $cart = $invoice->shoppingCart->find($request->id_cart);
            $qty = $cart->qty;
            $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->find($cart->id_product);
            $stoktemp = $stock->stok;
            $stock->update([
                'stok' => (int) $stoktemp+$qty
            ]);
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
            'status' => 200
        ]);
    }

    public function transactionPendingDelete(Request $request) : JsonResponse {
        try {
            $invoice = Invoice::where('status_pembayaran', 0)->find($request->id_invoice);
            $cartContent = ShoppingCart::with('stock')->where('id_invoice', $request->id_invoice)->get();
            foreach($cartContent as $cart){
                $productStock = ProductStock::find($cart->id_product);
                $stok = $cart->qty + $productStock->stok;
                $productStock->update([
                    'stok' => $stok
                ]);
                $cart->delete();
            }
            $invoice->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        return response()->json([
            'message' => 'Transaction deleted',
            'status' => 200
        ]);
    }

    public function transactionChangePayment(Request $request) : JsonResponse {
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
            return response()->json([
                'message' => 'Failed to update data!',
                'error-message' => $e->getMessage(),
                'status' => 500,
            ]);
            exit;
        }
        return response()->json([
            'message' => 'Payment Success',
            'transaction-data' => $invoice,
            'status' => 200
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
            'status' => 200
        ]);
    }
}
