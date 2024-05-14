<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\TenantField;

class InvoiceField extends Model {
    use HasFactory;

    protected $guarded = [];

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'id_invoice', 'id');
    }
}
