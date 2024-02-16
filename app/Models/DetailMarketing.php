<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marketing;

class DetailMarketing extends Model {
    use HasFactory;
    protected $fillable = [
        'id_marketing',
        'no_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'photo'
    ];

    public function marketing(){
        return $this->belongsTo(Marketing::class, 'id_marketing', 'id');
    }
}
