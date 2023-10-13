<?php

namespace App\Http\Livewire\StockOpname\GudangOffice;

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

     public $selected_items = [];

     public function save($data){
        if(in_array($data['id'],$this->selected_items)){
            $this->emit('alreadySelected');
        }else{
            $this->selected_items[] = $data['id'];
            $this->adjustment_items[] = [
                "product_name" => $data['product_name'],
                "current_stock" => $data['current_stock'],
                "new_stock" => $data['new_stock']
            ];
        }
     }
    public function render(){
        return view('livewire.stock-opname.gudang-office.create');
    }

    public function remove($index){
        unset($this->selected_items[$index]);
        unset($this->adjustment_items[$index]);
    }

    
}
