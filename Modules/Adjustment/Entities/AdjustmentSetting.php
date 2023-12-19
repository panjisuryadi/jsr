<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdjustmentSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    const LOCATION = [
        "1" => "Stok Gudang (Office)",
        "2" => "Stok Sales (Office)",
        "3" => "Stok Pending (Office)",
        "4" => "Stok Kroom (Office)",
        "5" => "Stok DP (Cabang)",
        "6" => "Stok Pending (Cabang)",
        "7" => "Stok (Cabang)",
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('socabang', function (Builder $builder) {
        
            $cabang = null;
            if(auth()->user()->isUserCabang()){
                $cabang = auth()->user()->namacabang()->id;
            }
            $builder->where(
                [
                    'cabang_id' => $cabang,
                    'created_by' => auth()->user()->id,
                    'status' => 1
                ]);
        });
    }
    
    protected static function newFactory()
    {
        return \Modules\Adjustment\Database\factories\AdjustmentSettingFactory::new();
    }

    public static function stop(){
        self::first()->delete();
    }
}
