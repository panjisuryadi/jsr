<?php

namespace Modules\Sale\Entities;
use Modules\Cabang\Models\Cabang;
use Modules\People\Entities\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Auth;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function saleDetails() {
        return $this->hasMany(SaleDetails::class, 'sale_id', 'id');
    }

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    }
   public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

     public function scopeAkses($query)
        {

            $users = Auth::user()->id;
             if ($users == 1) {
                return $query;
            }
          //  Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->id):''

    return $query->where('cabang_id', Auth::user()->namacabang()->id);
        }




    public function salePayments() {
        return $this->hasMany(SalePayment::class, 'sale_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $number = Sale::max('id') + 1;
            $model->reference = make_reference_id('SL', $number);
        });
    }

    public function scopeCompleted($query) {
        return $query->where('status', 'Completed');
    }

    public function getShippingAmountAttribute($value) {
        return $value / 100;
    }

    public function getPaidAmountAttribute($value) {
        return $value / 100;
    }

    public function getTotalAmountAttribute($value) {
        return $value;
        //return $value / 100;
    }

    public function getDueAmountAttribute($value) {
        return $value / 100;
    }

    public function getTaxAmountAttribute($value) {
        return $value / 100;
    }

    public function getDiscountAmountAttribute($value) {
        return $value / 100;
    }

    public function getCustomerNameAttribute(){
        if(empty($this->attributes['customer_id'])){
            return "Non Member";
        }else{
            return $this->customer->customer_name;
        }
    }
}
