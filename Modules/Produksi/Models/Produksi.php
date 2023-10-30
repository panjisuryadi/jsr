<?php

namespace Modules\Produksi\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class Produksi extends Model
{
    use HasFactory;
    protected $table = 'produksis';
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Produksi\database\factories\ProduksiFactory::new();
    }


}
