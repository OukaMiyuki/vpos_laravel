<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart;
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

    public function storeCart($model){
        $cartContent = Cart::content();
        foreach($cartContent as $cart){
            ShoppingCart::create([
                'id_invoice' => $model->id,
                'id_product' => $cart->id,
                'product_name' => $cart->name,
                'qty' =>$cart->qty,
                'harga' => $cart->price,
                'sub_total' => $cart->price*$cart->qty
            ]);
            $stock = ProductStock::find($cart->id);
            $updateStok = (int) $stock->stok - (int) $cart->qty;
            $stock->update([
                'stok' => $updateStok
            ]);
        }
    }

    public function fieldSave($model){
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
            $date = date('dmYHis');
            $index_number = Invoice::max('id') + 1;
            $generate_nomor_invoice = $invoice_code.$date.str_pad($index_number, 9, '0', STR_PAD_LEFT);
            $model->nomor_invoice = $generate_nomor_invoice;
            $tenant = Tenant::select(['id_inv_code'])->find($model->id_tenant);
            if($model->jenis_pembayaran == "Qris"){
                if($tenant->id_inv_code != 0){
                    $storeDetail = StoreDetail::select(['status_umi'])->where('store_identifier', $model->store_identifier)->first();
                    if($storeDetail->status_umi == 1){
                        if($model->nominal_bayar <= 100000){
                            $model->mdr = 0;
                            $model->nominal_mdr = 0;
                            $model->nominal_terima_bersih = $model->nominal_bayar;
                        } else {
                            $nominal_mdr = self::hitungMDR($model->nominal_bayar);
                            $model->nominal_mdr = $nominal_mdr;
                            $model->nominal_terima_bersih = $model->nominal_bayar-$nominal_mdr;
                        }   
                    } else {
                        $nominal_mdr = self::hitungMDR($model->nominal_bayar);
                        $model->nominal_mdr = $nominal_mdr;
                        $model->nominal_terima_bersih = $model->nominal_bayar-$nominal_mdr;
                    }
                    try {
                        $postResponse = $client->request('POST',  $url, [
                            'form_params' => [
                                'amount' => $model->nominal_bayar,
                                'transactionNo' => $generate_nomor_invoice,
                                'pos_id' => "VP",
                                'secret_key' => "Vpos71237577"
                            ]
                        ]);
                        $responseCode = $postResponse->getStatusCode();
                        $data = json_decode($postResponse->getBody());
                        $model->qris_data = $data->data->data->qrisData;
                    } catch (Exception $e) {
                        return $e;
                        exit;
                    }
                } else if($tenant->id_inv_code == 0) {
                    $store = StoreList::select(['status_umi'])->where('store_identifier', $model->store_identifier)->first();
                    if($store->status_umi == 1) {
                        if($model->nominal_bayar <= 100000){
                            $model->mdr = 0;
                            $model->nominal_mdr = 0;
                            $model->nominal_terima_bersih = $model->nominal_bayar;
                        } else {
                            $nominal_mdr = self::hitungMDR($model->nominal_bayar);
                            $model->nominal_mdr = $nominal_mdr;
                            $model->nominal_terima_bersih = $model->nominal_bayar-$nominal_mdr;
                        }
                    } else {
                        $nominal_mdr = self::hitungMDR($model->nominal_bayar);
                        $model->nominal_mdr = $nominal_mdr;
                        $model->nominal_terima_bersih = $model->nominal_bayar-$nominal_mdr;
                    }
                }
            }
        });
    }

    public static function hitungMDR($nominal_bayar){
        $nominal_mdr = $nominal_bayar*0.007;
        return $nominal_mdr;
    }
}
