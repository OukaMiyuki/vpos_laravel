<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;
use App\Models\Product;

class ProductCategory extends Model {
    use HasFactory;

    protected $fillable = [
        'id_tenant',
        'name',
    ];

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id');
    }

    public function product() {
        return $this->hasMany(Product::class, 'id_category', 'id');
    }
}
