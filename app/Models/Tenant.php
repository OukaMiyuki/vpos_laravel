<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\DetailTenant;

class Tenant extends Authenticatable {
    use HasApiTokens, HasFactory;

    protected $guard = 'tenant';

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
        return $this->hasOne(DetailTenant::class, 'id_tenant', 'id');
    }

    public function detailTenantStore($model){
        $DetailTenant = new DetailTenant();
        $DetailTenant->id_tenant = $model->id;
        $DetailTenant->no_ktp = request()->no_ktp;
        $DetailTenant->tempat_lahir = request()->tempat_lahir;
        $DetailTenant->tanggal_lahir = request()->tanggal_lahir;
        $DetailTenant->jenis_kelamin = request()->jenis_kelamin;
        $DetailTenant->alamat = request()->alamat;
        $DetailTenant->save();
    }
}
