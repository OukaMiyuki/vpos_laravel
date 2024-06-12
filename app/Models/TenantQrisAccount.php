<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StoreDetail;
use App\Models\StoreList;

class TenantQrisAccount extends Model {
    use HasFactory;

    protected $guarded = [];

    public function storeList(){
        return $this->belongsTo(StoreList::class, 'store_identifier', 'store_identifier');
    }

    public function storeDetail(){
        return $this->belongsTo(StoreDetail::class, 'store_identifier', 'store_identifier');
    }
}
