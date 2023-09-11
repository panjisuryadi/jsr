<?php

namespace Modules\DistribusiSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DistribusiSale\Models\DistribusiSaleDetail;
class DistribusiSale extends Model
{
    use HasFactory;
    protected $table = 'history_distribusi_sales';

    protected $guarded = [];

    public function detail() {
        return $this->hasMany(DistribusiSaleDetail::class, 'karat_id', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\DistribusiSale\database\factories\DistribusiSaleFactory::new();
    }


}
