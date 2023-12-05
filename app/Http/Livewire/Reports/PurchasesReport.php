<?php

namespace App\Http\Livewire\Reports;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\GoodsReceipt\Models\GoodsReceiptInstallment;
use Modules\Purchase\Entities\Purchase;

class PurchasesReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $suppliers;
    public $start_date;
    public $end_date;
    public $supplier_id;
    public $purchase_status;
    public $payment_status;

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    public function mount($suppliers) {
        $this->suppliers = $suppliers;
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->supplier_id = '';
        $this->purchase_status = '';
        $this->payment_status = '';
    }

    public function render() {
        // $data = GoodsReceipt::with('supplier', 'pembelian.detailCicilan')
        //         ->withSum('goodsreceiptitem as total_berat', 'berat_reals')
        //         ->lunasAtauCicil()
        //         ->whereDate('date', '>=', $this->start_date)
        //         ->whereDate('date', '<=', $this->end_date)
        //     ->when($this->supplier_id, function ($query) {
        //         return $query->where('supplier_id', $this->supplier_id);
        //     })
        //     ->orderBy('date', 'desc')->paginate(10);
        // $data = GoodsReceiptInstallment::with('pembelian.goodreceipt.goodsreceiptitem')
        //         ->whereHas('pembelian.goodreceipt', function($q) {
        //             $q->withSum('goodsreceiptitem as total_berat', 'berat_real');
        //             $q->whereDate('date', '>=', $this->start_date);
        //             $q->whereDate('date', '<=', $this->end_date);
        //             $q->when($this->supplier_id, function ($query) {
        //                 return $query->where('supplier_id', $this->supplier_id);
        //             });
        //             $q->orderBy('date', 'desc');
        //         })->orderBy('pembelian.goodreceipt.date', 'desc')->paginate(10);
        // $data = GoodsReceiptInstallment::leftJoin('tipe_pembelian', 'payment_id', 'tipe_pembelian.id')
        //                                 ->leftJoin('goodsreceipt', 'goodsreceipt_id', 'goodsreceipt.id')

        $data = DB::table('goodsreceipts as gr')
                ->select(
                    'gr.date',
                    'gr.code',
                    'gr.no_invoice',
                    'gr.harga_beli',
                    'gr.total_emas',
                    'gr.total_karat',
                    'gr.tipe_pembayaran',
                    'gr.supplier_id',
                    'suppliers.supplier_name',
                    'tipe_pembelian.lunas',
                    'penerimaan_barang_cicilan.updated_at as tgl_bayar',
                    'penerimaan_barang_cicilan.jumlah_cicilan',
                    'penerimaan_barang_cicilan.nomor_cicilan',
                    'penerimaan_barang_cicilan.nominal',
                )
                ->leftJoin('suppliers', function($q) {
                    $q->on('supplier_id', 'suppliers.id');
                })
                ->leftJoin('tipe_pembelian', function($q){
                    $q->on('gr.id', 'tipe_pembelian.goodsreceipt_id');
                })
                ->leftJoin('penerimaan_barang_cicilan', function($q) {
                    $q->on('payment_id', 'tipe_pembelian.id');
                })
                ->whereDate('gr.date', '>=', $this->start_date)
                ->whereDate('gr.date', '<=', $this->end_date)
                ->when($this->supplier_id, function ($query) {
                    return $query->where('supplier_id', $this->supplier_id);
                })
                ->where(function($q){
                    $q->where('gr.tipe_pembayaran', 'lunas');
                    $q->orWhere('nominal', '>', '0');
                    $q->orWhere('jumlah_cicilan', '>', '0');
                })
                ->orderBy('date', 'desc')->paginate(10);

        return view('livewire.reports.purchases-report', [
            'datas' => $data
        ]);
    }

    public function generateReport() {
        $this->validate();
        $this->render();
    }
}
