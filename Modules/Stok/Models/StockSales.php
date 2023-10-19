<?php

namespace Modules\Stok\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Karat\Models\Karat;
use Modules\DataSale\Models\DataSale;
class StockSales extends Model
{

    protected $table = 'stock_sales';
    protected $guarded = [];

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    } 

     public function sales() {
        return $this->belongsTo(DataSale::class, 'sales_id', 'id');
    }

    public function adjustments()
    {
        return $this->morphToMany(Adjustment::class, 'location','adjustment_location','location_id','adjustment_id','id','id');
    }


}
