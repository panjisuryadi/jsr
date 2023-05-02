<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductItem extends Model
{
    use HasFactory;

    //protected $fillable = [];
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductItemFactory::new();
    }

     public function products() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }









}
