<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kasir;
use App\Models\Invoice;

class CustomerIdentifier extends Model {
    use HasFactory;

    protected $guarded = [];

    public function kasir(){
        return $this->belongsTo(Kasir::class, 'id_kasir', 'id');
    }

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'id_invoice', 'id');
    }
}
