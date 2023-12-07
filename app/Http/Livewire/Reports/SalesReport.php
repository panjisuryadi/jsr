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
use Modules\Cabang\Models\Cabang;
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

    public $month;
    public $year;
    public $period_type;

    public $cabangs;
    public $selected_cabang;

    protected $rules = [
        'period_type' => 'required',
        'start_date' => 'required_if:period_type,custom|date|before:end_date',
        'end_date'   => 'required_if:period_type,custom|date|after:start_date',
        'month' => 'required_if:period_type,month',
        'year' => 'required_if:period_type,year'
    ];

    public function mount($customers) {
        $this->customers = $customers;
        $this->customer_id = '';
        $this->cabangs = Cabang::all();
        $this->selected_cabang = auth()->user()->isUserCabang()?auth()->user()->namacabang()->id:'';
    }

    public function render() {
        $sales = Sale::query()
                ->when($this->month, function ($query) {
                    return $query->whereRaw('MONTH(date) = ? AND YEAR(date) = ?', [date('m', strtotime($this->month)), date('Y', strtotime($this->month))]);
                })
                ->when($this->year, function ($query) {
                    return $query->whereYear('date',$this->year);
                })
                ->when($this->start_date, function ($query) {
                    return $query->whereDate('date', '>=', $this->start_date);
                })
                ->when($this->end_date, function ($query) {
                    return $query->whereDate('date', '<=', $this->end_date);
                })
                ->when($this->selected_cabang, function ($query) {
                    return $query->where('cabang_id', $this->selected_cabang);
                })
                ->orderBy('date', 'desc');
        
        $this->sales_data = $sales->clone()->get();
        $total_nominal = $this->sales_data->sum('total_amount');
        return view('livewire.reports.sales-report', [
            'sales' => $sales->paginate(10),
            'total_nominal' => $total_nominal
        ]);
    }

    public function filterReport() {
        $this->validate();
        $this->render();
    }

    public function pdf(){
        // $this->validate();
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $filename = "Laporan Penjualan " . $this->period_text;
        $sales = $this->sales_data;
        $pdf = PDF::loadView('reports::sales.print',compact('start_date','filename','end_date','sales'))->output();
        $base64Pdf = base64_encode($pdf);
        $dataUri = 'data:application/pdf;base64,' . $base64Pdf;
        $this->emit('openInNewTab', $dataUri);
    }

    public function export($format): BinaryFileResponse
    {
        $this->validate();
        abort_if(! in_array($format,['csv','xlsx','pdf']), Response::HTTP_NOT_FOUND);
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $filename = "Laporan Penjualan " . $this->period_text;
        return Excel::download(new SaleExport($this->sales_data), $filename. '.' . $format);
    }

    public function updatedPeriodType(){
        $this->reset([
            'start_date',
            'end_date',
            'month',
            'year'
        ]);
    }

    public function getPeriodTextProperty(){
        if($this->period_type === 'month' && !empty($this->month)){
            return "Periode Bulan " . Carbon::parse($this->month)->locale('id_ID')->isoFormat('MMMM YYYY');
        }elseif($this->period_type === 'year' && !empty($this->year)){
            return "Periode Tahun " . $this->year;
        }elseif($this->period_type === 'custom' && !empty($this->start_date) && !empty($this->end_date)){
            return "Periode " . tanggal($this->start_date) . ' - ' . tanggal($this->end_date);
        }
    }

    public function resetFilter(){
        $this->reset([
            'start_date',
            'end_date',
            'month',
            'year',
        ]);
        if(!auth()->user()->isUserCabang()){
            $this->reset(['selected_cabang']);
        }
    }
}
