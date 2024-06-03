<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;
use App\Models\StoreList;
use App\Models\StoreDetail;

class UmiRequest extends Model {
    use HasFactory;

    protected $guarded = [];

    // public function tenant(){
    //     return $this->belongsTo(Tenant::class, 'id_tenant', 'id');
    // }

    public function storeList(){
        return $this->belongsTo(StoreList::class, 'store_identifier', 'store_identifier');
    }

    public function storeDetail(){
        return $this->belongsTo(StoreDetail::class, 'store_identifier', 'store_identifier');
    }
}
