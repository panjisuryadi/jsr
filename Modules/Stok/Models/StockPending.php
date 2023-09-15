<?php

namespace Modules\Stok\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;

class StockPending extends Model
{

    protected $table = 'stock_pending';
   
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    } 

     public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }




}
