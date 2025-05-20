<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;
    protected $table = 'stock_opname';
    protected $fillable = [
        'status',
    ];

    public static function check_opname()
    {
        $stock  = self::latest()->first();
        return $stock->status; // or StockOpname::latest()->get();
    }
}
