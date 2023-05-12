<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdjustmentSetting extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Adjustment\Database\factories\AdjustmentSettingFactory::new();
    }
}
