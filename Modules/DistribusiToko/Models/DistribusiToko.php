<?php

namespace Modules\DistribusiToko\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;

class DistribusiToko extends Model
{
    use HasFactory;
    protected $table = 'history_distribusi_toko';
    protected $guarded = [];

    public function cabang() {
        return $this->belongsTo(Cabang::class, 'cabang_id', 'id');
    } 

    public function karat() {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\DistribusiToko\database\factories\DistribusiTokoFactory::new();
    }

    public function items(){
        return $this->hasMany(DistribusiTokoItem::class,'dist_toko_id','id');
    }

    public function statuses(){
        return $this->belongsToMany(DistribusiTokoStatus::class,'distribusi_toko_tracking_statuses','dist_toko_id','status_id');
    }

    public function current_status(){
        return $this->statuses()->latest('date')->first();
    }

    public function setAsDraft($note = null){
        $this->statuses()->attach(1,[
            'pic_id'=> auth()->id(),
            'note' => $note,
            'date' => now()
        ]);
    }

    public function isDraft(){
        return $this->current_status()->id == 1;
    }

    public function setInProgress($note = null){
        $this->statuses()->attach(2,[
            'pic_id'=> auth()->id(),
            'note' => $note,
            'date' => now()
        ]);
    }

}
