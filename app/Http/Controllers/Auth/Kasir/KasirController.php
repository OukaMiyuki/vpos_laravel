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
use App\Models\Discount;
use App\Models\Tax;
use App\Models\TenantField;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use GuzzleHttp\Client;

class KasirController extends Controller {
    public function index(){
        return view('kasir.dashboard');
    }

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
        $customField = TenantField::where('id_tenant', auth()->user()->id_tenant)->first();
        return view('kasir.kasir_pos', compact('stock', 'customField'));
    }

    public function addCart(Request $request){
        $diskon = Discount::where('id_tenant', auth()->user()->id_tenant)
                    ->where('is_active', 1)->first();

        $tax = Tax::where('id_tenant', auth()->user()->id_tenant)
                    ->where('is_active', 1)->first();

        if(!empty($tax)){
            Cart::setGlobalTax($tax->pajak);
        } else {
            Cart::setGlobalTax(0);
        }
        // Cart::setGlobalTax(21);
        Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'weight' => 20,
            'options' => ['size' => 'large']
        ]);
        $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
        if(!empty($diskon)){
            if($subtotal >= $diskon->min_harga){
                Cart::setGlobalDiscount($diskon->diskon);
            } else {
                Cart::setGlobalDiscount(0);
            }
        }

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
        $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
        if(!empty($diskon)){
            if($subtotal >= $diskon->min_harga){
                Cart::setGlobalDiscount($diskon->diskon);
            } else {
                Cart::setGlobalDiscount(0);
            }
        }
        $update = Cart::update($rowId, $qty);

        $notification = array(
            'message' => 'Sukses diupdate!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function removeCart($id){
        $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
        if(!empty($diskon)){
            if($subtotal >= $diskon->min_harga){
                Cart::setGlobalDiscount($diskon->diskon);
            } else {
                Cart::setGlobalDiscount(0);
            }
        }
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
            session()->forget('cart');
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
                            ->where('jenis_pembayaran', NULL)
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
        $diskon = Discount::where('id_tenant', auth()->user()->id_tenant)
                            ->where('is_active', 1)->first();

        $tax = Tax::where('id_tenant', auth()->user()->id_tenant)
                    ->where('is_active', 1)->first();
        
        $customField = TenantField::where('id_tenant', auth()->user()->id_tenant)->first();

        if(!empty($tax)){
            Cart::setGlobalTax($tax->pajak);
        } else {
            Cart::setGlobalTax(0);
        }
        // Cart::setGlobalTax(21);

        foreach($invoice->shoppingCart as $cart){
            Cart::add([
                'id' => $cart->id_product,
                'name' => $cart->product_name,
                'qty' => $cart->qty,
                'price' => $cart->harga,
                'weight' => 20,
                'options' => ['size' => 'large']
            ]);

            $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
            if(!empty($diskon)){
                if($subtotal >= $diskon->min_harga){
                    Cart::setGlobalDiscount($diskon->diskon);
                } else {
                    Cart::setGlobalDiscount(0);
                }
            }
        }
        // $stock = ProductStock::with('product')
        //                 ->where(function ($query) {
        //                         $query->where('stok', '!=', 0);
        //                 })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        $notification = array(
            'message' => 'Transaction restored!',
            'alert-type' => 'success',
        );
        return view('kasir.kasir_transaction_restore', compact('customField', 'invoice'))->with($notification);
    }

    public function transactionPendingDelete($id) {
        $invoice = Invoice::where('id_tenant', auth()->user()->id_tenant)
                ->where('id_kasir', auth()->user()->id)
                ->where('jenis_pembayaran', NULL)
                ->find($id);
        session()->forget('cart');
        if(!is_null($invoice)) {
            $invoice->deleteCart($invoice);
        }
        $invoice->delete();
        $notification = array(
            'message' => 'Transaction Deleted Successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function cartTransactionProcess(Request $request){
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];
        $string = str_shuffle($pin);
        $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
        $total = (int) substr(str_replace([',', '.'], '', Cart::total()), 0, -2);
        $tax = (int) substr(str_replace([',', '.'], '', Cart::tax()), 0, -2);
        $diskon = (int) substr(str_replace([',', '.'], '', Cart::discount()), 0, -2);
        $kembalian = (int) str_replace(['.', ' ', 'Rp'], '', $request->kembalianText);
        if($request->jenisPembayaran == "Tunai"){
            $invoice = Invoice::create([
                'id_tenant' => auth()->user()->id_tenant,
                'id_kasir' => auth()->user()->id,
                'nomor_invoice' => $string,
                'jenis_pembayaran' => $request->jenisPembayaran,
                'nominal_bayar' => $request->nominalText,
                'kembalian' => $kembalian,
                'status_pembayaran' => 1,
                'sub_total' => $subtotal,
                'pajak' => $tax,
                'diskon' => $diskon,
                'tanggal_pelunasan' => Carbon::now(),
                'tanggal_transaksi' => Carbon::now()
            ]);
    
            if(!is_null($invoice)) {
                $invoice->storeCart($invoice);
                $invoice->fieldSave($invoice);
            }
    
            session()->forget('cart');
    
            $notification = array(
                'message' => 'Transaksi berhasil diproses!',
                'alert-type' => 'success',
            );
            // return view('kasir.kasir_invoice_preview', compact('invoice'))->with($notification);
            return redirect()->route('kasir.pos.transaction.invoice', array('id' => $invoice->id))->with($notification);
        } else if($request->jenisPembayaran == "Qris"){
            //Create Client object to deal with
            $client = new Client();
            // Define the request parameters
            $url = 'https://erp.pt-best.com/api/dynamic_qris_wt_new';
            // $headers = [
            //     'Content-Type' => 'application/json',
            // ];

            // $data = [
            //     'amount' => 1000,
            //     'transactionNo' => "DEM20240315091544999",
            //     'pos_id' => "IN01",
            // ];
    
            // // POST request using the created object
            // $postResponse = $client->post($url, [
            //     'headers' => $headers,
            //     'json' => $data,
            // ]);

            // Get the response code
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
            // $contents = $postResponse->getBody()->getContents();
            // $contents = $postResponse->getBody()->getContents();
            // $result = json_decode($contents, true);
            // $data = $result['qrisData'];
            // dd($your_final_result );
            // $response = (string) $postResponse->getBody();
            // $response =json_decode($response);
            // $key_value = $response->data->qrisData;
            // dd($data->data->data->qrisData);
            // return response()->json([
            //     'response_code' => $responseCode,
            //     'data' => $data
            // ]);

            $invoice = Invoice::create([
                'id_tenant' => auth()->user()->id_tenant,
                'id_kasir' => auth()->user()->id,
                'nomor_invoice' => $string,
                'jenis_pembayaran' => $request->jenisPembayaran,
                'qris_data' => $data->data->data->qrisData,
                'status_pembayaran' => 0,
                'sub_total' => $subtotal,
                'pajak' => $tax,
                'diskon' => $diskon,
                'tanggal_pelunasan' => Carbon::now(),
                'tanggal_transaksi' => Carbon::now()
            ]);
    
            if(!is_null($invoice)) {
                $invoice->storeCart($invoice);
                $invoice->fieldSave($invoice);
            }
    
            session()->forget('cart');
    
            $notification = array(
                'message' => 'Transaksi berhasil diproses!',
                'alert-type' => 'success',
            );
            // return view('kasir.kasir_invoice_preview', compact('invoice'))->with($notification);
            return redirect()->route('kasir.pos.transaction.invoice', array('id' => $invoice->id))->with($notification);
        }
    }

    public function cartTransactionPendingProcess(Request $request){
        if($request->jenisPembayaran == "Tunai"){
            $invoice = Invoice::find($request->id_invoice);
            $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
            $tax = (int) substr(str_replace([',', '.'], '', Cart::tax()), 0, -2);
            $diskon = (int) substr(str_replace([',', '.'], '', Cart::discount()), 0, -2);
            $kembalian = (int) str_replace(['.', ' ', 'Rp'], '', $request->kembalianText);
            $invoice->update([
                'jenis_pembayaran' => $request->jenisPembayaran,
                'tanggal_pelunasan' => Carbon::now(),
                'status_pembayaran' => 1,
                'sub_total' => $subtotal,
                'pajak' => $tax,
                'diskon' => $diskon,
                'nominal_bayar' => $request->nominalText,
                'kembalian' => $kembalian,
            ]);
            if(!is_null($invoice)) {
                $invoice->fieldSave($invoice);
            }
            session()->forget('cart');
            $notification = array(
                'message' => 'Transaksi berhasil diproses!',
                'alert-type' => 'success',
            );
            return redirect()->route('kasir.pos.transaction.invoice', array('id' => $invoice->id))->with($notification);
        } else if($request->jenisPembayaran == "Tunai"){
            
        }
    }

    public function cartTransactionInvoice($id){
        $invoice = Invoice::with('shoppingCart', 'invoiceField')->find($id);
        return view('kasir.kasir_invoice_preview', compact('invoice'));
    }

    public function cartTransactionInvoiceReceipt($id){
        $invoice = Invoice::with('shoppingCart', 'invoiceField')->find($id);
        return view('kasir.printer', compact('invoice'));
    }

    public function transactionFinish(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id_tenant)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('status_pembayaran', 1)
                            ->latest()
                            ->get();
        return view('kasir.kasir_invoice_finish', compact('invoice'));
    }
}
