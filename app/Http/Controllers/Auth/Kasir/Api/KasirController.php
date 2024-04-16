<?php

namespace App\Http\Controllers\Auth\Kasir\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ShoppingCart;
use App\Models\Invoice;
use App\Models\Discount;
use App\Models\Tax;
use App\Models\TenantField;
use App\Models\ProductCategory;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Exception;

class KasirController extends Controller {
    public function productList() : JsonResponse{
        $stock = "";
        try {
            $stock = ProductStock::with('product')
                                ->where(function ($query) {
                                        $query->where('stok', '!=', 0);
                                })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
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
                    })->where('id_tenant', auth()->user()->id_tenant)
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
            $productCategory = ProductCategory::select(['id','name'])->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
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
                        })->where('id_tenant', auth()->user()->id_tenant)
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
                                    })->where('id_tenant', auth()->user()->id_tenant)
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
                                    ->where('id_tenant', auth()->user()->id_tenant)
                                    ->firstOrFail();
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'Failed to fetch data!',
                    'error-message' => $e->getMessage(),
                    'status' => 500,
                ]);
                exit;
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
            $stock = ProductStock::where('id_tenant', auth()->user()->id_tenant)->where('stok', '!=', 0)->findOrFail($request->id_stok);
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
            if($cartCheckup->count() == 0 || $cartCheckup == ""){
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
                        'data' => 'Add new cart'
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
                    'data' => 'Uodate cart'
                ]);
            }
        }
    }

    public function deleteCart(Request $request) : JsonResponse {
        $id_cart = $request->id_cart;
        try {
            $cart = ShoppingCart::where('id_kasir', auth()->user()->id)->findOrFail($id_cart);
            $qty = $cart->qty;
            $stock = ProductStock::where('id_tenant', auth()->user()->id_tenant)->findOrFail($cart->id_product);
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
        ]);
    }

    public function listCart() : JsonResponse {
        try {
            $cartContent = ShoppingCart::with('product')
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

        if($cartContent->count() == 0 || $cartContent == ""){
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

    public function processCart(Request $request) : JsonResponse {
        $diskon = Discount::where('id_tenant', auth()->user()->id_tenant)
                 ->where('is_active', 1)->first();
        $disc = 0;
        $tax = Tax::where('id_tenant', auth()->user()->id_tenant)
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

        $cartContent = ShoppingCart::with('product')
                            ->where('id_kasir', auth()->user()->id)
                            ->whereNull('id_invoice')
                            ->latest()
                            ->get();

        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];
        $string = str_shuffle($pin);

        $invoice = Invoice::create([
            'id_tenant' => auth()->user()->id_tenant,
            'id_kasir' => auth()->user()->id,
            'nomor_invoice' => $string,
            'tanggal_transaksi' => Carbon::now(),
            'jenis_pembayaran' => "Qris",
        ]);

        $subtotal = 0;
        $nominalpajak = 0;
        $nominaldiskon = 0;
        foreach($cartContent as $cart){
            $cart->update([
                'id_invoice' => $invoice->id
            ]);
            $subtotal+= (int) $cart->sub_total;
        }
        $nominaldiskon = ($disc/100)*$subtotal;
        $temptotal = $subtotal-$nominaldiskon;
        $nominalpajak = ($pajak/100)*$temptotal;
        $total = $temptotal+$nominalpajak;

        $client = new Client();
        $url = 'https://erp.pt-best.com/api/dynamic_qris_wt_new';
        $postResponse = $client->request('POST',  'https://erp.pt-best.com/api/dynamic_qris_wt_new', [
            'form_params' => [
                'amount' => $total,
                'transactionNo' => $string,
                'pos_id' => "IN01",
                'secret_key' => "Vpos71237577"
            ]
        ]);
        $responseCode = $postResponse->getStatusCode();
        $data = json_decode($postResponse->getBody());

        $invoice->update([
            'qris_data' => $data->data->data->qrisData,
            'sub_total' => $temptotal,
            'pajak' => $nominalpajak,
            'diskon' => $nominaldiskon,
            'nominal_bayar' => $total
        ]);

        return response()->json([
            'message' => 'Fetch Success',
            'invoice' => $invoice,
            'cartData' => $cartContent,
        ]);

    }

    public function transactionList(Request $request){
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $invoice = "";
        $showdate = "";
        if($tgl_awal && $tgl_akhir) {
            $invoice = Invoice::where('id_tenant', auth()->user()->id_tenant)
                        ->where('id_kasir', auth()->user()->id)
                        ->whereBetween('tanggal_transaksi', [$tgl_awal, $tgl_akhir])
                        ->latest()
                        ->get();
            $showdate = 'Data transaksi dari tanggal '.$tgl_awal.' s/d tanggal '.$tgl_akhir;

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
            $invoice = Invoice::where('id_tenant', auth()->user()->id_tenant)
                        ->where('id_kasir', auth()->user()->id)
                        ->whereDate('tanggal_transaksi', Carbon::today())
                        ->latest()
                        ->get();
            $showdate = "Data transaksi per-hari ini.";

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

    public function transactionPending(){
        $invoice = Invoice::where('status_pembayaran', 0)
                            ->where('id_tenant', auth()->user()->id_tenant)
                            ->where('id_kasir', auth()->user()->id)
                            ->latest()
                            ->get();
        return response()->json([
            'message' => 'Fetch Success',
            'transaction-data' => $invoice,
        ]);
    }

    public function transactionCartAdd(Request $request){
        $invoice = Invoice::with('shoppingCart')
                        ->where('id_tenant', auth()->user()->id_tenant)
                        ->where('id_kasir', auth()->user()->id)
                        ->find($request->id_invoice);

        // $cartCheckup = ShoppingCart::where('id_kasir', auth()->user()->id)
        //                         ->where('id_invoice', $request->id_invoice)
        //                         ->get();

        $cart = $invoice->shoppingCart->where('id_product' ,$request->id_stok)->first();

        if(empty($cart)){
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

        $stock = ProductStock::where('id_tenant', auth()->user()->id_tenant)->find($request->id_stok);
        $stoktemp = $stock->stok;
        $stock->update([
            'stok' => (int) $stoktemp-$request->qty
        ]);

        return response()->json([
            'message' => 'Added Success',
            'cart' => $cart
        ]);
    }

    public function transactionPendingUpdate(Request $request){
        $invoice = Invoice::with('shoppingCart')
                        ->where('id_tenant', auth()->user()->id_tenant)
                        ->where('id_kasir', auth()->user()->id)
                        ->find($request->id_invoice);

        $diskon = Discount::where('id_tenant', auth()->user()->id_tenant)
                            ->where('is_active', 1)->first();
        $disc = 0;
        $tax = Tax::where('id_tenant', auth()->user()->id_tenant)
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
            $subtotal+= (int) $cart->sub_total;
        }
        $nominaldiskon = ($disc/100)*$subtotal;
        $temptotal = $subtotal-$nominaldiskon;
        $nominalpajak = ($pajak/100)*$temptotal;
        $total = $temptotal+$nominalpajak;

        $client = new Client();
        $url = 'https://erp.pt-best.com/api/dynamic_qris_wt_new';
        $postResponse = $client->request('POST',  'https://erp.pt-best.com/api/dynamic_qris_wt_new', [
            'form_params' => [
                'amount' => $total,
                'transactionNo' => $invoice->nomor_invoice,
                'pos_id' => "IN01",
                'secret_key' => "Vpos71237577"
            ]
        ]);
        $responseCode = $postResponse->getStatusCode();
        $data = json_decode($postResponse->getBody());

        $invoice->update([
            'qris_data' => $data->data->data->qrisData,
            'sub_total' => $temptotal,
            'pajak' => $nominalpajak,
            'diskon' => $nominaldiskon,
            'nominal_bayar' => $total
        ]);

        return response()->json([
            'message' => 'Fetch Success',
            'invoice' => $invoice,
            'cartData' => $invoice->shoppingCart,
        ]);
    }

    public function transactionCartDelete(Request $request){
        $invoice = Invoice::with('shoppingCart')
                        ->where('id_tenant', auth()->user()->id_tenant)
                        ->where('id_kasir', auth()->user()->id)
                        ->find($request->id_invoice);
        // $cart = $invoice->shoppingCart->where('id_product' ,$request->id_stok)->first();
        $cart = $invoice->shoppingCart->find($request->id_cart);
        $qty = $cart->qty;
        $stock = ProductStock::where('id_tenant', auth()->user()->id_tenant)->find($cart->id_product);
        $stoktemp = $stock->stok;
        $stock->update([
            'stok' => (int) $stoktemp+$qty
        ]);
        $cart->delete();
        return response()->json([
            'message' => 'Success Deleted',
        ]);
    }

    public function transactionPendingDelete(Request $request){
        $invoice = Invoice::where('status_pembayaran', 0)->find($request->id_invoice);
        $cartContent = ShoppingCart::with('product')->where('id_invoice', $request->id_invoice)->get();
        foreach($cartContent as $cart){
            $tempqty = $cart->qty;
            $productStock = ProductStock::find($cart->id_product);
            $stok = $cart->qty + $productStock->stok;
            $productStock->update([
                'stok' => $stok
            ]);
            $cart->delete();
        }
        $invoice->delete();
        return response()->json([
            'message' => 'Transaction deleted',
        ]);
    }

    public function transactionChangePayment(Request $request){
        $invoice = Invoice::where('status_pembayaran', 0)->find($request->id_invoice);
        $invoice->update([
            'tanggal_pelunasan' => Carbon::now(),
            'jenis_pembayaran' => "Tunai",
            'qris_data' => NULL,
            'status_pembayaran' => 1
        ]);
        return response()->json([
            'message' => 'Payment Success',
            'transaction-data' => $invoice,
        ]);
    }

    public function transactionDetail($id){
        $invoice = Invoice::with(['shoppingCart' => function($query){
                        $query->with('product')->get();
                    }
                ])->find($id);
        return response()->json([
            'message' => 'Fetch Success',
            'transaction-data' => $invoice,
        ]);
    }
}
