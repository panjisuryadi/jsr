<?php

namespace App\Http\Livewire\Reports;

use App\Exports\Sale\SaleExport;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Sale\Entities\Sale;
use PDF;
use Illuminate\Http\Response;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\People\Entities\Supplier;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DebtReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $start_date;
    public $end_date;
    public $month;
    public $year;

    public $customer_id;
    public $sale_status;
    public $payment_status;
    public $payment_type;
    public $sales_data;

    public $gr;
    public $period_type = '';
    public $suppliers;
    public $supplier;

    protected $rules = [
        'period_type' => 'required',
        'start_date' => 'requiredIf:period_type,custom|date|before:end_date',
        'end_date'   => 'requiredIf:period_type,custom|date|after:start_date',
        'month' => 'requiredIf:period_type,month',
        'year' => 'requiredIf:period_type,year'
    ];

    public function mount() {
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->payment_type = '';
        $this->suppliers = Supplier::all();
    }

    public function render() {
        $goodsreceipt = GoodsReceipt::debts()
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
            ->when($this->payment_type, function ($query) {
                return $query->whereRelation('pembelian', 'tipe_pembayaran',$this->payment_type);
            })
            ->when($this->supplier, function ($query) {
                return $query->where('supplier_id', $this->supplier);
            })
            ->orderBy('date', 'desc');
        
        $this->gr = $goodsreceipt->clone()->get();
        $debts = $this->gr->sum('total_emas');
        $this->gr->each(function($item) use ($debts){
            $debts -= $item->pembelian->total_paid;
        });
        return view('livewire.reports.debt-report', [
            'goodsreceipt' => $goodsreceipt->paginate(10),
            'debts' => $debts
        ]);
    }

    public function filterReport() {
        $this->validate();
        $this->render();
    }

    public function pdf(){
        $this->validate();
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
        $this->validate();
        abort_if(! in_array($format,['csv','xlsx','pdf']), Response::HTTP_NOT_FOUND);
        $start_date = Carbon::parse($this->start_date);
        $end_date = Carbon::parse($this->end_date);
        $filename = "Laporan Penjualan Periode " . $start_date . " - " . $end_date;
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
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
            'payment_type',
            'supplier'
        ]);
    }
}
