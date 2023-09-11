<?php

namespace Modules\ReturSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\ReturSale\ReturSaleDetail;
class ReturSale extends Model
{
   
    protected $table = 'retursales';
    protected $guarded = [];

    public function returSaleDetail() {
        return $this->hasMany(ReturSaleDetail::class, 'retur_sales_id', 'id');
    }


 


}
