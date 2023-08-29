<?php

namespace Modules\GoodsReceipt\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\GoodsReceipt\Models\GoodsReceipt;


class TipePembelian extends Model
{

    protected $table = 'tipe_pembelian';
    protected $guarded = [];


    public function pembelian() {
        return $this->belongsTo(GoodsReceipt::class, 'goodsreceipt_id', 'id');
    }

}
