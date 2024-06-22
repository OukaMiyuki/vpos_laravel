<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class HistoryCashbackPending extends Model {
    use HasFactory;
    protected $guarded = [];
    
    public function invoice(){
        return $this->belongsTo(Invoice::class, 'id_invoice', 'id');
    }
}
