<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdjustmentSetting extends Model
{
    use HasFactory;

    protected $fillable = [];

    const LOCATION = [
        "1" => "Stok Gudang (Office)",
        "2" => "Stok Sales (Office)",
        "3" => "Stok Pending (Office)",
        "4" => "Stok Kroom (Office)",
        "5" => "Stok DP (Cabang)",
        "6" => "Stok Pending (Cabang)",
        "7" => "Stok (Cabang)",
    ];
    
    protected static function newFactory()
    {
        return \Modules\Adjustment\Database\factories\AdjustmentSettingFactory::new();
    }

    public static function stop(){
        self::first()->delete();
    }
}
