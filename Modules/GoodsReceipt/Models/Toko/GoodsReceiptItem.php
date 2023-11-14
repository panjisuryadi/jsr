<?php

namespace Modules\GoodsReceipt\Models\Toko;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Modules\Karat\Models\Karat;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockPending;

class GoodsReceiptItem extends Model
{

    protected $fillable = [
        'product_id',
        'cabang_id',
        'customer_id',
        'pic_id',
        'nominal',
        'note',
        'date',
        'type',
        'customer'
    ];
    protected $table = 'goodsreceipt_toko_items';

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function scopePending(){
        return $this->whereHas('product', function ($query) {
            $query->where('status_id', ProductStatus::PENDING_CABANG);
        });
    }

    public function member_customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function getTypeLabelAttribute(){
        return match($this->type){
            1 => 'barang buyback',
            2 => 'barang luar'
        };
    }

    public function getCustomerNameAttribute(){
        if(is_null($this->customer_id)){
            return $this->customer;
        }
        return $this->member_customer->customer_name;
    }

}
