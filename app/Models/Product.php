<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use App\Models\category_product;
use App\Models\Batch;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'id_tenant',
        'id_batch',
        'index_number',
        'product_code',
        'product_name',
        'id_supplier',
        'photo',
        'nomor_gudang',
        'nomor_rak',
        'tanggal_beli',
        'tanggal_expired',
        'harga_beli',
        'harga_jual',
        'stok'
    ];

    public function category() {
        return $this->belongsToMany(ProductCategory::class, 'product_id', 'category_id')->using(category_product::class)->withTimestamps();
    }

    public function batch() {
        return $this->belongsTo(Batch::class, 'id_batch', 'id');
    }

    public static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->index_number = Product::where('id_tenant', auth()->user()->id)
                                            ->where('id_batch', $model->id_batch)->max('index_number') + 1;
            $model->product_code = $model->batch->batch_code.'-'.str_pad($model->index_number, 6, '0', STR_PAD_LEFT);
        });
    }
}
