<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;
use App\Models\Settlement;

class SettlementHstory extends Model {
    use HasFactory;
    protected $guarded = [];

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_user', 'id');
    }

    public function settlement(){
        return $this->belongsTo(Settlement::class, 'id_settlement', 'id');
    }

}
