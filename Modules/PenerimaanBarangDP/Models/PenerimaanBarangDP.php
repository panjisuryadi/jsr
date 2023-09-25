<?php

namespace Modules\PenerimaanBarangDP\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cabang\Models\Cabang;
use Modules\Karat\Models\Karat;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

//use Modules\JenisGroup\Models\JenisGroup;
class PenerimaanBarangDP extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'penerimaanbarangdps';
    // protected $fillable = [
    //     'name',
    //    // 'image',
    //    // 'code',
    //     'description',
    //     'start_date',
    //     'end_date',

    //  ];
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

  //   public function kategoriProduk() {
  //       return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id', 'id');
  //   }

    protected static function newFactory()
    {
        return \Modules\PenerimaanBarangDP\database\factories\PenerimaanBarangDPFactory::new();
    }

    public function payment(){
      return $this->hasOne(PenerimaanBarangDPPayment::class,'penerimaan_barang_dp_id','id');
    }

    public function karat(){
      return $this->belongsTo(Karat::class);
    }

    public function cabang(){
      return $this->belongsTo(Cabang::class);
    }

}
