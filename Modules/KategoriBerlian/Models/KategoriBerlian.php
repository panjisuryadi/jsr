<?php

namespace Modules\KategoriBerlian\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriBerlian extends Model
{
    use HasFactory;
    protected $table = 'kategoriberlians';
    protected $fillable = [
        'name',
       // 'image',
        'description',
        'start_date',
        'end_date',

     ];

    protected static function newFactory()
    {
        return \Modules\KategoriBerlian\database\factories\KategoriBerlianFactory::new();
    }


}
