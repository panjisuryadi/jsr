<?php

namespace Modules\ReturSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
class ReturSale extends Model
{
   
    protected $table = 'retursales';
    protected $guarded = [];

    public function detail() {
        return $this->hasMany(ReturSaleDetail::class, 'retur_sales_id', 'id');
    }


 


}
