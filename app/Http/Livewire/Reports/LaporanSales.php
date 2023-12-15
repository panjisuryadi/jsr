<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Modules\DataSale\Models\DataSale;

class LaporanSales extends Component
{

    public $pilihSales;
    public $listSales;

    public function render()
    {
        $datasales = DataSale::all();
        return view('livewire.reports.laporan-sales', ['datasales' => $datasales]);
    }


     public function cariSales($value)
     {
        $this->listSales = DataSale::find($value);
      
        //dd($this->listSales);
     }


}
