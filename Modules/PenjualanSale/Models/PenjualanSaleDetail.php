<?php

namespace Modules\PenjualanSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Modules\PenjualanSale\Models\PenjualanSale;
class PenjualanSaleDetail extends Model
{
    use HasFactory;
   
    protected $guarded = [];

    protected $table = 'penjualan_sales_detail';

    public function penjualanSale() {
        return $this->belongsTo(PenjualanSale::class, 'penjualan_sales_id', 'id');
    }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\PenjualanSale\database\factories\PenjualanSaleFactory::new();
    }


}
