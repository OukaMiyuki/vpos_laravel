<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use App\Models\category_product;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'batch_code',
        'product_code',
        'product_name',
        'id_supplier',
        'photo',
        'nomor_gudang',
        'nomor_rak',
        'tanggal_beli',
        'tanggal_expired',
        'harga_beli',
        'harga_jual'
    ];

    public function category() {
        return $this->belongsToMany(ProductCategory::class, 'product_id', 'category_id')->using(category_product::class)->withTimestamps();
    }
}
