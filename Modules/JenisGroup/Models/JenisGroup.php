<?php

namespace Modules\JenisGroup\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisGroup extends Model
{
    use HasFactory;
    protected $table = 'jenisgroups';
    // protected $fillable = [
    //     'name',
    //    // 'image',
    //    // 'code',
    //     'description',
    //     'start_date',
    //     'end_date',

    //  ];
    protected $guarded = [];
    protected static function newFactory()
    {
        return \Modules\JenisGroup\database\factories\JenisGroupFactory::new();
    }


}
