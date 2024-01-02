<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Sale\Entities\Sale;
use Modules\Stok\Models\StockOffice;

class AssetsReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $start_date;
    public $end_date;
    public $periode_type = '';
    public $month = '';
    public $year = '';

    public $payments;

    public $sales_id;

    public $stock_office = [];
    public $stock_office_coef = [];
    public $stock_office_24 = [];
    public $stock_office_array = [];

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    public function mount() {
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->stock_office = StockOffice::all();
        $this->stock_office_array = $this->stock_office->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();
        $this->generate_default_coef();
    }

    public function render() {
        return view('livewire.reports.assets');
    }

    public function generateReport() {
        $this->validate();
        $this->render();
    }

    public function generate_default_coef(){
        if(!empty($this->stock_office)){
            foreach($this->stock_office as $item) {
                $this->stock_office_coef[$item->karat_id] = $item->karat?->harga?->coef ?? 0;
                $this->stock_office_24[$item->karat_id] = $item->berat_total * $this->stock_office_coef[$item->karat_id];
            }
        }
        dd($this->stock_office_coef, $this->stock_office_24);
    }
}
