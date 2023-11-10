<?php

namespace Modules\Produksi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KaratBerlian\Models\ShapeBerlian;

class ProduksiItems extends Model
{
    use HasFactory;

    protected $table = 'produksi_items';

    protected $fillable = ['produksis_id','karatberlians', 'qty', 'keterangan'];
    
    protected static function newFactory()
    {
        return \Modules\Produksi\Database\factories\ProduksiItemsFactory::new();
    }

    public function shape(){
        return $this->hasOne(ShapeBerlian::class, 'id', 'shapeberlian_id');
    }
}
