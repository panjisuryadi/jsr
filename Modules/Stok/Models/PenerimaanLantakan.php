<?php

namespace Modules\Stok\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenerimaanLantakan extends Model
{
    use HasFactory;

    protected $table = 'penerimaanlantakan';
    
    protected $fillable = [
        'weight'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Stok\Database\factories\PenerimaanLantakanFactory::new();
    }
}
