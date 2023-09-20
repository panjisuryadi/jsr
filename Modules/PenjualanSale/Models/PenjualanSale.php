<?php

namespace Modules\PenjualanSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PenjualanSale\Models\PenjualanSaleDetail;
use Modules\DataSale\Models\DataSale;
class PenjualanSale extends Model
{
    use HasFactory;
   
    protected $guarded = [];

    public function detail() {
        return $this->hasMany(PenjualanSaleDetail::class, 'penjualan_sales_id', 'id');
    }

    public function sales() {
        return $this->belongsTo(DataSale::class, 'sales_id', 'id');
    }

    public function payment(){
        return $this->hasOne(PenjualanSalesPayment::class,'penjualan_sales_id','id');
    }


    protected static function newFactory()
    {
        return \Modules\PenjualanSale\database\factories\PenjualanSaleFactory::new();
    }


}
