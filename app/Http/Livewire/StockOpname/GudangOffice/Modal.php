<?php

namespace App\Http\Livewire\StockOpname\GudangOffice;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\ProductLocation;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Locations\Entities\Locations;

class Modal extends Component
{
    public $data;
    public $key;

    public $stock_rill;

    public $active_location;
    public function render(){
        return view('livewire.stock-opname.gudang-office.modal', [
            'data' => $this->data,
        ]);
    }

    public function add(){
        $this->validate();
        $data = [
            'key' => $this->key,
            'product'=>$this->data,
            'stock_rill'=>$this->stock_rill
        ];
        $this->emit('save', $data);
        $this->emit('closeModal', ['modalId' => $this->key]);
        $this->stock_rill = '';
    }

    public function rules(){
        return [
            'stock_rill' => 'required'
        ];
    }
}
