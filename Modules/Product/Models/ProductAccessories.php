<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAccessories extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'product_accessories';
    
    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductAccessoriesFactory::new();
    }
}
