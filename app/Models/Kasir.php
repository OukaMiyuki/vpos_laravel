<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\DetailKasir;

class Kasir extends Authenticatable {
    use HasApiTokens, HasFactory;

    protected $guard = 'kasir';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function detail(){
        return $this->hasOne(DetailKasir::class, 'id_kasir', 'id');
    }

    public function detailKasirStore($model){
        $DetailKasir = new DetailKasir();
        $DetailKasir->id_kasir = $model->id;
        $DetailKasir->no_ktp = request()->no_ktp;
        $DetailKasir->tempat_lahir = request()->tempat_lahir;
        $DetailKasir->tanggal_lahir = request()->tanggal_lahir;
        $DetailKasir->jenis_kelamin = request()->jenis_kelamin;
        $DetailKasir->alamat = request()->alamat;
        $DetailKasir->save();
    }
}
