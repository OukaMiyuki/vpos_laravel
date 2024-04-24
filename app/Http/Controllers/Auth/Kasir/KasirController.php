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
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

class KasirController extends Controller {
    public function index(){
        $product = Product::where('id_tenant', auth()->user()->id_tenant)->count();
        $stock = ProductStock::where('id_tenant', auth()->user()->id_tenant)->count();
        $totalInvoiceHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                        ->where('id_tenant', auth()->user()->id_tenant)
                                        ->where('id_kasir', auth()->user()->id)
                                        ->count();
        $totalInvoice = Invoice::where('id_tenant', auth()->user()->id_tenant)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->count();
        $pemasukanHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                    ->where('id_tenant', auth()->user()->id_tenant)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->where('status_pembayaran', 1)
                                    ->sum(\DB::raw('sub_total + pajak'));
        $totalPemasukan = Invoice::where('id_tenant', auth()->user()->id_tenant)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->where('status_pembayaran', 1)
                                    ->sum(\DB::raw('sub_total + pajak'));
        return view('kasir.dashboard', compact(['product', 'stock', 'totalInvoiceHariIni', 'totalInvoice', 'pemasukanHariIni', 'totalPemasukan']));
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
        $invoice = Invoice::create([
            'id_tenant' => auth()->user()->id_tenant,
            'id_kasir' => auth()->user()->id,
            'tanggal_transaksi' => Carbon::now()
        ]);
        if(!is_null($invoice)) {
            $invoice->storeCart($invoice);
            $invoice->customerIdentifier($invoice);
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

    public function cartTransactionProcess(Request $request){
        $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
        $total = (int) substr(str_replace([',', '.'], '', Cart::total()), 0, -2);
        $tax = (int) substr(str_replace([',', '.'], '', Cart::tax()), 0, -2);
        $diskon = (int) substr(str_replace([',', '.'], '', Cart::discount()), 0, -2);
        $kembalian = (int) str_replace(['.', ' ', 'Rp'], '', $request->kembalianText);
        if($request->jenisPembayaran == "Tunai"){
            $invoice = Invoice::create([
                'id_tenant' => auth()->user()->id_tenant,
                'id_kasir' => auth()->user()->id,
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
                $invoice->updateTunaiWallet($total);
            }

            session()->forget('cart');

            $notification = array(
                'message' => 'Transaksi berhasil diproses!',
                'alert-type' => 'success',
            );
            return redirect()->route('kasir.pos.transaction.invoice', array('id' => $invoice->id))->with($notification);
        } else if($request->jenisPembayaran == "Qris"){
            $invoice = Invoice::create([
                'id_tenant' => auth()->user()->id_tenant,
                'id_kasir' => auth()->user()->id,
                'jenis_pembayaran' => $request->jenisPembayaran,
                'status_pembayaran' => 0,
                'sub_total' => $subtotal,
                'pajak' => $tax,
                'diskon' => $diskon,
                'nominal_bayar' => $total,
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

    public function transactionPending(){
        $invoice = Invoice::with('customer')
                            ->where('id_tenant', auth()->user()->id_tenant)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('jenis_pembayaran', NULL)
                            ->where('status_pembayaran', 0)
                            ->latest()
                            ->get();
        return view('kasir.kasir_invoice_pending', compact('invoice'));
    }

    public function transactionPendingPayment(){
        $invoice = Invoice::where('id_tenant', auth()->user()->id_tenant)
                        ->where('id_kasir', auth()->user()->id)
                        ->where('jenis_pembayaran', "Qris")
                        ->where('status_pembayaran', 0)
                        ->latest()
                        ->get();
        return view('kasir.kasir_invoice_pending_payment', compact('invoice'));
    }

    public function transactionPendingRestore($id){
        //session()->forget('cart');
        $invoice = Invoice::with('shoppingCart', 'customer')
                            ->where('id_tenant', auth()->user()->id_tenant)
                            ->where('id_kasir', auth()->user()->id)
                            ->whereNull('jenis_pembayaran')
                            ->where('status_pembayaran', 0)
                            ->find($id);
        $stock = ProductStock::with('product')
                            ->where(function ($query) {
                                    $query->where('stok', '!=', 0);
                            })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        $customField = TenantField::where('id_tenant', auth()->user()->id_tenant)->first();
        $shoppingCart = $invoice->shoppingCart;
        $notification = array(
            'message' => 'Transaction restored!',
            'alert-type' => 'success',
        );
        return view('kasir.kasir_transaction_restore', compact('customField', 'invoice', 'stock', 'shoppingCart'))->with($notification);
    }

    public function transactionPendingAddCart(Request $request){
        $shoppingCart = ShoppingCart::where('id_product', $request->id_product)
                                    ->where('id_invoice', $request->id_invoice)
                                    ->first();

        $stock = ProductStock::find($request->id_product);

        if($stock->stok < $request->qty){
            $notification = array(
                'message' => 'Stok tidak mencukupi!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        if(empty($shoppingCart) || $shoppingCart->count() == 0 || $shoppingCart == ""){
            ShoppingCart::create([
                'id_kasir' => auth()->user()->id,
                'id_invoice' => $request->id_invoice,
                'id_product' => $request->id_product,
                'product_name' => $request->name,
                'qty' => $request->qty,
                'harga' => $request->price,
                'sub_total' => $request->qty*$request->price
            ]);
        } else {
            $tempQty = $shoppingCart->qty;
            $totalQty = $tempQty+$request->qty;
            $shoppingCart->update([
                'qty' => $totalQty,
                'sub_total' => $totalQty*$request->price
            ]);
        }

        $updateStok = (int) $stock->stok - (int) $request->qty;
        $stock->update([
            'stok' => $updateStok
        ]);

        $notification = array(
            'message' => 'Successfully Added!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function transactionPendingUpdateCart(Request $request){
        $shoppingCart = ShoppingCart::where('id_product', $request->id_product)
                                    ->where('id_invoice', $request->id_invoice)
                                    ->first();
        $stock = ProductStock::find($request->id_product);
        if($shoppingCart->qty<$request->qty){
            $penambahan=(int) $request->qty-$shoppingCart->qty;
            $updateqty=$penambahan+$shoppingCart->qty;
            $harga=$shoppingCart->harga;
            if($stock->stok<$penambahan){
                $notification = array(
                    'message' => 'Stok tidak mencukupi untuk jumlah tersebut!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            } else {
                $shoppingCart->update([
                    'qty' => $updateqty,
                    'sub_total' => $updateqty*$harga
                ]);
                $updateStok = (int) $stock->stok - (int) $penambahan;
                $stock->update([
                    'stok' => $updateStok
                ]);
                //dd($updateqty);
                $notification = array(
                    'message' => 'Successfully Updated!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            }
        } else if($shoppingCart->qty>$request->qty){
            $pengurangan=(int) $shoppingCart->qty-$request->qty;
            //$updateqty=$pengurangan-$request->qty;
            $harga=$shoppingCart->harga;

            $shoppingCart->update([
                'qty' => $request->qty,
                'sub_total' => $request->qty*$harga
            ]);
            $updateStok = (int) $stock->stok + (int) $pengurangan;
            $stock->update([
                'stok' => $updateStok
            ]);
            $notification = array(
                'message' => 'Successfully Updated! dua',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Successfully Added!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function transactionPendingDeleteCart(Request $request){
        $shoppingCart = ShoppingCart::where('id_product', $request->id_product)
                                    ->where('id_invoice', $request->id_invoice)
                                    ->first();
        $stock = ProductStock::find($request->id_product);
        $updateStok = (int) $stock->stok+$shoppingCart->qty;
        $stock->update([
            'stok' => $updateStok
        ]);
        $shoppingCart->delete();
        //dd($updateqty);
        $notification = array(
            'message' => 'Successfully Updated!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
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

    public function cartTransactionPendingProcess(Request $request){
        $invoice = Invoice::where('id_kasir', auth()->user()->id)
                            ->where('id_tenant', auth()->user()->id_tenant)
                            ->find($request->id_invoice);
        $kembalian = (int) str_replace(['.', ' ', 'Rp'], '', $request->kembalianText);
        if($request->jenisPembayaran == "Tunai"){
            $invoice->update([
                'jenis_pembayaran' => $request->jenisPembayaran,
                'tanggal_pelunasan' => Carbon::now(),
                'status_pembayaran' => 1,
                'sub_total' => $request->sub_total_belanja,
                'pajak' => $request->nominal_pajak,
                'diskon' => $request->nominal_diskon,
                'nominal_bayar' => $request->nominalText,
                'kembalian' => $kembalian,
            ]);
            if(!is_null($invoice)) {
                $invoice->fieldSave($invoice);
            }
            //session()->forget('cart');
            $notification = array(
                'message' => 'Transaksi berhasil diproses!',
                'alert-type' => 'success',
            );
            return redirect()->route('kasir.pos.transaction.invoice', array('id' => $invoice->id))->with($notification);
        } else if($request->jenisPembayaran == "Qris"){
            $total = (int) $request->nominal_pajak+$request->sub_total_belanja;
            $client = new Client();
            $url = 'https://erp.pt-best.com/api/dynamic_qris_wt_new';
            $postResponse = $client->request('POST',  $url, [
                'form_params' => [
                    'amount' => $total,
                    'transactionNo' => $invoice->nomor_invoice,
                    'pos_id' => "VP",
                    'secret_key' => "Vpos71237577"
                ]
            ]);
            $responseCode = $postResponse->getStatusCode();
            $data = json_decode($postResponse->getBody());

            $invoice->update([
                'jenis_pembayaran' => $request->jenisPembayaran,
                'tanggal_pelunasan' => Carbon::now(),
                'status_pembayaran' => 0,
                'qris_data' => $data->data->data->qrisData,
                'sub_total' => $request->sub_total_belanja,
                'pajak' => $request->nominal_pajak,
                'diskon' => $request->nominal_diskon,
                'nominal_bayar' => $total,
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
        }
    }

    public function cartTransactionPendingChangePayment(Request $request){
        $invoice = Invoice::where('id_tenant', auth()->user()->id_tenant)
                            ->where('id_kasir', auth()->user()->id)
                            ->find($request->id);
        $kembalian = (int) str_replace(['.', ' ', 'Rp'], '', $request->kembalian);
        $invoice->update([
            'tanggal_pelunasan' => Carbon::now(),
            'jenis_pembayaran' => "Tunai",
            'qris_data' => NULL,
            'status_pembayaran' => 1,
            'nominal_bayar' => $request->nominal,
            'kembalian' => $kembalian,
        ]);

        $notification = array(
            'message' => 'Transaksi berhasil diproses!',
            'alert-type' => 'success',
        );

        return redirect()->route('kasir.pos.transaction.invoice', array('id' => $invoice->id))->with($notification);
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

    public function testPrint(){
        $connector = new FilePrintConnector("php://stdout");
        $printer = new Printer($connector);
        $printer -> text("Hello World!\n");
        $printer -> cut();
        $printer -> close();
        return $printer;
    }

    public function testTimestamp(){
        $time = date("dmY");
        return $time;
    }
}
