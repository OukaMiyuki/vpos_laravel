<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Models\ShoppingCart;
use App\Models\Kasir;
use App\Models\Tenant;
use App\Models\InvoiceField;
use App\Models\StoreDetail;
use App\Models\Product;
use App\Models\StoreList;
use App\Models\ProductStock;
use App\Models\TunaiWallet;
use App\Models\QrisWallet;
use App\Models\CustomerIdentifier;
use App\Models\TenantQrisAccount;
use App\Models\HistoryCashbackAdmin;
use App\Models\History;
use Exception;

class Invoice extends Model {
    use HasFactory;

    protected $guarded = [];

    public function store(){
        return $this->belongsTo(StoreDetail::class, 'store_identifier', 'store_identifier');
    }

    public function storeMitra(){
        return $this->belongsTo(StoreList::class, 'store_identifier', 'store_identifier');
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id');
    }

    public function kasir(){
        return $this->belongsTo(Kasir::class, 'id_kasir', 'id');
    }

    public function shoppingCart() {
        return $this->hasMany(ShoppingCart::class, 'id_invoice', 'id');
    }

    public function invoiceField() {
        return $this->hasOne(InvoiceField::class, 'id_invoice', 'id');
    }

    public function customer() {
        return $this->hasOne(CustomerIdentifier::class, 'id_invoice', 'id');
    }

    public function historyCashbackAdmin(){
        return $this->hasOne(HistoryCashbackAdmin::class, 'id_invoice', 'id');
    }


    public function storeCart($model){
        DB::beginTransaction();
        $cartContent = Cart::content();
        $kasir = "";
        $tenant = "";
        if(Auth::guard('tenant')->check()){
            $kasir = NULL;
            if(auth()->user()->id_inv_code !=0){
                $tenant = auth()->user()->id;
            } else {
                $tenant = NULL;
            }
        } else if(Auth::guard('kasir')->check()){
            $tenant = NULL;
            $kasir = auth()->user()->id;
        }
        foreach($cartContent as $cart){
            ShoppingCart::create([
                'id_invoice' => $model->id,
                'id_product' => $cart->id,
                'product_name' => $cart->name,
                'qty' => $cart->qty,
                'tipe_barang' => $cart->options['size'],
                'harga' => $cart->price,
                'sub_total' => $cart->price*$cart->qty,
                'id_kasir' => $kasir,
                'id_tenant' => $tenant
            ]);
            if ($cart->options['size'] != "Custom" && $cart->options['size'] != "Pack"){
                try {
                    $stock = ProductStock::find($cart->id)->lockForUpdate();
                    $updateStok = (int) $stock->stok - (int) $cart->qty;
                    $stock->update([
                        'stok' => $updateStok
                    ]);
                    DB::commit();
                } catch(Exception $e) {
                    DB::rollback();
                }
            }
        }
    }

    public function fieldSave($model, $identifier, $kasirid){
        $kasir = "";
        if(is_null($kasirid) || empty($kasirid)){
            $kasir = NULL;
        } else {
            $kasir = $kasirid;
        }
        // if(Auth::guard('tenant')->check()){
        //     if(auth()->user()->id_inv_code != 0){
        //         $kasir = NULL;
        //     }
        // } else if(Auth::guard('kasir')->check()){
        //     $kasir =1;
        // }
        $content1="";
        $content2="";
        $content3="";
        $content4="";
        $content5="";
        $customerInfo="";
        if(!empty(request()->content1)){
            $content1 = request()->content1;
            $customerInfo=request()->content1;
        }
        if(!empty(request()->content2)){
            $content2 = request()->content2;
        }
        if(!empty(request()->content3)){
            $content3 = request()->content3;
        }
        if(!empty(request()->content4)){
            $content4 = request()->content4;
        }
        if(!empty(request()->content5)){
            $content5 = request()->content5;
        }
        $InvoiceField = new InvoiceField();
        $InvoiceField->id_invoice = $model->id;
        $InvoiceField->id_kasir = $kasir;
        $InvoiceField->store_identifier = $identifier;
        $InvoiceField->content1 = $content1;
        $InvoiceField->content2 = $content2;
        $InvoiceField->content3 = $content3;
        $InvoiceField->content4 = $content4;
        $InvoiceField->content5 = $content5;
        $InvoiceField->save();
        $CustomerIdentifier = CustomerIdentifier::where('id_invoice', $model->id)->first();
        if(empty($CustomerIdentifier) || is_null($CustomerIdentifier) || $CustomerIdentifier == NULL || $CustomerIdentifier == ""){
            $CustomerIdentifier = new CustomerIdentifier();
            $CustomerIdentifier->id_invoice = $model->id;
            $CustomerIdentifier->customer_info = $customerInfo;
            $CustomerIdentifier->save();
        } else {
            $CustomerIdentifier->update([
                'customer_info' => $customerInfo
            ]);
        }
    }

