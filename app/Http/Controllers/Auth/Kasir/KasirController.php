<?php

namespace App\Http\Controllers\Auth\Kasir;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client as GuzzleHttpClient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use App\Models\ProductStock;
use App\Models\ShoppingCart;
use App\Models\StoreDetail;
use App\Models\Invoice;
use App\Models\Discount;
use App\Models\Tax;
use App\Models\TenantField;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use GuzzleHttp\Client;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use App\Models\TenantQrisAccount;
use App\Models\History;
use Exception;
use Imagick;

class KasirController extends Controller {
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

    public function index(){
        $totalInvoiceHariIni = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                        ->where('store_identifier', auth()->user()->id_store)
                                        ->where('id_kasir', auth()->user()->id)
                                        ->count();
        $totalInvoice = Invoice::where('store_identifier', auth()->user()->id_store)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->count();
        $pemasukanHariIniTunai = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                    ->where('store_identifier', auth()->user()->id_store)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->where('jenis_pembayaran', 'Tunai')
                                    ->where('status_pembayaran', 1)
                                    ->sum(DB::raw('sub_total + pajak'));
        $pemasukanHariIniQris = Invoice::whereDate('tanggal_transaksi', Carbon::today())
                                    ->where('store_identifier', auth()->user()->id_store)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->where('jenis_pembayaran', 'Qris')
                                    ->where('status_pembayaran', 1)
                                    ->sum('nominal_terima_bersih');
        $pemasukanHariIni = $pemasukanHariIniTunai+$pemasukanHariIniQris;
        $totalPemasukanTunai = Invoice::where('store_identifier', auth()->user()->id_store)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->where('jenis_pembayaran', 'Tunai')
                                    ->where('status_pembayaran', 1)
                                    ->sum(DB::raw('sub_total + pajak'));
        $totalPemasukanQris = Invoice::where('store_identifier', auth()->user()->id_store)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->where('jenis_pembayaran', 'Qris')
                                    ->where('status_pembayaran', 1)
                                    ->sum('nominal_terima_bersih');
        $totalPemasukan = $totalPemasukanTunai+$totalPemasukanQris;
        $invoice = Invoice::where('store_identifier', auth()->user()->id_store)
                            ->where('id_kasir', auth()->user()->id)
                            ->latest()
                            ->take(10)
                            ->get();
        $invoicePaymentPending = Invoice::where('store_identifier', auth()->user()->id_store)
                                        ->where('id_kasir', auth()->user()->id)
                                        ->where('jenis_pembayaran', 'Qris')
                                        ->where('status_pembayaran', 0)
                                        ->latest()
                                        ->take(10)
                                        ->get();
        $transaksiTerbaru = Invoice::where('store_identifier', auth()->user()->id_store)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->whereDate('tanggal_transaksi', Carbon::now())
                                    ->latest()
                                    ->take(10)
                                    ->get();
        $transaksiQrisPending = Invoice::where('store_identifier', auth()->user()->id_store)
                                    ->where('id_kasir', auth()->user()->id)
                                    ->where('jenis_pembayaran', 'Qris')
                                    ->where('status_pembayaran', 0)
                                    ->latest()
                                    ->take(10)
                                    ->get();
        return view('kasir.dashboard', compact(['totalInvoiceHariIni', 'totalInvoice', 'pemasukanHariIni', 'totalPemasukan', 'transaksiTerbaru', 'transaksiQrisPending']));
    }

    public function kasirPos(){
        $stock = ProductStock::with('product')->where('store_identifier', auth()->user()->id_store)->latest()->get();
        $customField = TenantField::where('store_identifier', auth()->user()->id_store)->first();
        return view('kasir.kasir_pos', compact('stock', 'customField'));
    }

