<?php

namespace Modules\Reports\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetReports extends Model
{
    use HasFactory;

    protected $table = 'assets_report';

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\Reports\Database\factories\AssetReportsFactory::new();
    }
}
