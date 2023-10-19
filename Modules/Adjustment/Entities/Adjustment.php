<?php

namespace Modules\Adjustment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Modules\Locations\Entities\AdjustedLocations;
use Modules\Locations\Entities\Locations;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockPendingOffice;
use Modules\Stok\Models\StockSales;

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

    public function stockOffice()
    {
        return $this->morphedByMany(StockOffice::class, 'location', 'adjustment_location','adjustment_id','location_id','id','id')->withTimestamps()->withPivot('weight_before', 'weight_after');
    }

    public function products(){
        return $this->hasMany(AdjustmentLocation::class,'adjustment_id');
    }

    public function location(){
        return $this->hasOne(AdjustmentLocation::class, 'adjustment_id');
    }

    public function stockSales()
    {
        return $this->morphedByMany(StockSales::class, 'location', 'adjustment_location','adjustment_id','location_id','id','id')->withTimestamps()->withPivot('weight_before', 'weight_after');
    }

    public function stockPendingOffice(){
        return $this->morphedByMany(StockPendingOffice::class, 'location', 'adjustment_location','adjustment_id','location_id','id','id')->withTimestamps()->withPivot('weight_before', 'weight_after');
    }


}
