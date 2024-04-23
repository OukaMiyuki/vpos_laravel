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
        'kabupaten',
        'kode_pos',
        'no_telp_toko',
        'jenis_usaha',
        'status_umi',
        'catatan_kaki',
        'photo'
    ];

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id');
    }
}
