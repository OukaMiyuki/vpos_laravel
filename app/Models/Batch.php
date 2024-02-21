<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Batch extends Model {
    use HasFactory;

    protected $fillable = [
        'id_tenant',
        'batch_code',
        'keterangan'
    ];

    public function product() {
        return $this->hasMany(Product::class, 'id_batch', 'id');
    }
}
