<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StoreDetail;
use App\Models\Product;

class ProductCategory extends Model {
    use HasFactory;

    protected $fillable = [
        'store_identifier',
        'name',
    ];

    public function store(){
        return $this->belongsTo(StoreDetail::class, 'store_identifier', 'store_identifier');
    }

    public function product() {
        return $this->hasMany(Product::class, 'id_category', 'id');
    }
}
