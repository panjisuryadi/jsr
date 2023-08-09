<?php

namespace Modules\GoodsReceipt\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class GoodsReceipt extends Model
{
    use HasFactory;
    protected $table = 'goodsreceipts';
    protected $guarded = [];
    public const GRCODE = 'PO';

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

  //   public function kategoriProduk() {
  //       return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
  //   }


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
