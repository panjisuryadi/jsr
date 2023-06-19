<?php

namespace Modules\BuysBack\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\JenisBuyBack\Models\JenisBuyBack;
use Modules\Product\Entities\Product;
class BuysBack extends Model
{
    use HasFactory;
    protected $table = 'buysbacks';
    protected $guarded = [];


  public function buysbacksDetails() {
        return $this->hasMany(BuysBackDetails::class, 'purchase_id', 'id');
    }

 public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function jenis() {
        return $this->belongsTo(JenisBuyBack::class, 'jenis_buyback_id', 'id');
    }



    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = BuysBack::max('id') + 1;
            $model->reference = make_reference_id('PR', $number);
        });
    }

    public function scopeCompleted($query) {
        return $query->where('status', 'Completed');
    }

    public function getShippingAmountAttribute($value) {
        return $value / 100;
    }

    public function getPaidAmountAttribute($value) {
        return $value / 100;
    }

    public function getTotalAmountAttribute($value) {
        return $value / 100;
    }

    public function getDueAmountAttribute($value) {
        return $value / 100;
    }

    public function getTaxAmountAttribute($value) {
        return $value / 100;
    }

    public function getDiscountAmountAttribute($value) {
        return $value / 100;
    }























    protected static function newFactory()
    {
        return \Modules\BuysBack\database\factories\BuysBackFactory::new();
    }


}
