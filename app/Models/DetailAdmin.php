<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;

class DetailAdmin extends Model {
    use HasFactory;
    protected $fillable = [
        'id_admin',
        'no_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'photo'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class, 'id_admin', 'id');
    }
}
