<?php

namespace App\Http\Livewire\Reports;

use App\Exports\Sale\SaleExport;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Sale\Entities\Sale;
use PDF;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SalesReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $customers;
    public $start_date;
    public $end_date;
    public $customer_id;
    public $sale_status;
    public $payment_status;
    public $sales_data;

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    public function mount($customers) {
        $this->customers = $customers;
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->customer_id = '';
        $this->sale_status = '';
        $this->payment_status = '';
    }

    public function render() {
        $sales = Sale::whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date)
            ->where('customer_id',null)
            ->when($this->sale_status, function ($query) {
                return $query->where('status', $this->sale_status);
            })
            ->when($this->payment_status, function ($query) {
                return $query->where('payment_status', $this->payment_status);
            })
            ->orderBy('date', 'desc');
        
        $this->sales_data = $sales->clone()->get();

        return view('livewire.reports.sales-report', [
            'sales' => $sales->paginate(10)
        ]);
    }

    public function filterReport() {
        $this->validate();
        $this->render();
    }

    public function pdf(){
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $filename = "Laporan Penjualan Periode " . $start_date . " - " . $end_date;
        $sales = $this->sales_data;
        $pdf = PDF::loadView('reports::sales.print',compact('start_date','filename','end_date','sales'))->output();
        $base64Pdf = base64_encode($pdf);
        $dataUri = 'data:application/pdf;base64,' . $base64Pdf;
        $this->emit('openInNewTab', $dataUri);
    }

    public function export($format): BinaryFileResponse
    {
        abort_if(! in_array($format,['csv','xlsx','pdf']), Response::HTTP_NOT_FOUND);
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $filename = "Laporan Penjualan Periode " . $start_date . " - " . $end_date;
        return Excel::download(new SaleExport($this->sales_data), $filename. '.' . $format);
    }
}
