<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kasir;
use App\Models\Invoice;
use App\Models\TenantField;

class InvoiceField extends Model {
    use HasFactory;

    protected $guarded = [];

    public function kasir(){
        return $this->belongsTo(Tenant::class, 'id_kasir', 'id');
    }

    public function invoice(){
        return $this->belongsTo(Tenant::class, 'id_invoice', 'id');
    }
    public function field(){
        return $this->belongsTo(Tenant::class, 'id_custom_field', 'id');
    }
}
