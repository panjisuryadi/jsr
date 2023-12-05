<?php

namespace Modules\GoodsReceipt\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\People\Entities\Supplier;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\GoodsReceipt\Models\TipePembelian;
use App\Models\User;
use Modules\GoodsReceiptBerlian\Models\GoodsReceiptQcAttribute;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GoodsReceipt extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;
    protected $table = 'goodsreceipts';
    protected $guarded = [];
    public const GRCODE = 'PO';

  public function products() {
        return $this->hasMany(Product::class, 'goodsreceipt_id', 'id');
    }

  public function goodsreceiptitem() {
        return $this->hasMany(GoodsReceiptItem::class, 'goodsreceipt_id', 'id');
    }

    public function pembelian() {
        return $this->hasOne(TipePembelian::class, 'goodsreceipt_id', 'id');
    }

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


       public static function countProduk($code)
        {
            $inventory = self::where('code', $code)->firstOrFail();
            $inventory->count = $inventory->count + 1;
            $inventory->save();
        }


      public function scopeActive($query)
        {
            $query->where('status', 1);
        }


        public function scopeCompleted($query)
        {
            $query->where('status', 2);
        }


       public function scopeHistory($query)
        {
            $query->whereNotIn('status', [1]);


        }


        public function scopeRetur($query)
        {
            $query->where('status', 3);
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

    public function goodsReceiptQcAttribute() {
        return $this->hasMany(GoodsReceiptQcAttribute::class, 'goodsreceipt_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\GoodsReceipt\database\factories\GoodsReceiptFactory::new();
    }

    public function scopeDebts($query)
    {
        $query->whereRelation('pembelian','lunas', null)
                ->whereRelation('pembelian', 'tipe_pembayaran','!=','lunas');
    }

    public function scopeLunas($query)
    {
        $query->whereRelation('pembelian','lunas', 'lunas');
        $query->orWhere('tipe_pembayaran', 'lunas');
    }

    public function scopeLunasAtauCicil($query)
    {
        $query->orWhere('tipe_pembayaran', 'lunas');
        $query->orWhere(function($query){
            $query->where('tipe_pembayaran', 'cicil');
            $query->whereRelation('pembelian.detailCicilan', function($q) {
                $q->where('jumlah_cicilan', '!=', null);
            });
        });
    }


}
