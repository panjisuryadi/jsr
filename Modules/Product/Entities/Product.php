<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Notifications\NotifyQuantityAlert;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Modules\Product\Entities\ProductLocation;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\Cabang\Models\Cabang;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\Product\Models\ProductAccessories;
use Modules\Product\Models\ProductStatus;
use Modules\Product\Models\ProductTrackingHistory;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\Produksi\Models\Accessories;
use Modules\Stok\Models\StockOffice;

class Product extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    protected $with = ['media','karat'];

   public const PRODUKCODE = 'JSR';
   public const URL = 'P';

   protected static function booted(){
    parent::booted();
    static::creating(function(Product $product){
        if(empty($product->product_code)){
            $product->product_code = self::generateCode();
        }
    });
   }


   public function scopeCabang(){
        $user = auth()->user();
        $cabang_id = $user->namacabang()->id;
        static::addGlobalScope('filter_by_cabang', function (Builder $builder) use ($cabang_id) {
            $builder->where('cabang_id', $cabang_id);
        });
   }
  public function product_item() {
        return $this->hasOne(ProductItem::class, 'product_id', 'id');
    }

    public function scopeAkses($query)
    {

        if(auth()->user()->isUserCabang()){
            return $query->where('cabang_id', '=', Auth::user()->namacabang()->id);
        }
    }


    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function pembelian() {
        return $this->belongsTo(GoodsReceipt::class, 'goodsreceipt_id', 'id');
    }

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
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
            $date = now()->format('dmY');
            $produk_code = !empty(env('PRODUCT_CODE')) ? env('PRODUCT_CODE') : self::PRODUKCODE;
            $dateCode = $produk_code . $date;
            $lastOrder = self::select([DB::raw('MAX(products.product_code) AS last_code')])
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

       public function karat(){
        return $this->belongsTo(Karat::class,'karat_id');
       }

       public function statuses(){
        return $this->belongsToMany(ProductStatus::class,'product_tracking_history','product_id','status_id')->using(ProductTrackingHistory::class)->withTimestamps()->withPivot('cabang_id','properties');
       }

       public function current_status(){
        return $this->belongsTo(ProductStatus::class,'status_id');
       }

       public function group(){
        return $this->belongsTo(Group::class);
       }

       public function model(){
        return $this->belongsTo(ProdukModel::class,'model_id');
       }

       public function getProductNameAttribute($value){
        $product_name = $value;
        if(empty($value)){
            $product_name = $this->group?->name . ' ' . $this->model?->name;
        }
        return $product_name;
       }


       public function updateTracking($status_id, $cabang_id = null){
            $this->update([
                'cabang_id' => $cabang_id,
                'status_id' => $status_id
            ]);
            $this->refresh();
            $this->statuses()->attach($this->status_id,['cabang_id' => $this->cabang_id, 'properties' => json_encode(['product'=>$this])]);
       }

       public function scopePending($query){
            return $this->where('status_id', ProductStatus::PENDING_CABANG);
       }

       public function scopeCuci($query){
        return $this->where('status_id', ProductStatus::CUCI);
        }

        public function scopeMasak($query){
            return $this->where('status_id', ProductStatus::MASAK);
        }

        public function scopeRongsok($query){
            $query->where('status_id', ProductStatus::RONGSOK);
        }

        public function scopeReparasi($query){
            $query->where('status_id', ProductStatus::REPARASI);
        }

        public function scopeSecond($query){
            $query->where('status_id', ProductStatus::SECOND);
        }

       public function scopePendingOffice($query){
        return $this->where('status_id', ProductStatus::PENDING_OFFICE);
        }

        public function scopeReadyOffice($query){
            $query->where('status_id', ProductStatus::READY_OFFICE);
        }

        public function scopeReady($query){
            $query->where('status_id', ProductStatus::READY);
            if(auth()->user()->isUserCabang()){
                $query->where('cabang_id',auth()->user()->namacabang()->id);
            }
        }

       public function getImageUrlPathAttribute(){
            $image = $this->images;
            if(empty($image)){
                return url('images/fallback_product_image.png');
            }else{
                return asset(imageUrl().$image);
            }
       }


    public function stock_office()
    {
        return $this->morphToMany(StockOffice::class, 'transaction','stock_office_history','transaction_id','stock_office_id','id','id')->withTimestamps();
    }

    public function product_status(){
        return $this->belongsTo(ProductStatus::class,'status_id','id');
    }

    public function product_accessories(){
        return $this->hasMany(ProductAccessories::class,'product_id');
    }

    public function getBerlianShortLabelAttribute(){
        $query = $this->product_accessories()->whereRelation('accessories','type',Accessories::BERLIAN_TYPE);
        if($query->count()){
            return 'Berlian ' . $query->sum('amount') . ' ' . $query->first()->accessories->satuan->code;
        }
    }

}
