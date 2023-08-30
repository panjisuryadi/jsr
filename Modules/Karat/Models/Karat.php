<?php

namespace Modules\Karat\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karat extends Model
{
    use HasFactory;
    protected $table = 'karats';
    protected $fillable = [
        'name',
        'kode',
        'description',
        'start_date',
        'end_date',

     ];

    protected static function newFactory()
    {
        return \Modules\Karat\database\factories\KaratFactory::new();
    }


}
