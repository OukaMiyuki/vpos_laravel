<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Withdrawal;

class NobuWithdrawFeeHistory extends Model {
    use HasFactory;

    protected $guarded = [];

    public function withdraw() {
        return $this->belongsTo(Withdrawal::class, 'id_penarikan', 'id');
    }
}
