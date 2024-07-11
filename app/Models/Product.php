<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use App\Models\Batch;
use App\Models\ProductStock;
use App\Models\StoreDetail;
use App\Models\Supplier;
use App\Models\ShoppingCart;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'store_identifier',
        'id_batch',
        'id_category',
        'index_number',
        'product_code',
        'product_name',
        'id_supplier',
        'photo',
        'nomor_gudang',
        'nomor_rak',
        'harga_jual',
        'tipe_barang',
        'satuan_barang',
        'satuan_unit'
    ];

    public function store() {
        return $this->belongsTo(StoreDetail::class, 'store_identifier', 'store_identifier');
    }
    
    
    public function supplier() {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }

    public function batch() {
        return $this->belongsTo(Batch::class, 'id_batch', 'id');
    }

    public function category() {
        return $this->belongsTo(ProductCategory::class, 'id_category', 'id');
    }

    public function productStock() {
        return $this->hasMany(ProductStock::class, 'id_batch_product', 'id');
    }

    public function shoppingCart() {
        return $this->hasMany(ShoppingCart::class, 'id_product', 'id');
    }

    public static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->index_number = Product::where('store_identifier', $model->store_identifier)
                                            ->where('id_batch', $model->id_batch)->max('index_number') + 1;
            $model->product_code = $model->batch->batch_code.'-'.str_pad($model->index_number, 6, '0', STR_PAD_LEFT);
        });
    }
}
