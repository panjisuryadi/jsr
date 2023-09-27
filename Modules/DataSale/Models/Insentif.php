<?php

namespace Modules\DataSale\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class Insentif extends Model
{
    use HasFactory;
    protected $table = 'datasales_insentif';
   
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\DataSale\database\factories\DataSaleFactory::new();
    }

}
