<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;

class TunaiWallet extends Model {
    use HasFactory;

    protected $guarded = [];

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id');
    }
}
