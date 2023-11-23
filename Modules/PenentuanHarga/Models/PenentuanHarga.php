<?php

namespace Modules\PenentuanHarga\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Karat\Models\Karat;

class PenentuanHarga extends Model
{
    use HasFactory;
    protected $table = 'penentuanhargas';
    protected $guarded = [];

  // public function products() {
  //       return $this->hasMany(Product::class, 'category_id', 'id');
  //   }

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    } 
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeIsActive($query) {
        return $query->where('lock', 1);
    }


    protected static function newFactory()
    {
        return \Modules\PenentuanHarga\database\factories\PenentuanHargaFactory::new();
    }


}
