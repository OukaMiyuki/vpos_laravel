<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart;

class Invoice extends Model {
    use HasFactory;

    protected $guarded = [];

    public function storeCart($model){
        $cartId = 'cart-'.$model->id;
        $cart =  Cart::instance($cartId)->store(auth()->user()->id);
        // session()->forget('cart'); 
    }
}
