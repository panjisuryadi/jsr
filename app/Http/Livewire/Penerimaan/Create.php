<?php

namespace App\Http\Livewire\Penerimaan;

use Livewire\Component;

class Create extends Component
{
    public $title;
     public $cities = [

        1 => 'Rajkot',

        2 => 'Surat',

        3 => 'Vadodara'

    ];

    public $city_id = '';

  
    public function mount()
    {
        $this->title = 'djsjdjsds';
      
    }
    public function render()
    {
        return view('livewire.penerimaan.create');
    }

    public function changeEvent($value)

    {

       dd('sdsds');

    }
}
