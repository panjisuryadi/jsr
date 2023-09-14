<?php

namespace Modules\Karat\Models;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Stok\Models\StockOffice;

class Karat extends Model
{
    use HasFactory;
    protected $table = 'karats';
    protected $fillable = [
        'name',
        'kode',
        'description',
        'start_date',
        'end_date',

     ];

    protected static function newFactory()
    {
        return \Modules\Karat\database\factories\KaratFactory::new();
    }

    public function stockOffice(){
        return $this->hasOne(StockOffice::class,'karat_id','id');
    }


}
