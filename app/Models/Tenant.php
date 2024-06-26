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
use App\Models\Rekening;
use App\Models\QrisWallet;
use App\Models\QrisWalletPending;
use App\Models\UmiRequest;
use App\Models\Withdrawal;
use App\Models\DetailPenarikan;
use App\Models\StoreList;
use App\Models\TenantQrisAccount;

class Tenant extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'tenant';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'phone_number_verified_at',
        'password',
        'id_inv_code',
        'is_active',
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

    public function storeList(){
        return $this->hasMany(StoreList::class, 'id_user', 'id');
    }

    // public function umi(){
    //     return $this->hasMany(UmiRequest::class, 'id_tenant', 'id');
    // }

    public function invoiceStoreList(){
        return $this->hasManyThrough(
            Invoice::class,
            StoreList::class,
            'store_lists.id_user',
            'invoices.store_identifier',
            'tenants.id',
            'store_lists.id'
        );
    }

    public function invoiceStoreDetail(){
        return $this->hasManyThrough(
            Invoice::class,
            StoreDetail::class,
            'id_tenant',
            'store_identifier',
            'id',
            'id'
        );
    }

    public function invoice(){
        return $this->hasMany(Invoice::class, 'id_tenant', 'id');
    }

    public function withdrawal(){
        return $this->hasMany(Withdrawal::class, 'email', 'email');
    }


    public function storeListUMI(){
        return $this->hasManyThrough(
            UmiRequest::class,
            StoreList::class,
            'id_user',
            'store_identifier',
            'id',
            'store_identifier'
        );
    }

    public function storeDetailUMI(){
        return $this->hasManyThrough(
            UmiRequest::class,
            StoreDetail::class,
            'id_tenant',
            'store_identifier',
            'id',
            'store_identifier'
        );
    }

    public function tenantQrisAccountStoreList(){
        return $this->hasManyThrough(
            TenantQrisAccount::class,
            StoreList::class,
            'id_user',
            'store_identifier',
            'id',
            'store_identifier'
        );
    }

    public function tenantQrisAccountStoreDetail(){
        return $this->hasManyThrough(
            TenantQrisAccount::class,
            StoreDetail::class,
            'id_tenant',
            'store_identifier',
            'id',
            'store_identifier'
        );
    }

    public function withdrawalDetail(){
        return $this->hasManyThrough(
            DetailPenarikan::class,
            Withdrawal::class,
            'id_user',
            'id_penarikan',
            'id',
            'id'
        );
    }

    public function qrisWalletPrnding(){
        return $this->hasOne(QrisWalletPending::class, 'id_user', 'id');
    }

    public function saldoTunai(){
        return $this->hasOne(TunaiWallet::class, 'id_tenant', 'id');
    }

    public function sendEmailVerificationNotification() {
        $this->notify(new EmailVerificationNotification);
    }

    public function detailTenantStore($model){
        $DetailTenant = new DetailTenant();
        $DetailTenant->id_tenant = $model->id;
        $DetailTenant->email = $model->email;
        $DetailTenant->no_ktp = request()->no_ktp;
        $DetailTenant->tempat_lahir = request()->tempat_lahir;
        $DetailTenant->tanggal_lahir = request()->tanggal_lahir;
        $DetailTenant->jenis_kelamin = request()->jenis_kelamin;
        $DetailTenant->alamat = request()->alamat;
        $DetailTenant->save();
        if($model->id_inv_code != 0){
            $model->is_active = 1;
            $model->save();
        }

    }

    public function storeInsert($model, $randomString){
        $StoreDetail = new StoreDetail();
        $tax = new Tax();
        $discount = new Discount();
        $StoreDetail->store_identifier = $randomString;
        $StoreDetail->id_tenant = $model->id;
        $StoreDetail->email = $model->email;
        $StoreDetail->save();
        $tax->store_identifier = $randomString;
        $tax->save();
        $discount->store_identifier = $randomString;
        $discount->save();
    }

    public function fieldInsert($randomString){
        $TenantField = new TenantField();
        $TenantField->store_identifier = $randomString;
        $TenantField->baris1 = "Nama Pelanggan";
        $TenantField->baris2 = "Kota Asal";
        $TenantField->baris3 = "Alamat Pelanggan";
        $TenantField->baris4 = "Email Pelanggan";
        $TenantField->baris5 = "No. Telp./WA";
        $TenantField->baris_1_activation = 1;
        $TenantField->baris_2_activation = 1;
        $TenantField->baris_3_activation = 1;
        $TenantField->baris_4_activation = 1;
        $TenantField->baris_5_activation = 1;
        $TenantField->save();
    }

    public function createWallet($model){
        $tunaiWallet = new TunaiWallet();
        $rekening = new Rekening();
        $qrisWallet = new QrisWallet();
        $qrisPendingWallet = new QrisWalletPending();
        $tunaiWallet->id_tenant = $model->id;
        $tunaiWallet->email = $model->email;
        $tunaiWallet->saldo = 0;
        $tunaiWallet->save();
        $rekening->id_user = $model->id;
        $rekening->email = $model->email;
        $rekening->save();
        $qrisPendingWallet->id_user = $model->id;
        $qrisPendingWallet->email = $model->email;
        $qrisPendingWallet->saldo = 0;
        $qrisPendingWallet->save();
        $qrisWallet->id_user = $model->id;
        $qrisWallet->email = $model->email;
        $qrisWallet->saldo = 0;
        $qrisWallet->save();
    }
}
