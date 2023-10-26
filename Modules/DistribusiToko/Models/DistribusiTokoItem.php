<?php

namespace Modules\DistribusiToko\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DistribusiTokoItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];
    protected $table = 'dist_toko_items';
    
    protected static function newFactory()
    {
        return \Modules\DistribusiToko\Database\factories\DistribusiTokoItemFactory::new();
    }

    public function karat(){
        return $this->belongsTo(Karat::class);
    }
}
