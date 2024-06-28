<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NobuWithdrawFeeHistory;
use App\Models\DetailPenarikan;
use App\Models\Tenant;
use App\Models\Marketing;
use App\Models\Admin;
use App\Models\Rekening;
use App\Models\RekeningAdmin;
use App\Models\RekeningWithdraw;

class Withdrawal extends Model {
    use HasFactory;

    protected $guarded = [];

    public function nobuFee() {
        return $this->hasMany(NobuWithdrawFeeHistory::class, 'id_penarikan', 'id');
    }

    public function rekening() {
        return $this->hasOne(RekeningWithdraw::class, 'id_penarikan', 'id');
    }

    public function detailWithdraw(){
        return $this->hasMany(DetailPenarikan::class, 'id_penarikan', 'id');
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'email', 'email');
    }

    public function marketing(){
        return $this->belongsTo(Marketing::class, 'email', 'email');
    }

    public function admin(){
        return $this->belongsTo(Admin::class, 'email', 'email');
    }

    public function rekUser(){
        return $this->belongsTo(Rekening::class, 'id_rekening', 'email');
    }

    public function rekAdmin(){
        return $this->belongsTo(RekeningAdmin::class, 'id_rekening', 'id');
    }

    public static function boot(){
        parent::boot();

        static::creating(function($model){
            $index_number = Withdrawal::max('id') + 1;
            $invoice_code = "VWD";
            $time=time();
            $date = date('dmYHis');
            $generate_nomor_invoice = $invoice_code.$date.str_pad($index_number, 10, '0', STR_PAD_LEFT);
            $model->invoice_pemarikan  = $generate_nomor_invoice;
        });
    }
}
