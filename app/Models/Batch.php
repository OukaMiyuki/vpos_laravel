<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\StoreDetail;

class Batch extends Model {
    use HasFactory;

    protected $fillable = [
        'store_identifier',
        'batch_code',
        'keterangan'
    ];

    public function store(){
        return $this->belongsTo(StoreDetail::class, 'store_identifier', 'store_identifier');
    }

    public function product() {
        return $this->hasMany(Product::class, 'id_batch', 'id');
    }
}
