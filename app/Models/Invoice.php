<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\ShoppingCart;
use App\Models\Kasir;
use App\Models\Tenant;

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
        }
        session()->forget('cart'); 
    }
}
