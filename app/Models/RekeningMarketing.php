<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marketing;

class RekeningMarketing extends Model {
    use HasFactory;

    protected $guarded = [];

    public function marketing(){
        return $this->belongsTo(Marketing::class, 'id_marketing', 'id');
    }
}
