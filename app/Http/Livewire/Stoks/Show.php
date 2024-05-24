<?php

namespace App\Http\Livewire\Stoks;

use Livewire\Component;

class Show extends Component
{
    public $details;
    public $detail_items;
    public $selectAll = false;
    public $selectedItems = [];
    public $showConfirmModal = false;


    protected $listeners = [
        'selectAllItem' => 'handleSelectAllItem',
        'isSelectAll' => 'handleIsSelectAll'
    ];

    public function handleSelectAllItem($value){
        $this->selectedItems = $value;
    }

    public function handleIsSelectAll($value){
        $this->selectAll = $value;
    }

    public function amount($details)
    {
        $this->$details = $details;
    }
    public function render()
    {
        return view('livewire.stoks.show');
    }

    public function proses()
    {
        $this->dispatchBrowserEvent('confirm:modal');
    }
}
