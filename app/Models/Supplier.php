<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Model\Tenant;

class Supplier extends Model {
    use HasFactory;

    protected $fillable = [
        'id_tenant',
        'nama_supplier',
        'email_supplier',
        'phone_supplier',
        'alamat_supplier',
        'keterangan'
    ];

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id');
    }
}
