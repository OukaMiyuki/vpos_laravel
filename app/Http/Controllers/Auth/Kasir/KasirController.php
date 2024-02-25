<?php

namespace App\Http\Controllers\Auth\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductStock;

class KasirController extends Controller {
    public function kasirPos(){
        $stock = Product::with('productStock')->where('id_tenant', auth()->user()->id_tenant)->latest()->get();  
        dd($stock);
        // return view('kasir.kasir_pos');
    }
}
