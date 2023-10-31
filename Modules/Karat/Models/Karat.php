<?php

namespace Modules\Karat\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stok\Models\StockOffice;
use Modules\PenentuanHarga\Models\PenentuanHarga;
<<<<<<< Updated upstream
use Modules\Stok\Models\StockSales;

=======
>>>>>>> Stashed changes

class Karat extends Model
{
    use HasFactory;
    protected $table = 'karats';
    protected $fillable = [
        'parent_id',
        'name',
        'kode',
        'type',
        'description',
        'start_date',
        'end_date',
        'harga'
     ];

    protected static function newFactory()
    {
        return \Modules\Karat\database\factories\KaratFactory::new();
    }

    public function stockOffice(){
        return $this->hasOne(StockOffice::class,'karat_id','id');
    }

    public function parent(){
        return $this->belongsTo(Karat::class,'parent_id','id');
    }


     public function harga(){
        return $this->hasOne(PenentuanHarga::class);
    }

    public function children(){
        return $this->hasMany(Karat::class, 'parent_id');
    }

    public function penentuanHarga(){
        return $this->hasOne(PenentuanHarga::class,'karat_id','id');
    }

    public function stockSales(){
        return $this->hasOne(StockSales::class, 'karat_id','id');
    }

    public static function logam_mulia(){
        return self::where('type','LM')->firstOrFail();
    }

}
