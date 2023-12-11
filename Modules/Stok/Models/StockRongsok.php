<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockRongsok extends Model
{
    use HasFactory;

    protected $fillable = [
        'karat_id',
        'weight'
    ];

    protected $table = 'stock_rongsok';
    
    protected static function newFactory()
    {
        return \Modules\Stok\Database\factories\StockRongsokFactory::new();
    }
}
