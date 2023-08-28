<?php

namespace Modules\GoodsReceipt\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\GoodsReceipt\Models\GoodsReceipt;


class GoodsReceiptItem extends Model
{

    protected $table = 'goodsreceipt_items';
    protected $guarded = [];


    public function penerimaan() {
        return $this->belongsTo(GoodsReceipt::class, 'goodsreceipt_id', 'id');
    }

}
