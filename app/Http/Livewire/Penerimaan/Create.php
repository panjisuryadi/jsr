<?php

namespace App\Http\Livewire\Penerimaan;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Auth;
use Modules\PenerimaanBarangLuar\Events\PenerimaanBarangLuarCreated;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar;
use Modules\Cabang\Models\Cabang;
use Modules\Status\Models\ProsesStatus;


use Livewire\Component;

class Create extends Component
{
    public $title;
   
    public $bulan = '';

  
    public function mount()
    {
       
      
    }
    public function render()
    {
        return view('livewire.penerimaan.create');
    }

    public function pilihBulan($value)

    {

       dd('sdsds');


    }


    public function getParentlocations(){
          $this->locations = Locations::orderby('name','asc')
                          ->select('*')
                          ->where('parent_id',$this->id_location)
                          ->get();

          // Reset value
          $this->sub_location = 0;
     }



}
