<?php

namespace Modules\Status\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProsesStatus extends Model
{
    use HasFactory;

    protected $table = 'proses_statuses';

    protected $fillable = [
        'name'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Status\Database\factories\ProsesStatusFactory::new();
    }
}
