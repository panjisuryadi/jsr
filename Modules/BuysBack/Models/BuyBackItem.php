<?php

namespace Modules\BuysBack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stok\Models\StockPending;

class BuyBackItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'cabang_id',
        'customer_id',
        'status_id',
        'karat_id',
        'pic_id',
        'nominal',
        'note',
        'weight',
        'date'
    ];

    protected $table = 'buyback_item';
    
    protected static function newFactory()
    {
        return \Modules\BuysBack\Database\factories\BuyBackItemFactory::new();
    }

    public function stock_pending()
    {
        return $this->morphToMany(StockPending::class, 'transaction','stock_pending_history','transaction_id','stock_pending_id','id','id')->withTimestamps();
    }
}
