<?php

namespace Modules\DistribusiSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Model\Karat;
use Modules\DistribusiSale\Models\DistribusiSale;
class DistribusiSaleDetail extends Model
{
    use HasFactory;
    protected $table = 'distribusi_sales_detail';

    protected $guarded = [];

    public function distribusi_sales() {
        return $this->belongsTo(DistribusiSale::class, 'distribusi_sales_id', 'id');
    } 

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\DistribusiSale\database\factories\DistribusiSaleFactory::new();
    }


}
