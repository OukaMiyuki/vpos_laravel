<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\StoreDetail;

class ProductStock extends Model {
    use HasFactory;

    protected $fillable = [
        'store_identifier',
        'id_batch_product',
        'barcode',
        'tanggal_beli',
        'tanggal_expired',
        'harga_beli',
        'stok'
    ];

    public function store() {
        return $this->belongsTo(StoreDetail::class, 'store_identifier', 'store_identifier');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_batch_product', 'id');
    }
}

