<?php

namespace Modules\Produksi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProduksiItems extends Model
{
    use HasFactory;

    protected $table = 'produksi_items';

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Produksi\Database\factories\ProduksiItemsFactory::new();
    }
}
