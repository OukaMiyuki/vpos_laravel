<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model {
    use HasFactory;

    protected $guarded = [];

    public function createHistory($model, $activity, $location, $user_ip, $user_log, $status){
        $model->action = $activity;
        $model->lokasi_anda = $location;
        $model->deteksi_ip = $user_ip;
        $model->log = $user_log;
        $model->status = $status;
        $model->save();
    }
}
