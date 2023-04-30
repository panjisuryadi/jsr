<?php

namespace Modules\JenisProduk\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisProduk extends Model
{
    use HasFactory;
    protected $table = 'jenisproduks';
    protected $fillable = [
        'name',
       // 'image',
        'description',
        'start_date',
        'end_date',

     ];

    protected static function newFactory()
    {
        return \Modules\JenisProduk\database\factories\JenisProdukFactory::new();
    }


}
