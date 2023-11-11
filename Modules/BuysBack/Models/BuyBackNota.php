<?php

namespace Modules\BuysBack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuyBackNota extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'invoice_number',
        'invoice_series',
        'date',
        'cabang_id',
        'status_id',
        'kategori_produk_id',
        'pic_id',
        'note'
    ];

    protected $table = 'buyback_nota';

    protected static function booted(): void
    {
        parent::booted();
        self::created(static function (BuyBackNota $buyback_nota) {
            $buyback_nota->statuses()->attach($buyback_nota->status_id,[
                'pic_id'=> auth()->id(),
                'note' => empty($buyback_nota->note)?null:$buyback_nota->note,
                'date' => now()
            ]);
        });
    }
    
    

    public function statuses(){
        return $this->belongsToMany(BuyBackNotaStatus::class,'buyback_nota_tracking','buyback_nota_id','status_id')->using(BuyBackNotaTracking::class)->withPivot(['pic_id','date','note']);
    }

    public function current_status(){
        return $this->belongsTo(BuyBackNotaStatus::class, 'status_id');
    }

    public function items(){
        return $this->hasMany(BuyBackItem::class,'buyback_nota_id');
    }
}
