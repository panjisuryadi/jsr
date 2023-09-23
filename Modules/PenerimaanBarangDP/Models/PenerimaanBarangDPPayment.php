<?php

namespace Modules\PenerimaanBarangDP\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Modules\JenisGroup\Models\JenisGroup;
class PenerimaanBarangDPPayment extends Model
{
    use HasFactory;
    protected $table = 'penerimaan_barang_dp_payment';
    protected $fillable = [
        'tipe_pembayaran',
        'lunas',
        'cicil',
        'jatuh_tempo'
    ];

  

    protected static function newFactory()
    {
        return \Modules\PenerimaanBarangDP\database\factories\PenerimaanBarangDPFactory::new();
    }

    public function penerimaan_barang_dp(){
      return $this->belongsTo(PenerimaanBarangDP::class,'penerimaan_barang_dp_id','id');
    }

}
