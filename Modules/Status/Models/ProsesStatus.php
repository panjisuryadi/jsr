<?php

namespace Modules\Status\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BuysBack\Models\BuysBack;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar;

class ProsesStatus extends Model
{
    use HasFactory;

    protected $table = 'proses_statuses';

    protected $fillable = [
        'name'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Status\Database\factories\ProsesStatusFactory::new();
    }

    public function buybacks(){
        return $this->belongsToMany(BuysBack::class, 'buyback_statuses','status_id','buyback_id');
    }

    public function barangluar(){
        return $this->belongsToMany(PenerimaanBarangLuar::class, 'barangluar_statuses','status_id','barangluar_id');
    }
}
