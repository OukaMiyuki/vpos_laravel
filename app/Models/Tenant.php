<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\Tenant\EmailVerificationNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\DetailTenant;
use App\Models\StoreDetail;
use App\Models\Supplier;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Invoice;
use App\Models\InvitationCode;
use App\Models\Tax;
use App\Models\Discount;
use App\Models\TenantField;
use App\Models\TunaiWallet;
use App\Models\QrisWallet;
use App\Models\UmiRequest;

class Tenant extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'tenant';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'id_inv_code'
    ];

    protected $hidden = [
        'email',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function invitationCode(){
        return $this->belongsTo(InvitationCode::class, 'id_inv_code', 'id');
    }

    public function detail(){
        return $this->hasOne(DetailTenant::class, 'id_tenant', 'id');
    }

    public function storeDetail(){
        return $this->hasOne(StoreDetail::class, 'id_tenant', 'id');
    }

    public function umi(){
        return $this->hasOne(UmiRequest::class, 'id_tenant', 'id');
    }

    public function supplier(){
        return $this->hasMany(Supplier::class, 'id_tenant', 'id');
    }

    public function productCategory(){
        return $this->hasMany(ProductCategory::class, 'id_tenant', 'id');
    }

    public function product(){
        return $this->hasMany(Product::class, 'id_tenant', 'id');
    }

    public function productStock() {
        return $this->hasMany(ProductStock::class, 'id_tenant', 'id');
    }

    public function invoice(){
        return $this->hasMany(Invoice::class, 'id_tenant', 'id');
    }

    public function tax(){
        return $this->hasOne(Tax::class, 'id_tenant', 'id');
    }

    public function discount(){
        return $this->hasOne(Discount::class, 'id_tenant', 'id');
    }

    public function tenantField(){
        return $this->hasOne(TenantField::class, 'id_tenant', 'id');
    }

    public function saldoTunai(){
        return $this->hasOne(TunaiWallet::class, 'id_tenant', 'id');
    }

    public function saldoQris(){
        return $this->hasOne(QrisWallet::class, 'id_user', 'id');
    }

    public function sendEmailVerificationNotification() {
        $this->notify(new EmailVerificationNotification);
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

    public function storeInsert($model){
        $StoreDetail = new StoreDetail();
        $StoreDetail->id_tenant = $model->id;
        $StoreDetail->save();
    }

    public function fieldInsert($model){
        $TenantField = new TenantField();
        $TenantField->id_tenant = $model->id;
        $TenantField->baris1 = "Nama Pelanggan";
        $TenantField->baris2 = "Kota Asal";
        $TenantField->baris3 = "Alamat Pelanggan";
        $TenantField->baris4 = "Email Pelanggan";
        $TenantField->baris5 = "No. Telp./WA";
        $TenantField->baris_1_activation = 1;
        $TenantField->baris_2_activation = 2;
        $TenantField->baris_3_activation = 3;
        $TenantField->baris_4_activation = 4;
        $TenantField->baris_5_activation = 5;
        $TenantField->save();
    }

    public function createWallet($model){
        $tunaiWallet = new TunaiWallet();
        $qrisWallet = new QrisWallet();
        $tunaiWallet->id_tenant = $model->id;
        $tunaiWallet->save();
        $qrisWallet->id_tenant = $model->id;
        $qrisWallet->save();
    }
}
