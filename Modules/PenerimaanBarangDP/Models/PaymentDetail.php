<?php

namespace Modules\PenerimaanBarangDP\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'barangdp_payment_detail';

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\PenerimaanBarangDP\Database\factories\PaymentDetailFactory::new();
    }

    protected static function booted(){
        parent::booted();
        static::creating(function(PaymentDetail $paymentDetail){
            $paymentDetail->order_number = self::where('payment_id', $paymentDetail->payment_id)->max('order_number') + 1;
        });
    }

    public function payment(){
        return $this->belongsTo(PenerimaanBarangDPPayment::class, 'payment_id','id');
    }
}
