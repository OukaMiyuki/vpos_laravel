<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\ProductStock;

class ShoppingCart extends Model {
    use HasFactory;

    protected $guarded = [];

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'id_invoice', 'id');
    }

    public function stock(){
        return $this->belongsTo(ProductStock::class, 'id_product', 'id');
    }
}
