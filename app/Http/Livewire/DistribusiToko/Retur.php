<?php

namespace App\Http\Livewire\DistribusiToko;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Product;

class Retur extends Component
{
    public $dist_toko;

    public $total_weight_per_karat = [];

    public function render(){
        return view("livewire.distribusi-toko.retur");
    }

    public function mount(){
        
    }
   
    public function rules()
    {
        $rules = [];

        
        return $rules;
    }

    public function submit(){
        
    }

}