    public function addCart(Request $request){
        $diskon = Discount::where('store_identifier', auth()->user()->id_store)
                    ->where('is_active', 1)->first();

        $tax = Tax::where('store_identifier', auth()->user()->id_store)
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
            'options' => ['size' => $request->tipe_barang]
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

        Cart::update($rowId, $qty);

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

        Cart::remove($id);

        $notification = array(
            'message' => 'Sukses dihapus!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function cartTransactionSave(Request $request){
        DB::connection()->enableQueryLog();
        $invoice = "";

        try{
            $invoice = Invoice::create([
                'store_identifier' => auth()->user()->id_store,
                'email' => auth()->user()->store->email,
                'id_tenant' => auth()->user()->store->id_tenant,
                'id_kasir' => auth()->user()->id,
                'tanggal_transaksi' => Carbon::now()
            ]);
            if(!is_null($invoice)) {
                $invoice->storeCart($invoice);
                $invoice->customerIdentifier($invoice);
                session()->forget('cart');
            }
            $action = "Kasir : Create Transaction Save | ".$invoice->nomor_invoice;
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Sukses disimpan!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);

        } catch(Exception $e){
            $action = "Kasir : Create Transaction Save | Error";
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Transaksi gagal disimpan!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
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
        // $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
        // $total = (int) substr(str_replace([',', '.'], '', Cart::total()), 0, -2);
        // $tax = (int) substr(str_replace([',', '.'], '', Cart::tax()), 0, -2);
        // $diskon = (int) substr(str_replace([',', '.'], '', Cart::discount()), 0, -2);
        DB::connection()->enableQueryLog();
        $invoice = "";

        try{
            $subtotal = Cart::subtotalFloat();
            $total = Cart::totalFloat();
            $tax = Cart::taxFloat();
            $diskon = Cart::discountFloat();
            $kembalian = (int) str_replace(['.', ' ', 'Rp'], '', $request->kembalianText);
            if($request->jenisPembayaran == "Tunai"){
                $invoice = Invoice::create([
                    'store_identifier' => auth()->user()->id_store,
                    'email' => auth()->user()->store->email,
                    'id_tenant' => auth()->user()->store->id_tenant,
                    'id_kasir' => auth()->user()->id,
                    'jenis_pembayaran' => $request->jenisPembayaran,
                    'nominal_bayar' => $request->nominalText,
                    'kembalian' => $kembalian,
                    'status_pembayaran' => 1,
                    'sub_total' => $subtotal,
                    'pajak' => $tax,
                    'diskon' => $diskon,
                    'mdr' => 0,
                    'nominal_mdr' => 0,
                    'nominal_terima_bersih' => 0,
                    'tanggal_pelunasan' => Carbon::now(),
                    'tanggal_transaksi' => Carbon::now()
                ]);

                if(!is_null($invoice)) {
                    $invoice->storeCart($invoice);
                    $invoice->fieldSave($invoice, auth()->user()->id_store, auth()->user()->id);
                    $invoice->updateTunaiWallet($total);
                }
            } else if($request->jenisPembayaran == "Qris"){
                $invoice = Invoice::create([
                    'store_identifier' => auth()->user()->id_store,
                    'email' => auth()->user()->store->email,
                    'id_tenant' => auth()->user()->store->id_tenant,
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
                    if($invoice->qris_response == 211000 || $invoice->qris_response == "211000"){
                        $invoice->storeCart($invoice);
                        $invoice->fieldSave($invoice, auth()->user()->id_store, auth()->user()->id);
                    } else {
                        $action = "Tenant : Create Transaction | Error";
                        $this->createHistoryUser($action, $invoice->qris_response, 0);
                        $invoiceCreated = Invoice::find($invoice->id);
                        $invoiceCreated->delete();
                        $notification = array(
                            'message' => 'Gagal membuat transaksi, harap hubungi Admin!',
                            'alert-type' => 'warning',
                        );
                        return redirect()->back()->with($notification);
                    }
                }
            }
            $action = "Kasir : Create Transaction | ".$invoice->nomor_invoice;
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            session()->forget('cart');
            $notification = array(
                'message' => 'Transaksi berhasil diproses!',
                'alert-type' => 'success',
            );
            return redirect()->route('kasir.pos.transaction.invoice', array('id' => $invoice->id))->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Gagal membuat transaksi, harap hubungi Admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function transactionDashboard(){
        $transaction = Invoice::where('store_identifier', auth()->user()->id_store)
                                ->where('id_kasir', auth()->user()->id)
                                ->where('id_tenant', auth()->user()->store->id_tenant)
                                ->count();
        $transactionPending = Invoice::where('store_identifier', auth()->user()->id_store)
                                        ->where('id_kasir', auth()->user()->id)
                                        ->where('id_tenant', auth()->user()->store->id_tenant)
                                        ->where('jenis_pembayaran', NULL)
                                        ->where('status_pembayaran', 0)
                                        ->count();
        $transactionPendingPayment = Invoice::where('store_identifier', auth()->user()->id_store)
                                        ->where('id_kasir', auth()->user()->id)
                                        ->where('id_tenant', auth()->user()->store->id_tenant)
                                        ->where('jenis_pembayaran', "Qris")
                                        ->where('status_pembayaran', 0)
                                        ->count();
        $transactionFinish = Invoice::where('store_identifier', auth()->user()->id_store)
                                        ->where('id_kasir', auth()->user()->id)
                                        ->where('id_tenant', auth()->user()->store->id_tenant)
                                        ->where('status_pembayaran', 1)
                                        ->count();
        //dd($transactionFinish);
        return view('kasir.kasir_transaction', compact('transaction', 'transactionPending', 'transactionPendingPayment', 'transactionFinish'));

    }

    public function transactionList(){
        $invoice = Invoice::with('customer')
                            ->where('store_identifier', auth()->user()->id_store)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('id_tenant', auth()->user()->store->id_tenant)
                            ->latest()
                            ->get();
        return view('kasir.kasir_transaction_list', compact('invoice'));
    }

    public function transactionPending(){
        $invoice = Invoice::with('customer')
                            ->where('store_identifier', auth()->user()->id_store)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('id_tenant', auth()->user()->store->id_tenant)
                            ->where('jenis_pembayaran', NULL)
                            ->where('status_pembayaran', 0)
                            ->latest()
                            ->get();
        return view('kasir.kasir_invoice_pending', compact('invoice'));
    }

    public function transactionPendingPayment(){
        $invoice = Invoice::where('store_identifier', auth()->user()->id_store)
                        ->where('id_kasir', auth()->user()->id)
                        ->where('id_tenant', auth()->user()->store->id_tenant)
                        ->where('jenis_pembayaran', "Qris")
                        ->where('status_pembayaran', 0)
                        ->latest()
                        ->get();
        return view('kasir.kasir_invoice_pending_payment', compact('invoice'));
    }

    public function transactionPendingRestore($id){
        $invoice = Invoice::with('shoppingCart', 'customer')
                            ->where('store_identifier', auth()->user()->id_store)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('id_tenant', auth()->user()->store->id_tenant)
                            ->whereNull('jenis_pembayaran')
                            ->where('status_pembayaran', 0)
                            ->find($id);
        if(is_null($invoice) || empty($invoice)){
            $notification = array(
                'message' => 'Transaksi tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->route('kasir.transaction.pending')->with($notification);
        }
        $stock = ProductStock::with('product')->where('store_identifier', auth()->user()->id_store)->latest()->get();
        $customField = TenantField::where('store_identifier', auth()->user()->id_store)->first();
        $shoppingCart = $invoice->shoppingCart;
        $notification = array(
            'message' => 'Transaction restored!',
            'alert-type' => 'success',
        );
        return view('kasir.kasir_transaction_restore', compact('customField', 'invoice', 'stock', 'shoppingCart'))->with($notification);
    }

    public function transactionPendingAddCart(Request $request){
        DB::beginTransaction();
        $shoppingCart = ShoppingCart::where('id_product', $request->id_product)
                                    ->where('id_invoice', $request->id_invoice)
                                    ->first();

        if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
            $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->find($request->id_product);
            if($stock->stok < $request->qty){
                $notification = array(
                    'message' => 'Stok tidak mencukupi!',
                    'alert-type' => 'error',
                );
                return redirect()->back()->with($notification);
            }
        }

        if(empty($shoppingCart) || is_null($shoppingCart) || $shoppingCart->count() == 0 || $shoppingCart == ""){
            ShoppingCart::create([
                'id_kasir' => auth()->user()->id,
                'id_invoice' => $request->id_invoice,
                'id_product' => $request->id_product,
                'product_name' => $request->name,
                'qty' => $request->qty,
                'harga' => $request->price,
                'tipe_barang' => $request->tipe_barang,
                'sub_total' => $request->qty*$request->price
            ]);
        } else {
            if($request->tipe_barang == "Custom" || $request->tipe_barang == "Pack"){
                $updateSHoppingCart = ShoppingCart::find($shoppingCart->id);
                $updateSHoppingCart->update([
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
        }
        if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
            try {
                $id = $request->id_product;
                $qty = $request->qty;
                $store_identifier = auth()->user()->id_store;
                DB::transaction(function () use ($id, $qty, $store_identifier) {
                    $stock = ProductStock::where('store_identifier', $store_identifier)->lockForUpdate()->find($id);
                    $updateStok = (int) $stock->stok - (int) $qty;
                    $stock->update([
                        'stok' => $updateStok
                    ]);
                    DB::commit();
                });
                $notification = array(
                    'message' => 'Successfully Added!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            } catch(Exception $e){
                DB::rollback();
                return redirect()->back();
            }
        }

        $notification = array(
            'message' => 'Successfully Added!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    // public function transactionPendingAddCart(Request $request){
    //     DB::beginTransaction();
    //     $shoppingCart = ShoppingCart::where('id_product', $request->id_product)
    //                                 ->where('id_invoice', $request->id_invoice)
    //                                 ->first();
    //     if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
    //         $stock = ProductStock::find($request->id_product);
    //         if($stock->stok < $request->qty){
    //             $notification = array(
    //                 'message' => 'Stok tidak mencukupi!',
    //                 'alert-type' => 'error',
    //             );
    //             return redirect()->back()->with($notification);
    //         }
    //     }

    //     if(empty($shoppingCart) || $shoppingCart->count() == 0 || $shoppingCart == ""){
    //         ShoppingCart::create([
    //             'id_invoice' => $request->id_invoice,
    //             'id_product' => $request->id_product,
    //             'product_name' => $request->name,
    //             'qty' => $request->qty,
    //             'harga' => $request->price,
    //             'tipe_barang' => $request->tipe_barang,
    //             'sub_total' => $request->qty*$request->price
    //         ]);
    //     } else {
    //         if($request->tipe_barang == "Custom" || $request->tipe_barang == "Pack"){
    //             $updateSHoppingCart = ShoppingCart::find($shoppingCart->id);
    //             $updateSHoppingCart->update([
    //                 'qty' => $request->qty,
    //                 'harga' => $request->price,
    //                 'sub_total' => $request->qty*$request->price
    //             ]);
    //         } else {
    //             $tempQty = $shoppingCart->qty;
    //             $totalQty = $tempQty+$request->qty;
    //             $shoppingCart->update([
    //                 'qty' => $totalQty,
    //                 'sub_total' => $totalQty*$request->price
    //             ]);
    //         }
    //     }

    //     if($request->tipe_barang != "Custom" && $request->tipe_barang != "Pack"){
    //         try {
    //             $id = $request->id_product;
    //             $qty = $request->qty;
    //             DB::transaction(function () use ($id, $qty) {
    //                 $stock = ProductStock::find($id)->lockForUpdate();
    //                 $updateStok = (int) $stock->stok - (int) $qty;
    //                 $stock->update([
    //                     'stok' => $updateStok
    //                 ]);
    //                 DB::commit();
    //             });
    //             $notification = array(
    //                 'message' => 'Successfully Added!',
    //                 'alert-type' => 'success',
    //             );
    //             return redirect()->back()->with($notification);
    //         } catch(Exception $e){
    //             DB::rollback();
    //             return redirect()->back();
    //         }
    //     }

    //     $notification = array(
    //         'message' => 'Successfully Added!',
    //         'alert-type' => 'success',
    //     );
    //     return redirect()->back()->with($notification);
    // }

    public function transactionPendingUpdateCart(Request $request){
        DB::beginTransaction();
        $id_invoice = $request->id_invoice;
        $id_product = $request->id_product;
        $qty        = $request->qty;
        try{
            DB::transaction(function () use ($id_invoice, $id_product, $qty) {
                $shoppingCart = ShoppingCart::where('id_product', $id_product)
                                            ->where('id_invoice', $id_invoice)
                                            ->lockForUpdate()
                                            ->first();
                $stock = ProductStock::find($id_product)->lockForUpdate();
                if($shoppingCart->qty<$qty){
                    $penambahan=(int) $qty-$shoppingCart->qty;
                    $updateqty=$penambahan+$shoppingCart->qty;
                    $harga=$shoppingCart->harga;
                    if($stock->stok<$penambahan){
                        $notification = array(
                            'message' => 'Stok tidak mencukupi untuk jumlah tersebut!',
                            'alert-type' => 'error',
                        );
                        DB::commit();
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
                        DB::commit();
                        $notification = array(
                            'message' => 'Successfully Updated!',
                            'alert-type' => 'success',
                        );
                        return redirect()->back()->with($notification);
                    }
                } else if($shoppingCart->qty>$qty){
                    $pengurangan=(int) $shoppingCart->qty-$qty;
                    //$updateqty=$pengurangan-$request->qty;
                    $harga=$shoppingCart->harga;

                    $shoppingCart->update([
                        'qty' => $qty,
                        'sub_total' => $qty*$harga
                    ]);
                    $updateStok = (int) $stock->stok + (int) $pengurangan;
                    $stock->update([
                        'stok' => $updateStok
                    ]);
                    DB::commit();
                    $notification = array(
                        'message' => 'Successfully Updated!',
                        'alert-type' => 'success',
                    );
                    return redirect()->back()->with($notification);
                } else {
                    $notification = array(
                        'message' => 'Successfully Added!',
                        'alert-type' => 'success',
                    );
                    DB::commit();
                    return redirect()->back()->with($notification);
                }
            });
            $notification = array(
                'message' => 'Successfully Updated!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            DB::rollback();
            return redirect()->back();
        }
    }

    public function transactionPendingDeleteCart(Request $request){
        $shoppingCart = ShoppingCart::where('id_product', $request->id_product)
                                    ->where('id_invoice', $request->id_invoice)
                                    ->first();

        if($shoppingCart->tipe_barang != "Custom" && $shoppingCart->tipe_barang != "Pack"){
            $stock = ProductStock::where('store_identifier', auth()->user()->id_store)->find($request->id_product);
            $updateStok = (int) $stock->stok+$shoppingCart->qty;
            $stock->update([
                'stok' => $updateStok
            ]);
        }
        $shoppingCart->delete();
        $notification = array(
            'message' => 'Successfully Updated!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function transactionPendingDelete($id) {
        DB::connection()->enableQueryLog();
        try{
            $invoice = Invoice::where('store_identifier', auth()->user()->id_store)
                                ->where('id_kasir', auth()->user()->id)
                                ->where('id_tenant', auth()->user()->store->id_tenant)
                                ->where('status_pembayaran', 0)
                                ->find($id);
            $invoiceTemp = $invoice->nomor_invoice;
            $action = "Kasir : Transaction Pending Delete | ". $invoiceTemp;
            if(is_null($invoice) || empty($invoice)){
                $notification = array(
                    'message' => 'Transaksi tidak ditemukan!',
                    'alert-type' => 'warning',
                );
                return redirect()->route('kasir.transaction.pending')->with($notification);
            }

            session()->forget('cart');
            if(!is_null($invoice)) {
                $invoice->deleteCart($invoice);
            }
            $invoice->delete();
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Transaction Deleted Successfully!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            $action = "Kasir : Transaction Pending Delete | Error";
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Transaksi gagal dihapus!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function cartTransactionPendingProcess(Request $request){
        DB::connection()->enableQueryLog();

        $invoice = "";

        try{
            $invoice = Invoice::where('store_identifier', auth()->user()->id_store)
                                ->where('id_kasir', auth()->user()->id)
                                ->where('id_tenant', auth()->user()->store->id_tenant)
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
                    'mdr' => 0,
                    'nominal_mdr' => 0,
                    'nominal_terima_bersih' => 0,
                ]);
                $total = $request->sub_total_belanja+$request->nominal_pajak;
                if(!is_null($invoice)) {
                    $invoice->fieldSave($invoice, auth()->user()->id_store, auth()->user()->id);
                    $invoice->updateTunaiWallet($total);
                }
            } else if($request->jenisPembayaran == "Qris"){
                $total = (int) $request->nominal_pajak+$request->sub_total_belanja;
                // Ga perlu id_tenant dan ngecek apa invitation codenya 0
                $storeDetail = StoreDetail::with(['jenisMDR'])->where('store_identifier', $invoice->store_identifier)->first();
                $qrisAccount = TenantQrisAccount::where('store_identifier', $invoice->store_identifier)->first();
                // this first
                $client = new Client();
                $data = "";
                $postResponse = "";
                $url = 'https://erp.pt-best.com/api/dynamic_qris_wt_new';
                if(is_null($qrisAccount) || empty($qrisAccount)){
                    $postResponse = $client->request('POST',  $url, [
                        'form_params' => [
                            'amount' => $total,
                            'transactionNo' => $invoice->nomor_invoice,
                            'pos_id' => "VP",
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
                            'pos_id' => "VP",
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
                    'jenis_pembayaran' => $request->jenisPembayaran,
                    // 'tanggal_pelunasan' => Carbon::now(),
                    'status_pembayaran' => 0,
                    'qris_data' => $qris_data,
                    'sub_total' => $request->sub_total_belanja,
                    'pajak' => $request->nominal_pajak,
                    'diskon' => $request->nominal_diskon,
                    'nominal_bayar' => $total,
                ]);

                if(!is_null($invoice)) {
                    $invoice->fieldSave($invoice, auth()->user()->id_store, auth()->user()->id);
                }

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
                // this end
            }
            session()->forget('cart');
            $action = "Kasir : Transaction Pending Process | ".$invoice->nomor_invoice;
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Transaksi berhasil diproses!',
                'alert-type' => 'success',
            );
            return redirect()->route('kasir.pos.transaction.invoice', array('id' => $invoice->id))->with($notification);
        } catch(Exception $e){
            $action = "Kasir : Transaction Pending Process | Error";
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Gagal memproses transaksi, harap hubungi Admin!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function cartTransactionPendingChangePayment(Request $request){
        DB::connection()->enableQueryLog();
        $invoice = Invoice::where('store_identifier', auth()->user()->id_store)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('id_tenant', auth()->user()->store->id_tenant)
                            ->find($request->id);

        if(is_null($invoice) || empty($invoice)){
            $notification = array(
                'message' => 'Transaksi tidak ditemukan!',
                'alert-type' => 'warning',
            );

            return redirect()->back()->with($notification);
        }
        $action = "Kasir : Change Payment | ".$invoice->nomor_invoice;
        try{
            $kembalian = (int) str_replace(['.', ' ', 'Rp'], '', $request->kembalian);
            $invoice->update([
                'tanggal_pelunasan' => Carbon::now(),
                'jenis_pembayaran' => "Tunai",
                'qris_data' => NULL,
                'status_pembayaran' => 1,
                'nominal_bayar' => $request->nominal,
                'kembalian' => $kembalian,
                'mdr' => 0,
                'nominal_mdr' => 0,
                'nominal_terima_bersih' => 0
            ]);
            $this->createHistoryUser($action, str_replace("'", "\'", json_encode(DB::getQueryLog())), 1);
            $notification = array(
                'message' => 'Pembayaran berhasil diubah!',
                'alert-type' => 'success',
            );

            return redirect()->route('kasir.pos.transaction.invoice', array('id' => $invoice->id))->with($notification);
        } catch(Exception $e){
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Pembayaran gagal diubah!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function cartTransactionInvoice($id){
        $invoice = Invoice::with('shoppingCart', 'invoiceField')
                            ->where('store_identifier', auth()->user()->id_store)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('id_tenant', auth()->user()->store->id_tenant)
                            ->whereNotNull('jenis_pembayaran')
                            ->find($id);

        if(is_null($invoice) || empty($invoice)){
            $notification = array(
                'message' => 'Transaksi tidak ditemukan atau belum diproses!',
                'alert-type' => 'warning',
            );

            return redirect()->route('kasir.transaction.list')->with($notification);
        }

        return view('kasir.kasir_invoice_preview', compact('invoice'));
    }

    public function cartTransactionInvoiceReceipt($id){
        $invoice = Invoice::with('shoppingCart', 'invoiceField')
                            ->where('store_identifier', auth()->user()->id_store)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('id_tenant', auth()->user()->store->id_tenant)
                            ->whereNotNull('jenis_pembayaran')
                            ->find($id);
        return view('kasir.printer', compact('invoice'));
    }

    public function transactionFinish(){
        $invoice = Invoice::where('store_identifier', auth()->user()->id_store)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('id_tenant', auth()->user()->store->id_tenant)
                            ->where('status_pembayaran', 1)
                            ->latest()
                            ->get();
        return view('kasir.kasir_invoice_finish', compact('invoice'));
    }

    public function downloadPdf(Request $request){
        $id = $request->id;
        $no_wa = $request->no_wa;
        $invoice = Invoice::with('shoppingCart', 'invoiceField')
                            ->where('store_identifier', auth()->user()->id_store)
                            ->where('id_kasir', auth()->user()->id)
                            ->where('id_tenant', auth()->user()->store->id_tenant)
                            ->find($id);
        if(is_null($invoice) || empty($invoice)){
            $notification = array(
                'message' => 'Invoice tidak ditemukan!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        
        $path = 'qrcode/';

        if(!\File::exists(public_path($path))) {
            \File::makeDirectory(public_path($path));
        }
        if($invoice->jenis_pembayaran == "Qris"){
            $file_path = $path.$invoice->nomor_invoice.'.png';
            try{
                $image = \QrCode::format('png')
                                ->size(800)->errorCorrection('H')
                                ->generate($invoice->qris_data, $file_path);
            } catch(Exception $e){
                $action = "Kasir : Send Qris to Whatsapp | Error - Image generaton error";
                $this->createHistoryUser($action, $e, 0);
                $notification = array(
                    'message' => 'Pembuatan gambar Qris gagal!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            }
        }
        try{
            $pdf = Pdf::loadView('pdf', ['invoice' => $invoice, 'qrcode-invoice' => $invoice->nomor_invoice])->set_option('isHtml5ParserEnabled', true);;
            $invoiceName = $invoice->nomor_invoice.'.pdf';
            $content = $pdf->download()->getOriginalContent();
            Storage::put('public/invoice/'.$invoiceName,$content);
            $pathPdf = Storage::path('public/invoice/'.$invoiceName);
            $imagick = new Imagick();
            $imagick->setResolution(200,200);
            $imagick->readImage($pathPdf);
            $saveImagePath = Storage::path('public/invoice/generate_image/'.$invoice->nomor_invoice.'.jpg');
            $imagick->writeImages($saveImagePath, true);
        } catch(Exception $e){
            $action = "Kasir : Send Invoice to Whatsapp | Error - PDF or IMage Convertion Fail";
            $this->createHistoryUser($action, $e, 0);
            $notification = array(
                'message' => 'Pembuatan laporan nota gagal!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        $api_key    = getenv("WHATZAPP_API_KEY");
        $sender  = getenv("WHATZAPP_PHONE_NUMBER");
        $client = new GuzzleHttpClient();
        $postResponse = "";
        $noHP = $no_wa;
        $hp = "";
        if(!preg_match("/[^+0-9]/",trim($noHP))){
            if(substr(trim($noHP), 0, 2)=="62"){
                $hp    =trim($noHP);
            }
            else if(substr(trim($noHP), 0, 1)=="0"){
                $hp    ="62".substr(trim($noHP), 1);
            }
        }
        $statusNotaBelanja = "";
        if($invoice->status_pembayaran == 0 && $invoice->status_pembbayaran == 0){
            $statusNotaBelanja = "Berikut nota pembayaran anda, harap lakukan scan pada barcode untuk membayar menggunakan Qris";
        } else {
            $statusNotaBelanja = "Berikut nota belaja anda.";
        }
        $url = 'https://waq.my.id/send-media';
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $data = [
            "api_key" => "apLiCx2p1xJNbi9fWrZFxSLeE1dJ2t",
            'sender' => "085179950178",
            'number' => $hp,
            // "media_type" => "document",
            "media_type" => "image",
            "caption" => $statusNotaBelanja,
            // "url" => 'https://visipos.id/storage/invoice/'.$invoice->nomor_invoice.'.pdf'
            "url" => 'https://visipos.id/storage/invoice/generate_image/'.$invoice->nomor_invoice.'.jpg'
        ];

        try {
            $postResponse = $client->post($url, [
                'headers' => $headers,
                'json' => $data,
            ]);
        } catch(Exception $ex){
            $notification = array(
                'message' => 'Nota gagal dikirim!, pastikan nomor whatsapp sesuai dan benar!',
                'alert-type' => 'warning',
            );
            return redirect()->back()->with($notification);
        }
        $responseCode = $postResponse->getStatusCode();
        $postImageResponse = "";
        $responseCodeImage = "";
        if($invoice->status_pembayaran == 0 && $invoice->status_pembbayaran == 0){
            $dataImage = [
                "api_key" => "apLiCx2p1xJNbi9fWrZFxSLeE1dJ2t",
                'sender' => "085179950178",
                'number' => $hp,
                "media_type" => "image",
                "caption" => "Scan QR Code berikut untuk melakukan pembayaran.",
                "url" => 'https://visipos.id/public/qrcode/'.$invoice->nomor_invoice.'.png'
            ];

            try {
                $postImageResponse = $client->post($url, [
                    'headers' => $headers,
                    'json' => $dataImage,
                ]);
            } catch(Exception $ex){
                $notification = array(
                    'message' => 'Nota gagal dikirim!, pastikan nomor whatsapp sesuai dan benar!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            }
            $responseCodeImage = $postImageResponse->getStatusCode();
            if(is_null($responseCode) || empty($responseCode) || is_null($responseCodeImage) || empty($responseCodeImage)){
                $notification = array(
                    'message' => 'Nota gagal dikirim!, pastikan nomor whatsapp sesuai dan benar!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            }
            if($responseCode == 200 && $responseCodeImage == 200){
                if(Storage::exists('public/invoice/'.$invoice->nomor_invoice.'.pdf') || Storage::exists('public/invoice/generate_image/'.$invoice->nomor_invoice.'.jpg')) {
                    Storage::delete('public/invoice/'.$invoice->nomor_invoice.'.pdf');
                    Storage::delete('public/invoice/generate_image/'.$invoice->nomor_invoice.'.jpg');
                }
                if(\File::exists(public_path($path.$invoice->nomor_invoice.'.png'))){
                    \File::delete(public_path($path.$invoice->nomor_invoice.'.png'));
                }
                // dd($postResponse);
                $notification = array(
                    'message' => 'Nota telah sukses dikirim ke nomor Whatsapp!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            } else {
                $notification = array(
                    'message' => 'Nota gagal dikirim!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            }
        } else {
            if(is_null($responseCode) || empty($responseCode)){
                $notification = array(
                    'message' => 'Nota gagal dikirim!, pastikan nomor whatsapp sesuai dan benar!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            }
            if($responseCode == 200){
                if(Storage::exists('public/invoice/'.$invoice->nomor_invoice.'.pdf') || Storage::exists('public/invoice/generate_image/'.$invoice->nomor_invoice.'.jpg')) {
                    Storage::delete('public/invoice/'.$invoice->nomor_invoice.'.pdf');
                    Storage::delete('public/invoice/generate_image/'.$invoice->nomor_invoice.'.jpg');
                }
                // dd($postResponse);
                $notification = array(
                    'message' => 'Nota telah sukses dikirim ke nomor Whatsapp!',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            } else {
                $notification = array(
                    'message' => 'Nota gagal dikirim!',
                    'alert-type' => 'warning',
                );
                return redirect()->back()->with($notification);
            }
        }
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
