<?php

namespace Modules\Stok\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Karat\Models\Karat;
//use Modules\JenisGroup\Models\JenisGroup;
class StockKroom extends Model
{

    protected $table = 'stock_kroom';

    protected $guarded = [];

   public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    } 

 

}
