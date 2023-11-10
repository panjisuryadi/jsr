<?php

namespace Modules\BuysBack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuyBackNota extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_invoice',
        'date',
        'cabang_id',
        'status_id',
        'kategori_produk_id',
        'pic_id'
    ];

    protected $table = 'buyback_nota';
    
    protected static function newFactory()
    {
        return \Modules\BuysBack\Database\factories\BuyBackNotaFactory::new();
    }
}
