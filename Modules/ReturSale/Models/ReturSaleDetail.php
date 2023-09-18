<?php

namespace Modules\ReturSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Karat\Models\Karat;
use Modules\ReturSale\Models\ReturSale;
class ReturSaleDetail extends Model
{

    protected $table = 'retur_sales_detail';
    protected $guarded = [];


    public function retursales() {
        return $this->belongsTo(ReturSale::class, 'retur_sales_id', 'id');
    }

    public function karat(){
        return $this->belongsTo(Karat::class);
    }

   


}
