<?php

namespace Modules\GoodsReceipt\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\Karat\Models\Karat;
use Modules\KategoriProduk\Models\KategoriProduk;


class GoodsReceiptItem extends Model
{

    protected $table = 'goodsreceipt_items';
    protected $guarded = [];


    public function goodsreceiptitem() {
        return $this->belongsTo(GoodsReceipt::class, 'goodsreceipt_id', 'id');
    }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    } 

     public function mainkategori() {
        return $this->belongsTo(KategoriProduk::class, 'kategoriproduk_id', 'id');
    }




}