    public function customerIdentifier($model){
        $customerInfo="";
        if(!empty(request()->cust_info)){
            $customerInfo = request()->cust_info;
        }
        $CustomerIdentifier = new CustomerIdentifier();
        $CustomerIdentifier->id_invoice = $model->id;
        $CustomerIdentifier->customer_info = $customerInfo;
        $CustomerIdentifier->description   = request()->description;
        $CustomerIdentifier->save();
    }

    public function deleteCart($model){
        $cartContent = ShoppingCart::where('id_invoice', $model->id)->get();
        foreach($cartContent as $cart){
            $stock = ProductStock::find($cart->id_product);
            $updateStok = (int) $stock->stok + (int) $cart->qty;
            $stock->update([
                'stok' => $updateStok
            ]);
            $cart->delete();
        }
    }

    public function updateTunaiWallet($total){
        $tunaiWallet = "";
        if(Auth::guard('tenant')->check()){
            $tunaiWallet = TunaiWallet::where('id_tenant', auth()->user()->id)
                                        ->where('email', auth()->user()->email)
                                        ->first();
        } else if(Auth::guard('kasir')->check()){
            $tunaiWallet = TunaiWallet::where('id_tenant', auth()->user()->store->id_tenant)
                                        ->where('email', auth()->user()->store->email)
                                        ->first();
        }

        $totalSaldo = $tunaiWallet->saldo+$total;
        $tunaiWallet->update([
            'saldo' => $totalSaldo
        ]);
    }

