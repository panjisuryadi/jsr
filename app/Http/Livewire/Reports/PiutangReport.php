<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\DataSale\Models\DataSale;
use Modules\Sale\Entities\Sale;

class PiutangReport extends Component
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

    public $dataSales;

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    public function mount() {
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->dataSales = DataSale::all();
    }

    public function render() {
        // $sales = Sale::whereDate('date', '>=', $this->start_date)
        //     ->whereDate('date', '<=', $this->end_date)
        //     ->when($this->customer_id, function ($query) {
        //         return $query->where('customer_id', $this->customer_id);
        //     })
        //     ->when($this->sale_status, function ($query) {
        //         return $query->where('status', $this->sale_status);
        //     })
        //     ->when($this->payment_status, function ($query) {
        //         return $query->where('payment_status', $this->payment_status);
        //     })
        //     ->orderBy('date', 'desc')->paginate(10);

        return view('livewire.reports.piutang');
    }

    public function generateReport() {
        $this->validate();
        $this->render();
    }
}
