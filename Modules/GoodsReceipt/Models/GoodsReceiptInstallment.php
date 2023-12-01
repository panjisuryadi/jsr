<?php

namespace Modules\GoodsReceipt\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoodsReceiptInstallment extends Model
{
    use HasFactory;

    protected $table = 'penerimaan_barang_cicilan';

    protected $fillable = [
        'payment_id',
        'nomor_cicilan',
        'tanggal_cicilan',
        'jumlah_cicilan',
        'nominal',
    ];
    
    protected static function newFactory()
    {
        return \Modules\GoodsReceipt\Database\factories\GoodsReceiptInstallmentFactory::new();
    }
}
