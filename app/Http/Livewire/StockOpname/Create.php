<?php

namespace App\Http\Livewire\StockOpname;

use Livewire\Component;
use Modules\Karat\Models\Karat;

class Create extends Component
{
    public $active_location;

    protected $listeners = [
        'save'
     ];

     public $adjustment_items = [

     ];

     public function save($data){
        $this->adjustment_items[] = [
            "karat" => Karat::find($data['product']['karat_id']),
            "stock_data" => $data['product']['berat_real'],
            "stock_rill" => $data['stock_rill']
        ];
     }
    public function render(){
        return view('livewire.stock-opname.create');
    }
}
