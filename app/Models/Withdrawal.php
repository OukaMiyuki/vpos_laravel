<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NobuWithdrawFeeHistory;
use App\Models\DetailPenarikan;

class Withdrawal extends Model {
    use HasFactory;

    protected $guarded = [];

    public function nobuFee() {
        return $this->hasMany(NobuWithdrawFeeHistory::class, 'id_penarikan', 'id');
    }

    public function detailWithdraw(){
        return $this->hasOne(DetailPenarikan::class, 'id_penarikan', 'id');
    }
}
