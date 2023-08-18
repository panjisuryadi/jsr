<?php

namespace Modules\GoodsReceipt\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\People\Entities\Supplier;
use App\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GoodsReceipt extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;
    protected $table = 'goodsreceipts';
    protected $guarded = [];
    public const GRCODE = 'PO';

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

     public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function registerMediaCollections(): void {
            $url = url('images/fallback_product_image.png');
            $this->addMediaCollection('pembelian')
                ->useFallbackUrl($url);
        }

        public function registerMediaConversions(Media $media = null): void {
            $this->addMediaConversion('thumbnail')
                ->width(50)
                ->height(50);
        }

      public static function generateCode()
        {
            $dateCode = self::GRCODE . '-';
            $lastOrder = self::select([\DB::raw('MAX(goodsreceipts.code) AS last_code')])
                ->where('code', 'like', $dateCode . '%')
                ->first();
            $lastGrCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
            $orderCode = $dateCode . '00001';
            if ($lastGrCode) {
                $lastOrderNumber = str_replace($dateCode, '', $lastGrCode);
                $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
                $orderCode = $dateCode . $nextOrderNumber;
            }

            return $orderCode;
        }

    protected static function newFactory()
    {
        return \Modules\GoodsReceipt\database\factories\GoodsReceiptFactory::new();
    }


}
