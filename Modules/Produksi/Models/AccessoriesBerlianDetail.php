<?php

namespace Modules\Produksi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessoriesBerlianDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'accessories_berlian_details';
    
    protected static function newFactory()
    {
        return \Modules\Produksi\Database\factories\AccessoriesBerlianDetailFactory::new();
    }
}
