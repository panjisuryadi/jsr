<?php


namespace Modules\Stok\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Karat\Models\Karat;
class StockOffice extends Model
{

    protected $table = 'stock_office';
   
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }




}
