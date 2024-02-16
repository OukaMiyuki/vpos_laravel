<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\DetailAdmin;

class Admin extends Authenticatable {
    use HasApiTokens, HasFactory;

    protected $guard = 'admin';

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
        return $this->hasOne(DetailAdmin::class, 'id_admin', 'id');
    }

    public function detailAdminStore($model){
        $DetailAdmin = new DetailAdmin();
        $DetailAdmin->id_admin = $model->id;
        $DetailAdmin->no_ktp = request()->no_ktp;
        $DetailAdmin->tempat_lahir = request()->tempat_lahir;
        $DetailAdmin->tanggal_lahir = request()->tanggal_lahir;
        $DetailAdmin->jenis_kelamin = request()->jenis_kelamin;
        $DetailAdmin->alamat = request()->alamat;
        $DetailAdmin->save();
    }
}