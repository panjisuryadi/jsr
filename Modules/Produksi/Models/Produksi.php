<?php

namespace Modules\Produksi\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;

//use Modules\JenisGroup\Models\JenisGroup;
class Produksi extends Model
{
    use HasFactory;
    protected $table = 'produksis';
    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Produksi\database\factories\ProduksiFactory::new();
    }

    public function karatasal()
    {
        return $this->belongsTo(Karat::class, 'karatasal_id', 'id');
    }

    public function karatjadi()
    {
        return $this->belongsTo(Karat::class, 'karat_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(Group::class, 'model_id', 'id');
    }


}
