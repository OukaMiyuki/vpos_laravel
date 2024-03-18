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
use App\Models\ProductCategory;
use Rawilk\Printing\Receipts\ReceiptPrinter;

class KasirController extends Controller {
    public function productList(){
        $stock = ProductStock::with('product')
                        ->where(function ($query) {
                                $query->where('stok', '!=', 0);
                        })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        // $customField = TenantField::where('id_tenant', auth()->user()->id_tenant)->first();
        // $stockProduk = $stock;
        return response()->json([
            'message' => 'Fetch Success',
            'dataStokProduk' => $stock,
            // 'customField' => $customField
        ]);
    }

    public function productCategory() {
        $productCategory = ProductCategory::where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        return response()->json([
            'message' => 'Fetch Success',
            'productCategory' => $productCategory,
        ]);
    }

    public function filterCategory(Request $request){
        $category = $request->id_category;
        // $stock = ProductStock::with(['product' => function ($query) use ($category) {
        //                     $query->where('id_category', $category);
        //                 }])
        //                 ->where(function ($query){
        //                         $query->where('stok', '!=', 0);
        //                 })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        $stock = ProductStock::with('product')
                     ->whereHas('product', function($q) use($category) {
                            $q->where('id_category', $category);
                    })->where(function ($query){
                            $query->where('stok', '!=', 0);
                    })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        $message = "";
        if(!count($stock)){
            $message = "Products not found";
        } else {
            $message = "Fetch Success";
        }
        return response()->json([
            'message' => $message,
            'dataStokProduk' => $stock
        ]);

    }

    public function searchProduct(Request $request) {
        $keyword = $request->product_name;
        if($keyword){
            $stock = ProductStock::with('product')
                        ->whereHas('product', function($q) use($keyword) {
                            $q->where('product_name', 'LIKE', '%'.$keyword.'%');
                        })->where(function ($query){
                                $query->where('stok', '!=', 0);
                        })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();

            $message = "";
            
            if(!count($stock)){
                $message = "Products not found";
            } else {
                $message = "Fetch Success";
            }
            return response()->json([
                'message' => $message,
                'dataStokProduk' => $stock
            ]);
        }
    }

    public function addCart(Request $request){
        return response()->json([
            'message' => 'Added Success',
            'data' => $request->all()
        ]);
    }
}
