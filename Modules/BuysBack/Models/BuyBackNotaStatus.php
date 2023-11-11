<?php

namespace Modules\BuysBack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuyBackNotaStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    const STATUS = [
        'WAITING_CONFIRMATION' => 1,
        'RETURN' => 2,
        'COMPLETED' => 3,
    ];

    protected $table = 'buyback_nota_status';
    
    protected static function newFactory()
    {
        return \Modules\BuysBack\Database\factories\BuyBackNotaStatusFactory::new();
    }
}
