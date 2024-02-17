<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marketing;

class InvitationCode extends Model {
    use HasFactory;

    protected $fillable = [
        'id_marketing',
        'inv_code',
        'holder',
        'attempt',
        'is_active'
    ];

    public function marketing(){
        return $this->belongsTo(Marketing::class, 'id_marketing', 'id');
    }
}
