<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Withdrawal;
use App\Models\BiayaAdminTransferDana;

class DetailPenarikan extends Model {
    use HasFactory;

    protected $guarded = [];

    public function withdraw() {
        return $this->belongsTo(Withdrawal::class, 'id_penarikan', 'id');
    }

    public function insentif() {
        return $this->belongsTo(BiayaAdminTransferDana::class, 'id_insentif', 'id');
    }
}
