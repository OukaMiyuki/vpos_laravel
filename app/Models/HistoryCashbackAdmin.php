<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class HistoryCashbackAdmin extends Model {
    use HasFactory;

    protected $guarded = [];

    public function invoice(){
        return $this->hasOne(Invoice::class, 'id_invoice', 'id');
    }
}
