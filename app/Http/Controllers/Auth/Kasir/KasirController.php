<?php

namespace App\Http\Controllers\Auth\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ShoppingCart;
use App\Models\Invoice;

class KasirController extends Controller {
    public function kasirPos(){
        // session()->forget('cart');
        // $stock = Product::with('productStock')->where('id_tenant', auth()->user()->id_tenant)
        //                     ->where(function ($query) {
        //                         $query->where('stok', '!=', 0);
        //                     })->latest()->get();
        // dd($stock);
        $stock = ProductStock::with('product')
                        ->where(function ($query) {
                                $query->where('stok', '!=', 0);
                        })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        return view('kasir.kasir_pos', compact('stock'));
    }

    public function addCart(Request $request){
        Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'weight' => 20,
            'options' => ['size' => 'large']
        ]);

        $notification = array(
            'message' => 'Sukses ditambahkan!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function allItem(){
        $product_item_cart = Cart::content();
        // Cart::instance('cart-9')->restore(auth()->user()->id);
        return view('kasir.kasir_pos_all_item_cart', compact('product_item_cart'));
    }

    public function updateCart(Request $request){
        $rowId = $request->id;
        $qty = $request->qty;
        $update = Cart::update($rowId, $qty);

        $notification = array(
            'message' => 'Sukses diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function removeCart($id){
        $remove = Cart::remove($id);

        $notification = array(
            'message' => 'Sukses dihapus!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function cartTransactionSave(Request $request){
        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        $string = str_shuffle($pin);
        $invoice = Invoice::create([
            'id_tenant' => auth()->user()->id_tenant,
            'id_kasir' => auth()->user()->id,
            'nomor_invoice' => $string,
            'jenis_pembayaran' => $request->pembayaran,
            'tanggal_transaksi' => Carbon::now()
        ]);
        if(!is_null($invoice)) {
            $invoice->storeCart($invoice);
        }
        $notification = array(
            'message' => 'Sukses disimpan!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function cartTransactionClear(Request $request){
        session()->forget('cart');

        $notification = array(
            'message' => 'Transaction cleared!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function transactionPending(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id_tenant)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('status_pembayaran', 0)
                            ->latest()
                            ->get();
        return view('kasir.kasir_invoice_pending', compact('invoice'));
    }

    public function transactionPendingRestore($id){
        session()->forget('cart');
        $invoice = Invoice::with('shoppingCart')
                            ->where('id_tenant', auth()->user()->id_tenant)
                            ->where('id_kasir', auth()->user()->id)
                            ->find($id);
        
        foreach($invoice->shoppingCart as $cart){
            Cart::add([
                'id' => $cart->id,
                'name' => $cart->product_name,
                'qty' => $cart->qty,
                'price' => $cart->harga,
                'weight' => 20,
                'options' => ['size' => 'large']
            ]);
        }
        // $stock = ProductStock::with('product')
        //                 ->where(function ($query) {
        //                         $query->where('stok', '!=', 0);
        //                 })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        $notification = array(
            'message' => 'Transaction restored!',
            'alert-type' => 'success',
        );
        return view('kasir.kasir_transaction_restore')->with($notification);
    }

    // public function transactionPendingUpdate(Request $request){
    //     $shoppingcart = ShoppingCart::where('id_invoice', $request->id)->delete();
    //     $cartContent = Cart::content();
    //     foreach($cartContent as $cart){
    //         ShoppingCart::create([
    //             'id_invoice' => $request->id,
    //             'id_product' => $cart->id,
    //             'product_name' => $cart->name,
    //             'qty' =>$cart->qty,
    //             'harga' => $cart->price,
    //             'sub_total' => $cart->price*$cart->qty
    //         ]);
    //     }
    //     session()->forget('cart');

    //     $notification = array(
    //         'message' => 'Transaction updated!',
    //         'alert-type' => 'success',
    //     );
    //     return redirect()->route('kasir.transaction.pending')->with($notification);
    // }
}
