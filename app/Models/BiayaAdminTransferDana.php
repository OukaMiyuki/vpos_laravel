<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailPenarikan;

class BiayaAdminTransferDana extends Model {
    use HasFactory;
    protected $guarded = [];

    public function detailWithdraw(){
        return $this->hasMany(DetailPenarikan::class, 'id_insentif', 'id');
    }
}
