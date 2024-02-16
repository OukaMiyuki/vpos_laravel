<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kasir;

class DetailKasir extends Model {
    use HasFactory;
    protected $fillable = [
        'id_kasir',
        'no_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'photo'
    ];

    public function kasir(){
        return $this->belongsTo(Kasir::class, 'id_kasir', 'id');
    }
}
