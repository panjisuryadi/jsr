<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductItem extends Model
{
    use HasFactory;

    //protected $fillable = [];
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductItemFactory::new();
    }

     public function products() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function gudangs() {
        return $this->belongsTo(Gudang::class, 'gudang_id', 'id');
    }
   public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

   public function baki() {
        return $this->belongsTo(Baki::class, 'baki_id', 'id');
    }

   public function etalase() {
        return $this->belongsTo(DataEtalase::class, 'etalase_id', 'id');
    }

   public function model() {
        return $this->belongsTo(DataEtalase::class, 'model_id', 'id');
    }


    public function certificates() {
        return $this->belongsTo(DiamondCertificate::class, 'certificate_id', 'id');
    }









}
