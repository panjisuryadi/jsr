<?php

namespace App\Http\Livewire\DistribusiToko\Cabang;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Product;

class Detail extends Component
{
    public $dist_toko;

    public $selectedItems = [];


    public function render()
    {
        return view("livewire.distribusi-toko.cabang.detail");
    }

    public function mount()
    {
    }

    public function rules()
    {
        $rules = [];


        return $rules;
    }

    public function proses()
    {
        if (count($this->selectedItems) == 0) {
            $this->dispatchBrowserEvent('items:not-selected', [
                'message' => 'Barang belum dipilih'
            ]);
        } else {
            $this->dispatchBrowserEvent('summary:modal');
        }
    }

    public function showTracking(){
        $this->dispatchBrowserEvent('tracking:modal');
    }
}
