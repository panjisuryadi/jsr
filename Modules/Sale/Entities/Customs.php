<?php

namespace Modules\Sale\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customs extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'customs';
}
