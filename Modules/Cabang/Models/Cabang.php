<?php

namespace Modules\Cabang\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class Cabang extends Model
{
    use HasFactory;
    protected $table = 'cabangs';
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



      public function usercabang() {
        return $this->hasMany(UserCabang::class, 'user_id', 'id');
    }


    protected static function newFactory()
    {
        return \Modules\Cabang\database\factories\CabangFactory::new();
    }


}
