<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\DetailKasir;
use App\Models\Invoice;
use App\Models\StoreDetail;

class Kasir extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'kasir';

    protected $fillable = [
        'id_store',
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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function detail(){
        return $this->hasOne(DetailKasir::class, 'id_kasir', 'id');
    }

    public function store(){
        return $this->belongsTo(StoreDetail::class, 'id_store', 'store_identifier');
    }

    public function invoice(){
        return $this->hasMany(Invoice::class, 'id_kasir', 'id');
    }

    public function detailKasirStore($model){
        $DetailKasir = new DetailKasir();
        $DetailKasir->id_kasir = $model->id;
        $DetailKasir->email = $model->email;
        $DetailKasir->no_ktp = request()->no_ktp;
        $DetailKasir->tempat_lahir = request()->tempat_lahir;
        $DetailKasir->tanggal_lahir = request()->tanggal_lahir;
        $DetailKasir->jenis_kelamin = request()->jenis_kelamin;
        $DetailKasir->alamat = request()->alamat;
        $DetailKasir->save();
    }
}
