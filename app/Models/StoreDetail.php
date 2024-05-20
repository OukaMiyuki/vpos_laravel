<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;
use App\Models\Kasir;
use App\Models\Batch;
use App\Models\Supplier;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Discount;
use App\Models\Tax;
use App\Models\TenantField;
use App\Models\Invoice;
use App\Models\TenantQrisAccount;
use App\Models\UmiRequest;

class StoreDetail extends Model {
    use HasFactory;

    protected $fillable = [
        'store_identifier',
        'id_tenant',
        'email',
        'name',
        'alamat',
        'kabupaten',
        'kode_pos',
        'no_telp_toko',
        'jenis_usaha',
        'status_umi',
        'catatan_kaki',
        'photo'
    ];

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id')->where('email', auth()->user()->email);
    }

    public function batch(){
        return $this->hasMany(Batch::class, 'store_identifier', 'store_identifier');
    }

    public function supplier(){
        return $this->hasMany(Supplier::class, 'store_identifier', 'store_identifier');
    }

    public function category(){
        return $this->hasMany(ProductCategory::class, 'store_identifier', 'store_identifier');
    }

    public function product(){
        return $this->hasMany(Product::class, 'store_identifier', 'store_identifier');
    }

    public function stock(){
        return $this->hasMany(ProductStock::class, 'store_identifier', 'store_identifier');
    }

    public function discount(){
        return $this->hasOne(Discount::class, 'store_identifier', 'store_identifier');
    }

    public function tax(){
        return $this->hasOne(Tax::class, 'store_identifier', 'store_identifier');
    }

    public function tenantField(){
        return $this->hasOne(TenantField::class, 'store_identifier', 'store_identifier');
    }

    public function kasir(){
        return $this->hasMany(Kasir::class, 'id_store', 'store_identifier');
    }

    public function invoice(){
        return $this->hasMany(Invoice::class, 'store_identifier', 'store_identifier');
    }

    public function tenantQrisAccount(){
        return $this->hasOne(TenantQrisAccount::class, 'store_identifier', 'store_identifier');
    }

    public function reqUmi(){
        return $this->belongsTo(UmiRequest::class, 'store_identifier', 'store_identifier');
    }
}
