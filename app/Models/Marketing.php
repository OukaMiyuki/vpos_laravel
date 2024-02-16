<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\DetailMarketing;

class Marketing extends Authenticatable {
    use HasApiTokens, HasFactory;

    protected $guard = 'marketing';

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
        return $this->hasOne(Marketing::class, 'id_marketing', 'id');
    }

    public function detailMarketingStore($model){
        $DetailMarketing = new DetailMarketing();
        $DetailMarketing->id_marketing = $model->id;
        $DetailMarketing->no_ktp = request()->no_ktp;
        $DetailMarketing->tempat_lahir = request()->tempat_lahir;
        $DetailMarketing->tanggal_lahir = request()->tanggal_lahir;
        $DetailMarketing->jenis_kelamin = request()->jenis_kelamin;
        $DetailMarketing->alamat = request()->alamat;
        $DetailMarketing->save();
    }
}
