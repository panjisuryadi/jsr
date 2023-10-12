<?php

namespace App\Http\Livewire\StockOpname;

use Livewire\Component;

class Create extends Component
{
    public $active_location;
    public function render(){
        return view('livewire.stock-opname.create');
    }
}
