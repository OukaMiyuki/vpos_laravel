<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;

class DetailTenant extends Model {
    use HasFactory;
    protected $fillable = [
        'id_tenant',
        'email',
        'no_ktp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'photo'
    ];
    
    public function tenant(){
        return $this->belongsTo(Tenant::class, 'id_tenant', 'id');
    }
}
