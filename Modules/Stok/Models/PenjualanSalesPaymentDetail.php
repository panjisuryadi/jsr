<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanSalesPaymentDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'penjualan_sales_payment_detail';
    
    protected static function newFactory()
    {
        return \Modules\Stok\Database\factories\PenjualanSalesPaymentDetailFactory::new();
    }
}
