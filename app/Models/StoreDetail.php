<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;


class StoreDetail extends Model {
    use HasFactory;

    protected $fillable = [
        'id_tenant',
        'name',
        'alamat',
        'jenis_usaha',
        'status_umi',
        'photo'
    ];

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id');
    }
}
