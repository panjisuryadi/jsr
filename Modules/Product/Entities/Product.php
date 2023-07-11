<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Notifications\NotifyQuantityAlert;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Modules\Product\Entities\ProductLocation;
class Product extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media'];



   public const PRODUKCODE = 'P';
   public const URL = 'P';


  public function product_item() {
        return $this->hasMany(ProductItem::class, 'product_id', 'id');
    }


   public function product_location() {
        return $this->hasMany(ProductLocation::class, 'product_id', 'id');
    }


    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function registerMediaCollections(): void {
        $url = url('images/fallback_product_image.png');
        $this->addMediaCollection('images')
            ->useFallbackUrl($url);
    }

    public function registerMediaConversions(Media $media = null): void {
        $this->addMediaConversion('thumb')
            ->width(50)
            ->height(50);
    }

    public function setProductCostAttribute($value) {
        $this->attributes['product_cost'] = ($value * 100);
    }

    public function getProductCostAttribute($value) {
        return ($value / 100);
    }

    public function setProductPriceAttribute($value) {
        $this->attributes['product_price'] = ($value * 100);
    }

    public function getProductPriceAttribute($value) {
        return ($value / 100);
    }


 public function scopeTemp($query)
    {
        $query->where('status', 0);
    }


 public function scopeActive($query)
    {
        $query->where('status', 1);
    }

   public function scopeNeedApprove($query)
    {
        $query->where('status', 2);
    }


     public function scopeSortir($query)
        {
          $query->where('status', 2);

        }



 public function scopeApprove($query)
    {
        $query->where('status', 3);
    }




    public static function generateCode()
        {
            $dateCode = self::PRODUKCODE . '-';
            $lastOrder = self::select([\DB::raw('MAX(products.product_code) AS last_code')])
                ->where('product_code', 'like', $dateCode . '%')
                ->first();
            $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
            $orderCode = $dateCode . '00001';
            if ($lastOrderCode) {
                $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
                $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
                $orderCode = $dateCode . $nextOrderNumber;
            }

            return $orderCode;
        }


     public function productlocation() {
        return $this->hasMany(ProductLocation::class, 'product_id');
    }







}
