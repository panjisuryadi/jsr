<?php

namespace Modules\PenerimaanBarangLuar\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cabang\Models\Cabang;
//use Modules\JenisGroup\Models\JenisGroup;
use Modules\Karat\Models\Karat;
class PenerimaanBarangLuar extends Model
{
    use HasFactory;
    protected $table = 'penerimaanbarangluars';
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
        return \Modules\PenerimaanBarangLuar\database\factories\PenerimaanBarangLuarFactory::new();
    }
    public function karat(){
      return $this->belongsTo(Karat::class);    
    }

    public function cabang(){
      return $this->belongsTo(Cabang::class);
    }


}
