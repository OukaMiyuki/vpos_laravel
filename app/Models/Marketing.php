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
use App\Models\Tenant;
use App\Models\StoreDetail;
use App\Models\Rekening;
use App\Models\QrisWallet;
use App\Models\Withdrawal;
use App\Models\QrisWalletPending;

class Marketing extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable, \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $guard = 'marketing';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'phone_number_verified_at',
        'password',
    ];

    protected $hidden = [
        // 'email',
        'password',
        'email_verified_at',
        'remember_token',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tenantList() {
        return $this->hasManyDeep(
            StoreDetail::class,
            [InvitationCode::class, Tenant::class], // Intermediate models, beginning at the far parent (Country).
            [
               'id_marketing', // Foreign key on the "invitation code" table.
               'id_inv_code',    // Foreign key on the "tenant" table.
               'id_tenant'     // Foreign key on the "store detail" table.
            ],
            [
              'id', // Local key on the "countries" table.
              'id', // Local key on the "users" table.
              'id'  // Local key on the "posts" table.
            ]
        );
    }

    public function detail(){
        return $this->hasOne(DetailMarketing::class, 'id_marketing', 'id');
    }

    public function invitationCode(){
        return $this->hasMany(InvitationCode::class, 'id_marketing', 'id');
    }

    public function invitationCodeTenant(){
        return $this->hasManyThrough(
            Tenant::class, 
            InvitationCode::class, 
            'id_marketing', 
            'id_inv_code',
            'id',
            'id'
        );
    }

    public function withdraw(){
        return $this->hasMany(Withdrawal::class, 'email', 'email');
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

    public function createWallet($model){
        $rekening = new Rekening();
        $qrisWallet = new QrisWallet();
        $rekening->id_user = $model->id;
        $rekening->email = $model->email;
        $rekening->save();
        $qrisWallet->id_user = $model->id;
        $qrisWallet->email = $model->email;
        $qrisWallet->saldo = 0;
        $qrisWallet->save();
    }
}
