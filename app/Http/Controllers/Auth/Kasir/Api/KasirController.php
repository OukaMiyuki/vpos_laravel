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
        $caregory = $request->id_category;
        $stock = ProductStock::with('product')
                        ->where(function ($query) {
                                $query->where('stok', '!=', 0)
                                      ->where('id_category' == $request->id_category);
                        })->where('id_tenant', auth()->user()->id_tenant)->latest()->get();
        return response()->json([
            'message' => 'Fetch Success',
            'dataStokProduk' => $stock,
        ]);

    }

    public function searchProduct(Request $request) {
        // $Keyword = $request->input('Keyword');
        // $Search = $request->input('Search');
        // $categoryPost = $request->input('post_category');
        // $postAll = [];
        
        // if($Search){
        //     if($Keyword){
        //         $postAll = Blog::latest()->where('status', 1)
        //                 ->when($Keyword, function($query) use ($Keyword){
        //                     $query->where('title', 'LIKE', '%'.$Keyword.'%');
        //                 })->paginate(4);

        //     } else if($Keyword == ""){
        //         $postAll = Blog::latest()->where('status', 1)->paginate(4);
        //     }
        // } else if($categoryPost){
        //     $postAll = Blog::whereHas('category', function($q) use ($categoryPost){
        //                     $q->where('name', '=', $categoryPost);
        //                 })->where('status', 1)->paginate(4);
        // } else {
        //     $postAll = Blog::latest()->where('status', 1)->paginate(4);
        // }
        // session()->flashInput($request->input());

        // return view('welcome', compact('postAll'));
    }

    public function addCart(Request $request){
        return response()->json([
            'message' => 'Added Success',
            'data' => $request->all()
        ]);
    }
}
