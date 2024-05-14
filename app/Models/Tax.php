<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StoreDetail;

class Tax extends Model {
    use HasFactory;

    protected $guarded = [];

    public function store(){
        return $this->belongsTo(StoreDetail::class, 'store_identifier', 'store_identifier');
    }
}