    public static function boot(){
        parent::boot();

        static::creating(function($model){
            $client = new Client();
            $url = 'https://erp.pt-best.com/api/dynamic_qris_wt_new';
            $invoice_code = "VP";
            $time=time();
            // $date = date('dmYHis');
            $date = date('dmY');
            $index_number = Invoice::max('id') + 1;
            // $index_number = $model->id + 1;
            // $index_number = (int) $model->id;
            $generate_nomor_invoice = $invoice_code.$date.str_pad($index_number, 15, '0', STR_PAD_LEFT);
            // $generate_nomor_invoice = $date.str_pad($index_number, 9, '0', STR_PAD_LEFT);
            if(is_null($model->qris_data) || empty($model->qris_data) || $model->qris_data == NULL){
                $model->nomor_invoice = $generate_nomor_invoice;
            } else {
                if($model->qris_data == "Internal Qris"){
                    $date = date('YmdHisU');
                    $model->nomor_invoice = $date;
                } else {
                    $date = date('YmdHis');
                    $invoice_generated = $date;
                    $model->nomor_invoice = $model->qris_data.$invoice_generated;
                }
            }
            $tenant = Tenant::select(['id_inv_code'])->find($model->id_tenant);
            if($model->jenis_pembayaran == "Qris"){
                if($tenant->id_inv_code != 0){
                    $storeDetail = StoreDetail::with('jenisMDR')->where('store_identifier', $model->store_identifier)->first();
                    if($storeDetail->status_umi == 1){
                        if($model->nominal_bayar <= 100000){
                            $model->mdr = $storeDetail->jenisMDR->presentase_minimal_mdr;
                            $mdr = $storeDetail->jenisMDR->presentase_minimal_mdr;
                            $nominal_mdr = self::hitungMDR($model->nominal_bayar, $mdr );
                            $model->nominal_mdr = $nominal_mdr;
                            $model->nominal_terima_bersih = $model->nominal_bayar-$nominal_mdr;
                        } else {
                            $model->mdr = $storeDetail->jenisMDR->presentase_maksimal_mdr;
                            $mdr = $storeDetail->jenisMDR->presentase_maksimal_mdr;
                            $nominal_mdr = self::hitungMDR($model->nominal_bayar, $mdr);
                            $model->nominal_mdr = $nominal_mdr;
                            $model->nominal_terima_bersih = $model->nominal_bayar-$nominal_mdr;
                        }
                    } else {
                        $model->mdr = $storeDetail->jenisMDR->presentase_minimal_mdr;
                        $mdr = $storeDetail->jenisMDR->presentase_minimal_mdr;
                        $nominal_mdr = self::hitungMDR($model->nominal_bayar, $mdr);
                        $model->nominal_mdr = $nominal_mdr;
                        $model->nominal_terima_bersih = $model->nominal_bayar-$nominal_mdr;
                    }
                } else if($tenant->id_inv_code == 0) {
                    $store = StoreList::with('jenisMDR')->where('store_identifier', $model->store_identifier)->first();
                    $mdr = $store->jenisMDR->presentase_minimal_mdr;
                    $nominal_mdr = self::hitungMDR($model->nominal_bayar, $mdr );
                    $model->nominal_mdr = $nominal_mdr;
                    $model->nominal_terima_bersih = $model->nominal_bayar-$nominal_mdr;
                }

                if(is_null($model->qris_data) || empty($model->qris_data) || $model->qris_data == NULL){
                    $qrisAccount = TenantQrisAccount::where('store_identifier', $model->store_identifier)->where('id_tenant', $model->id_tenant)->first();

                    if(is_null($qrisAccount) || empty($qrisAccount)){
                        try {
                            $postResponse = $client->request('POST',  $url, [
                                'form_params' => [
                                    'amount' => $model->nominal_bayar,
                                    'transactionNo' => $generate_nomor_invoice,
                                    'pos_id' => "VP",
                                    'secret_key' => "Vpos71237577"
                                ]
                            ]);
                            //$responseCode = $postResponse->getStatusCode();
                            $data = json_decode($postResponse->getBody());
                            if(!is_null($data) || !empty($data)){
                                $qris_data = $data->data->data->qrisData;
                                if(!is_null($qris_data) || !empty($qris_data)){
                                    $model->qris_data = $data->data->data->qrisData;
                                }
                                $responseCode = $data->data->responseCode;
                                $model->qris_response = $responseCode;
                            }
                        } catch (Exception $e) {
                            History::create([
                                'id_user' => auth()->user()->id,
                                'email' => auth()->user()->email,
                                'action' => "Create Transaction Qris : Error",
                                'lokasi_anda' => "System Log",
                                'deteksi_ip' => "System Log",
                                'log' => $e,
                                'status' => 0
                            ]);
                        }
                    } else {
                        // $qrisLogin = $qrisAccount->qris_login_user;
                        // $qrisPassword = $qrisAccount->qris_password;
                        // $qrisMerchantID = $qrisAccount->qris_merchant_id;
                        $qrisStoreID = $qrisAccount->qris_store_id;
                        try {
                            $postResponse = $client->request('POST',  $url, [
                                'form_params' => [
                                    // 'login' => $qrisLogin,
                                    // 'password' => $qrisPassword,
                                    // 'merchantID' => $qrisMerchantID,
                                    'store_code' => $qrisStoreID,
                                    'amount' => $model->nominal_bayar,
                                    'transactionNo' => $generate_nomor_invoice,
                                    'pos_id' => "VP",
                                    'secret_key' => "Vpos71237577"
                                ]
                            ]);
                            //$responseCode = $postResponse->getStatusCode();
                            $data = json_decode($postResponse->getBody());
                            if(!is_null($data) || !empty($data)){
                                $qris_data = $data->data->data->qrisData;
                                if(!is_null($qris_data) || !empty($qris_data)){
                                    $model->qris_data = $data->data->data->qrisData;
                                }
                                $responseCode = $data->data->responseCode;
                                $model->qris_response = $responseCode;
                            }
                        } catch (Exception $e) {
                            History::create([
                                'id_user' => auth()->user()->id,
                                'email' => auth()->user()->email,
                                'action' => "Create Transaction Qris : Error",
                                'lokasi_anda' => "System Log",
                                'deteksi_ip' => "System Log",
                                'log' => $e,
                                'status' => 0
                            ]);
                        }
                    }
                }
            }
        });
    }

    public static function hitungMDR($nominal_bayar, $mdr){
        $mdrCount = $mdr/100;
        $nominal_mdr = $nominal_bayar*$mdrCount;
        return $nominal_mdr;
    }
}
