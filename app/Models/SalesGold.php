<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesGold extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomor',
        'customer',
        'products',
        'services',
        'total',
    ];
}
