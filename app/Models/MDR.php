<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StoreDetail;
use App\Models\StoreList;

class MDR extends Model {
    use HasFactory;
    protected $guarded = [];

    public function storeList(){
        return $this->hasMany(StoreDetail::class, 'kategori_usaha_omset', 'id');
    }

    public function storeDetail(){
        return $this->hasMany(StoreList::class, 'kategori_usaha_omset', 'id');
    }
}
