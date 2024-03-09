<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Tenant;

class ProductStock extends Model {
    use HasFactory;

    protected $fillable = [
        'id_tenant',
        'id_batch_product',
        'barcode',
        'tanggal_beli',
        'tanggal_expired',
        'harga_beli',
        'stok'
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_batch_product', 'id');
    }

    // public function productStockInsert($model){
    //     // $Product = new Product();
    //     $Product = Product::where('id_tenant', auth()->user()->id)->find($model->id_batch_product);
    //     $totalStok = $Product->stok + (int) $model->stok;
    //     $Product->update([
    //         'stok' => $totalStok
    //     ]);
    // }

    // public function productStockUpdate($model, $stok){
    //     // $Product = new Product();
    //     $Product = Product::where('id_tenant', auth()->user()->id)->find($model->id_batch_product);
    //     $totalStok = ((int)$Product->stok - (int) $stok) + (int) $model->stok;
    //     $Product->update([
    //         'stok' => $totalStok
    //     ]);
    // }

    // public function productStockDelete($model, $stok){
    //     // $Product = new Product();
    //     $Product = Product::where('id_tenant', auth()->user()->id)->find($model->id_batch_product);
    //     $totalStok = (int)$Product->stok - (int) $stok;
    //     $Product->update([
    //         'stok' => $totalStok
    //     ]);
    // }
}

