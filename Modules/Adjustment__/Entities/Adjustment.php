<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Locations\Entities\AdjustedLocations;
use Modules\Locations\Entities\Locations;
class Adjustment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDateAttribute($value) {
        return Carbon::parse($value)->format('d M, Y');
    }

    public function adjustedProducts() {
        return $this->hasMany(AdjustedProduct::class, 'adjustment_id', 'id');
    }

 public function adjustedLocations() {
        return $this->hasMany(AdjustedLocations::class, 'adjustment_id', 'id');
    }


}
