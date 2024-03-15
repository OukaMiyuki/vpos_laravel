<?php

namespace App\Http\Controllers\Auth\Kasir\Api;

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

class KasirController extends Controller {
    public function kasirPos(){
        $stock = ProductStock::with('product')
                        ->where(function ($query) {
                                $query->where('stok', '!=', 0);
                        })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        $customField = TenantField::where('id_tenant', auth()->user()->id_tenant)->first();
        $stockProduk = $stock;
        return response()->json([
            'message' => 'Fetch Success',
            'dataStokProduk' => $stockProduk,
            'customField' => $customField
        ]);
    }

    public function addCart(Request $request){
        return response()->json([
            'message' => 'Added Success',
            'data' => $request->all()
        ]);
    }
}
