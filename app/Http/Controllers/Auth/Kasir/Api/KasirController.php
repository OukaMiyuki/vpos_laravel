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

class KasirController extends Controller {
    public function productList(){
        $stock = ProductStock::with('product')
                        ->where(function ($query) {
                                $query->where('stok', '!=', 0);
                        })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        // $customField = TenantField::where('id_tenant', auth()->user()->id_tenant)->first();
        // $stockProduk = $stock;
        return response()->json([
            'message' => 'Fetch Success',
            'dataStokProduk' => $stock,
            // 'customField' => $customField
        ]);
    }

    public function productDetail(Request $request){
        $stock = ProductStock::with(['product' => function ($query) {
                            $query->with('category')->get();
                        }])
                        ->where(function ($query){
                                $query->where('stok', '!=', 0);
                        })->where('id_tenant', auth()->user()->id_tenant)
                        ->find($request->id);

        return response()->json([
            'message' => 'Fetch Success',
            'data-detail-stock' => $stock,
        ]);
    }

    public function productCategory() {
        $productCategory = ProductCategory::where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        return response()->json([
            'message' => 'Fetch Success',
            'productCategory' => $productCategory,
        ]);
    }

    public function filterCategory(Request $request){
        $category = $request->id_category;
        // $stock = ProductStock::with(['product' => function ($query) use ($category) {
        //                     $query->where('id_category', $category);
        //                 }])
        //                 ->where(function ($query){
        //                         $query->where('stok', '!=', 0);
        //                 })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        $stock = ProductStock::with('product')
                     ->whereHas('product', function($q) use($category) {
                            $q->where('id_category', $category);
                    })->where(function ($query){
                            $query->where('stok', '!=', 0);
                    })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        $message = "";
        if(!count($stock)){
            $message = "Products not found";
        } else {
            $message = "Fetch Success";
        }
        return response()->json([
            'message' => $message,
            'dataStokProduk' => $stock
        ]);

    }

    public function searchProduct(Request $request) {
        $keyword = $request->product_name;
        if($keyword){
            $stock = ProductStock::with('product')
                        ->whereHas('product', function($q) use($keyword) {
                            $q->where('product_name', 'LIKE', '%'.$keyword.'%');
                        })->where(function ($query){
                                $query->where('stok', '!=', 0);
                        })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();

            $message = "";

            if(!count($stock)){
                $message = "Products not found";
            } else {
                $message = "Fetch Success";
            }
            return response()->json([
                'message' => $message,
                'dataStokProduk' => $stock
            ]);
        }
    }

    public function searchBarcode(Request $request){
        $barcode = $request->barcode;
        if($barcode){
            $stock = ProductStock::with('product')
                        ->where(function ($query){
                                $query->where('stok', '!=', 0);
                        })
                        ->where('barcode', $barcode)
                        ->where('id_tenant', auth()->user()->id_tenant)->latest()->get();

            $message = "";

            if(!count($stock)){
                $message = "Products not found";
            } else {
                $message = "Fetch Success";
            }
            return response()->json([
                'message' => $message,
                'dataStokProduk' => $stock
            ]);
        }
    }

    public function addCart(Request $request){
        $cartCheckup = ShoppingCart::where('id_kasir', auth()->user()->id)
                                ->whereNull('id_invoice')
                                ->get();

        if(empty($cartCheckup)){
            $cart = ShoppingCart::create([
                'id_kasir' => auth()->user()->id,
                'id_product' => $request->id_stok,
                'product_name' => $request->product_name,
                'qty' => $request->qty,
                'harga' => $request->harga,
                'sub_total' => $request->qty*$request->harga
            ]);

            $stock = ProductStock::where('id_tenant', auth()->user()->id_tenant)->find($request->id_stok);
            $stoktemp = $stock->stok;
            $stock->update([
                'stok' => (int) $stoktemp-$cart->qty
            ]);

            return response()->json([
                'message' => 'Added Success',
                'cart' => $cart
            ]);
        } else {            
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
    }

    public function deleteCart(Request $request){
        $id_cart = $request->id_cart;
        $cart = ShoppingCart::where('id_kasir', auth()->user()->id)->find($id_cart);
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

    public function listCart(){
        $cartContent = ShoppingCart::with('product')
                                ->where('id_kasir', auth()->user()->id)
                                ->whereNull('id_invoice')
                                ->latest()
                                ->get();
        return response()->json([
            'message' => 'Fetch Success',
            'cartData' => $cartContent,
        ]);
    }

    public function processCart(Request $request){
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

        // return response()->json([
        //     'message' => 'Fetch Success',
        //     'diskon' => $disc,
        //     'pajak' => $pajak,
        // ]);

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

    public function transactionList(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id_tenant)
                            ->where('id_kasir', auth()->user()->id)
                            ->latest()
                            ->get();
        return response()->json([
            'message' => 'Fetch Success',
            'transaction-data' => $invoice,
        ]);
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
        $invoice = Invoice::with('shoppingCart')->find($id);
        return response()->json([
            'message' => 'Fetch Success',
            'transaction-data' => $invoice,
        ]);
    }
}
