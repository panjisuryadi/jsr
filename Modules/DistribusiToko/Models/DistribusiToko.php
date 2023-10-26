<?php

namespace Modules\DistribusiToko\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;

class DistribusiToko extends Model
{
    use HasFactory;
    protected $table = 'history_distribusi_toko';
    protected $guarded = [];

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    } 

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\DistribusiToko\database\factories\DistribusiTokoFactory::new();
    }

    public function items(){
        return $this->hasMany(DistribusiTokoItem::class,'dist_toko_id','id');
    }


}
