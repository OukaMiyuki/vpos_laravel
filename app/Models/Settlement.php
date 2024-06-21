<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SettlementHstory;

class Settlement extends Model {
    use HasFactory;

    protected $guarded = [];

    public function settlementHistory(){
        return $this->hasMany(SettlementHstory::class, 'id_settlement', 'id');
    }
}
