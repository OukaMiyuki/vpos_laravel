<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;
use App\Models\Invoice;
use App\Models\TenantQrisAccount;
use App\Models\UmiRequest;

class StoreList extends Model {
    use HasFactory;

    protected $guarded = [];

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_user', 'id');
    }

    public function invoice(){
        return $this->hasMany(Invoice::class, 'store_identifier', 'store_identifier');
    }

    public function tenantQrisAccount(){
        return $this->hasOne(TenantQrisAccount::class, 'store_identifier', 'store_identifier');
    }

    public function reqUmi(){
        return $this->belongsTo(UmiRequest::class, 'store_identifier', 'store_identifier');
    }
}
