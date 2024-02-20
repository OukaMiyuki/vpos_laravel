<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\Marketing\EmailVerificationNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\DetailMarketing;
use App\Models\InvitationCode;

class Marketing extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable;

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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function detail(){
        return $this->hasOne(DetailMarketing::class, 'id_marketing', 'id');
    }

    public function invitationCode(){
        return $this->hasMany(InvitationCode::class, 'id_marketing', 'id');
    }

    public function sendEmailVerificationNotification() {
        $this->notify(new EmailVerificationNotification);
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
