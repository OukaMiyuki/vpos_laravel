<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\ShoppingCart;
use App\Models\Kasir;
use App\Models\Tenant;
use App\Models\InvoiceField;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\TunaiWallet;
use App\Models\QrisWallet;

class Invoice extends Model {
    use HasFactory;

    protected $guarded = [];

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

    public function storeCart($model){
        $ShoppingCart = new ShoppingCart();
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
            // $stokProduct = ProductStock::with('product')->where('id_tenant', auth()->user()->id)->where('id', $cart->id)->get();
            // $totalStok = ((int) $stokProduct->product - (int) $stok) + (int) $model->stok;
            // $stokProduct->update([
            //     'stok' => $totalStok
            // ]);
        }
    }

    public function fieldSave($model){
        $content1="";
        $content2="";
        $content3="";
        $content4="";
        $content5="";
        if(!empty(request()->content1)){
            $content1 = request()->content1;
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
        $InvoiceField->id_kasir = auth()->user()->id;
        $InvoiceField->id_custom_field = auth()->user()->tenant->tenantField->id;
        $InvoiceField->content1 = $content1;
        $InvoiceField->content2 = $content2;
        $InvoiceField->content3 = $content3;
        $InvoiceField->content4 = $content4;
        $InvoiceField->content5 = $content5;
        $InvoiceField->save();
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
        $tunaiWallet = TunaiWallet::where('id_tenant', auth()->user()->id_tenant)->first();
        $totalSaldo = (int) $tunaiWallet->saldo+$total;
        $tunaiWallet->update([
            'saldo' => $totalSaldo
        ]);
    }
}
