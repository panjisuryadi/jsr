<?php

namespace Modules\StoreEmployee\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cabang\Models\Cabang;

//use Modules\JenisGroup\Models\JenisGroup;
class StoreEmployee extends Model
{
    use HasFactory;
    protected $table = 'storeemployees';
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
        return \Modules\StoreEmployee\database\factories\StoreEmployeeFactory::new();
    }

    public function cabang(){
        return $this->belongsTo(Cabang::class);
    }


}
