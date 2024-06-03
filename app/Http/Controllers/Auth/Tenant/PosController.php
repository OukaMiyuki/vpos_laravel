<?php

namespace App\Http\Controllers\Auth\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\DB;
use App\Models\ProductStock;
use App\Models\ShoppingCart;
use App\Models\Invoice;
use App\Models\Discount;
use App\Models\Tax;
use App\Models\TenantField;
use App\Models\StoreDetail;
use App\Models\History;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use GuzzleHttp\Client;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use App\Models\TenantQrisAccount;
use Exception;

class PosController extends Controller {
    
    public function getStoreIdentifier(){
        $store = StoreDetail::select(['store_identifier'])
                            ->where('id_tenant', auth()->user()->id)
                            ->where('email', auth()->user()->email)
                            ->first();
        $identifier = $store->store_identifier;
        return $identifier;
    }

    function get_client_ip() {
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

    public function pos() {
        $identifier = $this->getStoreIdentifier();
        $stock = ProductStock::with('product')
                        ->where(function ($query) {
                                $query->where('stok', '!=', 0);
                        })
                        ->where('store_identifier', $identifier)
                        ->latest()
                        ->get();
        $customField = TenantField::where('store_identifier', $identifier)
                                    ->first();
        return view('tenant.tenant_pos', compact('stock', 'customField'));
    }

    public function addCart(Request $request){
        $identifier = $this->getStoreIdentifier();
        $diskon = Discount::where('store_identifier', $identifier)
                            ->where('is_active', 1)
                            ->first();

        $tax = Tax::where('store_identifier', $identifier)
                    ->where('is_active', 1)
                    ->first();

        if(!empty($tax)){
            Cart::setGlobalTax($tax->pajak);
        } else {
            Cart::setGlobalTax(0);
        }

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

    public function cartTransactionProcess(Request $request){
        // $subtotal = (int) substr(str_replace([',', '.'], '', Cart::subtotal()), 0, -2);
        // $total = (int) substr(str_replace([',', '.'], '', Cart::total()), 0, -2);
        // $tax = (int) substr(str_replace([',', '.'], '', Cart::tax()), 0, -2);
        // $diskon = (int) substr(str_replace([',', '.'], '', Cart::discount()), 0, -2);
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();
        $invoice = "";
        try{
            $subtotal = Cart::subtotalFloat();
            $total = Cart::totalFloat();
            $tax = Cart::taxFloat();
            $diskon = Cart::discountFloat();
            $kembalian = (int) str_replace(['.', ' ', 'Rp'], '', $request->kembalianText);
            $identifier = $this->getStoreIdentifier();
            if($request->jenisPembayaran == "Tunai"){
                $invoice = Invoice::create([
                    'store_identifier' => $identifier,
                    'email' => auth()->user()->email,
                    'id_tenant' => auth()->user()->id,
                    'id_kasir' => NULL,
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
                    $invoice->fieldSave($invoice);
                    $invoice->updateTunaiWallet($total);
                }
            } else if($request->jenisPembayaran == "Qris"){
                $invoice = Invoice::create([
                    'store_identifier' => $identifier,
                    'email' => auth()->user()->email,
                    'id_tenant' => auth()->user()->id,
                    'id_kasir' => NULL,
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
            }

            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Create Transaction Success : ".$invoice->nomor_invoice,
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                'status' => 1
            ]);

            session()->forget('cart');
    
            $notification = array(
                'message' => 'Transaksi berhasil diproses!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.pos.invoice', array('id' => $invoice->id))->with($notification);

        } catch(Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Transaksi Gagal : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Transaksi Gagal di proses!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function cartTransactionInvoice($id){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::with('shoppingCart', 'invoiceField', 'kasir')
                            ->where('store_identifier', $identifier)
                            ->whereNotNull('jenis_pembayaran')
                            ->find($id);

        if(is_null($invoice) || empty($invoice)){
            $notification = array(
                'message' => 'Transaksi tidak ditemukan atau belum diproses!',
                'alert-type' => 'warning',
            );

            return redirect()->route('tenant.transaction.list')->with($notification);
        }

        return view('tenant.tenant_invoice_detail', compact('invoice'));
    }

    public function cartTransactionInvoiceReceipt($id){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::with('shoppingCart', 'invoiceField')
                            ->where('store_identifier', $identifier)
                            ->find($id);

        if(is_null($invoice) || empty($invoice)){
            $notification = array(
                'message' => 'Transaksi tidak ditemukan atau belum diproses!',
                'alert-type' => 'warning',
            );

            return redirect()->route('tenant.transaction.list')->with($notification);
        }

        return view('tenant.printer', compact('invoice'));
    }

    public function cartTransactionPendingChangePayment(Request $request){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();

        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::where('store_identifier', $identifier)
                            ->find($request->id);
        
        if(is_null($invoice) || empty($invoice)){
            $notification = array(
                'message' => 'Transaksi tidak ditemukan!',
                'alert-type' => 'warning',
            );

            return redirect()->back()->with($notification);
        }
        
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

            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change Payment For Transaction : ".$invoice->nomor_invoice,
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                'status' => 1
            ]);
    
            $notification = array(
                'message' => 'Pembayaran berhasil diubah!',
                'alert-type' => 'success',
            );
    
            return redirect()->route('tenant.pos.invoice', array('id' => $invoice->id))->with($notification);
        } catch(Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Change Payment : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Pembayaran gagal diubah!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function cartTransactionSave(Request $request){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();

        $invoice = "";

        try{
            $identifier = $this->getStoreIdentifier();
            $invoice = Invoice::create([
                'store_identifier' => $identifier,
                'email' => auth()->user()->email,
                'id_tenant' => auth()->user()->id,
                'id_kasir' => NULL,
                'tanggal_transaksi' => Carbon::now()
            ]);
            if(!is_null($invoice)) {
                $invoice->storeCart($invoice);
                $invoice->customerIdentifier($invoice);
                session()->forget('cart');
            }
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Create Transaction Save : ".$invoice->nomor_invoice,
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                'status' => 1
            ]);
            $notification = array(
                'message' => ' Transaksi Sukses disimpan!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Create Transaction Save : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

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

    public function transactionPendingRestore($id){
        $identifier = $this->getStoreIdentifier();
        $invoice = Invoice::with('shoppingCart', 'customer')
                            ->where('store_identifier', $identifier)
                            ->whereNull('jenis_pembayaran')
                            ->where('status_pembayaran', 0)
                            ->find($id);

        if(empty($invoice) || is_null($invoice)){
            $notification = array(
                'message' => 'Transaksi tidak ditemukan!',
                'alert-type' => 'warning',
            );
    
            return redirect()->route('tenant.transaction.list.pending')->with($notification);
        }

        $stock = ProductStock::with('product')
                            ->where(function ($query) {
                                    $query->where('stok', '!=', 0);
                            })
                            ->where('store_identifier', $identifier)
                            ->latest()
                            ->get();
        $customField = TenantField::where('store_identifier', $identifier)->first();
        $shoppingCart = $invoice->shoppingCart;
        $notification = array(
            'message' => 'Transaction restored!',
            'alert-type' => 'success',
        );
        return view('tenant.tenant_transaction_restore', compact('customField', 'invoice', 'stock', 'shoppingCart'))->with($notification);
    }

    public function transactionPendingDelete($id) {
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();

        try{
            $identifier = $this->getStoreIdentifier();
            $invoice = Invoice::where('store_identifier', $identifier)
                                ->where('status_pembayaran', 0)
                                ->find($id);
            $invoiceTemp = $invoice->nomor_invoice;
            session()->forget('cart');
            if(is_null($invoice) || empty($invoice)) {
                $notification = array(
                    'message' => 'Transaksi tidak ditemukan!',
                    'alert-type' => 'warning',
                );
    
                return redirect()->back()->with($notification);
            }
            $invoice->deleteCart($invoice);
            $invoice->delete();
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Delete Pending Transaction : ".$invoiceTemp,
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                'status' => 1
            ]);
            $notification = array(
                'message' => 'Transaction Deleted Successfully!',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        } catch(Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Delete Pending Transaction : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Transaksi gagal dihapus!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function transactionPendingAddCart(Request $request){
        $identifier = $this->getStoreIdentifier();
        $shoppingCart = ShoppingCart::where('id_product', $request->id_product)
                                    ->where('id_invoice', $request->id_invoice)
                                    ->first();

        $stock = ProductStock::where('store_identifier', $identifier)
                            ->find($request->id_product);

        if($stock->stok < $request->qty){
            $notification = array(
                'message' => 'Stok tidak mencukupi!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        if(empty($shoppingCart) || is_null($shoppingCart) || $shoppingCart->count() == 0 || $shoppingCart == ""){
            ShoppingCart::create([
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
        $identifier = $this->getStoreIdentifier();
        $shoppingCart = ShoppingCart::where('id_product', $request->id_product)
                                    ->where('id_invoice', $request->id_invoice)
                                    ->first();

        $stock = ProductStock::where('store_identifier', $identifier)
                                    ->find($request->id_product);

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
        $identifier = $this->getStoreIdentifier();
        $shoppingCart = ShoppingCart::where('id_product', $request->id_product)
                                    ->where('id_invoice', $request->id_invoice)
                                    ->first();

        $stock = ProductStock::where('store_identifier', $identifier)
                                    ->find($request->id_product);

        $updateStok = (int) $stock->stok+$shoppingCart->qty;
        $stock->update([
            'stok' => $updateStok
        ]);
        $shoppingCart->delete();
        $notification = array(
            'message' => 'Successfully Updated!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function cartTransactionPendingProcess(Request $request){
        $ip = "125.164.244.223";
        $PublicIP = $this->get_client_ip();
        $getLoc = Location::get($ip);
        $lat = $getLoc->latitude;
        $long = $getLoc->longitude;
        DB::connection()->enableQueryLog();

        $invoice = "";

        try{
            $identifier = $this->getStoreIdentifier();
            $invoice = Invoice::where('store_identifier', $identifier)
                            ->find($request->id_invoice);
                            
            if(empty($invoice) || is_null($invoice)){
                $notification = array(
                    'message' => 'Transaksi tidak ditemukan!',
                    'alert-type' => 'warning',
                );
        
                return redirect()->back()->with($notification);
            }

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
                    $invoice->fieldSave($invoice);
                    $invoice->updateTunaiWallet($total);
                }
            } else if($request->jenisPembayaran == "Qris"){
                $total = (int) $request->nominal_pajak+$request->sub_total_belanja;
                if(auth()->user()->id_inv_code != 0){
                    $storeDetail = StoreDetail::select(['status_umi'])->where('store_identifier', $invoice->store_identifier)->first();
                    // this first
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
                    // this end
                }
            }
            session()->forget('cart');

            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Transaction Pending Process : ".$invoice->nomor_invoice,
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => str_replace("'", "\'", json_encode(DB::getQueryLog())),
                'status' => 1
            ]);

            $notification = array(
                'message' => 'Transaksi berhasil diproses!',
                'alert-type' => 'success',
            );
            return redirect()->route('tenant.pos.invoice', array('id' => $invoice->id))->with($notification);
        } catch(Exception $e){
            History::create([
                'id_user' => auth()->user()->id,
                'email' => auth()->user()->email,
                'action' => "Transaction Pending Process : Error",
                'lokasi_anda' => "Lokasi : (Lat : ".$lat.", "."Long : ".$long.")",
                'deteksi_ip' => $ip,
                'log' => $e,
                'status' => 0
            ]);

            $notification = array(
                'message' => 'Transaksi gagal diproses!',
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }
    }
}