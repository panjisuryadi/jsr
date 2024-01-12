<?php

namespace App\Http\Livewire\Reports;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Sale\Entities\Sale;
use Modules\Stok\Models\StockKroom;
use Modules\Stok\Models\StockOffice;
use Modules\Stok\Models\StockRongsok;

class AssetsReport extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $start_date;
    public $end_date;
    public $periode_type = '';
    public $month = '';
    public $year = '';

    public $stock_office = [];
    public $stock_office_coef = [];
    public $stock_office_24 = [];
    public $stock_office_array = [];

    public $stock_office_lantakan = [];
    public $stock_office_lantakan_coef = [];
    public $stock_office_lantakan_24 = [];
    public $stock_office_lantakan_array = [];

    public $stock_office_rongsok = [];
    public $stock_office_rongsok_coef = [];
    public $stock_office_rongsok_24 = [];
    public $stock_office_rongsok_array = [];

    public $stock_office_pending = [];
    public $stock_office_pending_coef = [];
    public $stock_office_pending_24 = [];
    public $stock_office_pending_array = [];

    public $stock_office_ready = [];
    public $stock_office_ready_coef = [];
    public $stock_office_ready_24 = [];
    public $stock_office_ready_array = [];

    public $stock_cabang = [];
    public $stock_cabang_coef = [];
    public $stock_cabang_24 = [];
    public $stock_cabang_array = [];

    public $status_cabang = [
        ProductStatus::PENDING_CABANG,
        ProductStatus::READY,
        ProductStatus::DP,
    ];

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    public function mount() {
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');

        // Stok Office Gudang bahan baku
        $this->stock_office = StockOffice::all();
        $this->stock_office_array = $this->stock_office->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();
        
        // Stok Lantakan Gudang bahan baku
        $this->stock_office_lantakan = StockKroom::get();
        $this->stock_office_lantakan_array = $this->stock_office_lantakan->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();
        
            // Stok Rongsok Gudang bahan baku
            $this->stock_office_rongsok = StockRongsok::get();
            $this->stock_office_rongsok_array = $this->stock_office_rongsok->map(function($data){
                    return $data;
                })
                ->flatten()
                ->keyBy('karat_id')
                ->toArray();
        
        // Stok Pending Office berupa product
        $this->stock_office_pending = Product::pendingOffice()
                                        ->select(
                                            DB::raw('sum(berat_emas) as berat_real'), 
                                            'products.karat_id',
                                        )
                                        ->groupBy('karat_id')->get();
        $this->stock_office_pending_array = $this->stock_office_pending->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();
        
        // Stok Ready Office berupa product
        $this->stock_office_ready = Product::readyOffice()
                                        ->select(
                                            DB::raw('sum(berat_emas) as berat_real'), 
                                            'products.karat_id',
                                        )
                                        ->groupBy('karat_id')->get();
        $this->stock_office_ready_array = $this->stock_office_ready->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();
        
        // Stok Ready Cabang berupa product
        
        $this->stock_cabang = Product::with('cabang', 'current_status')
                                    ->select(
                                        'berat_emas as berat_real', 
                                        'karat_id',
                                        'status_id',
                                        'cabang_id',
                                    )
                                    ->whereNotNull('cabang_id')
                                    ->whereIn('status_id', $this->status_cabang)->get();
        
        // Generate default coef
        $this->generate_default_coef();
    }

    public function render() {
        // Stok Pending Office berupa product
        $this->stock_office_pending = Product::pendingOffice()
                                        ->select(
                                            DB::raw('sum(berat_emas) as berat_real'), 
                                            'products.karat_id',
                                        )
                                        ->groupBy('karat_id')->get();
        
        // Stok Ready Office berupa product
        $this->stock_office_ready = Product::readyOffice()
                                        ->select(
                                            DB::raw('sum(berat_emas) as berat_real'), 
                                            'products.karat_id',
                                        )
                                        ->groupBy('karat_id')->get();
        
        $this->stock_cabang = Product::with('cabang', 'current_status')
                                    ->select(
                                        'berat_emas as berat_real', 
                                        'karat_id',
                                        'status_id',
                                        'cabang_id',
                                    )
                                    ->whereNotNull('cabang_id')
                                    ->whereIn('status_id', $this->status_cabang)->get();
        $this->generate_array_stok_cabang();
        return view('livewire.reports.assets');
    } 

    public function generateReport() {
        $this->validate();
        $this->render();
    }

    public function generate_default_coef(){
        if(!empty($this->stock_office)){
            foreach($this->stock_office as $item) {
                $this->stock_office_coef[$item->karat_id] = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_24[$item->karat_id] = $item->berat_real * ($this->stock_office_coef[$item->karat_id]/100);
            }
        }
        if(!empty($this->stock_office_lantakan)){
            foreach($this->stock_office_lantakan as $item) {
                $this->stock_office_lantakan_coef[$item->karat_id] = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_lantakan_24[$item->karat_id] = $item->weight * ($this->stock_office_lantakan_coef[$item->karat_id]/100);
            }
        }
        if(!empty($this->stock_office_rongsok)){
            foreach($this->stock_office_rongsok as $item) {
                $this->stock_office_rongsok_coef[$item->karat_id] = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_rongsok_24[$item->karat_id] = $item->weight * ($this->stock_office_rongsok_coef[$item->karat_id]/100);
            }
        }
        if(!empty($this->stock_office_pending)){
            foreach($this->stock_office_pending as $item) {
                $this->stock_office_pending_coef[$item->karat_id] = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_pending_24[$item->karat_id] = $item->berat_real * ($this->stock_office_pending_coef[$item->karat_id]/100);
            }
        }
        if(!empty($this->stock_office_ready)){
            foreach($this->stock_office_ready as $item) {
                $this->stock_office_ready_coef[$item->karat_id] = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_ready_24[$item->karat_id] = $item->berat_real * ($this->stock_office_ready_coef[$item->karat_id]/100);
            }
        }

        $this->generate_coef_cabang();
        
    }

    public function generate_coef_cabang() {

        if(!empty($this->stock_cabang)){
            foreach($this->stock_cabang as $item){
                $berat_real = ($this->stock_cabang_array[$item->cabang?->name][$item->karat?->name]['berat_real'] ?? 0) + $item->berat_real;
                $item->berat_real = $berat_real;
                $this->stock_cabang_array[$item->cabang?->name][$item->current_status->name][$item->karat_id] = $item;
                $this->stock_cabang_coef[$item->cabang?->name][$item->current_status->name][$item->karat_id] = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_cabang_24[$item->cabang?->name][$item->current_status->name][$item->karat_id] = $item->berat_real * ($this->stock_cabang_coef[$item->cabang?->name][$item->current_status->name][$item->karat_id]/100);
            }
        }
    }

    public function generate_array_stok_cabang(){
        if(!empty($this->stock_cabang)){
            foreach($this->stock_cabang as $item){
                $this->stock_cabang_array[$item->cabang?->name][$item->current_status->name][$item->karat_id] = $item;
            }
        }
    }

    /**
     * Function ini digunakan untuk menghitung harga
     * @param $slug = slug untuk membedakan mau menghitung data yang mana 
     * @param $karat_id = berisi karat id
     * @param $karat_id = untuk case cabang, ini akan berisi array karena butuh beberapa parameter
     * @param $karat_id['karat_id] = karat id
     * @param string $karat_id['cabang] = berisi aray key cabang
     * @param string $karat_id['status] = berisi aray key status
     */
    
    public function hitungHarga($slug, $karat_id) {
        switch ($slug) {
            case "office":
                $result = ($this->stock_office_coef[$karat_id]/100) * ($this->stock_office_array[$karat_id]['berat_real'] ?? 0);
                $this->stock_office_24[$karat_id] = $result;
                break;
            case "office_lantakan":
                $result = ($this->stock_office_lantakan_coef[$karat_id]/100) * ($this->stock_office_lantakan_array[$karat_id]['weight'] ?? 0);
                $this->stock_office_lantakan_24[$karat_id] = $result;
                break;
            case "office_rongsok":
                $result = ($this->stock_office_rongsok_coef[$karat_id]/100) * ($this->stock_office_rongsok_array[$karat_id]['weight'] ?? 0);
                $this->stock_office_rongsok_24[$karat_id] = $result;
                break;
            case "office_pending":
                $result = ($this->stock_office_pending_coef[$karat_id]/100) * ($this->stock_office_pending_array[$karat_id]['berat_real'] ?? 0);
                $this->stock_office_pending_24[$karat_id] = $result;
                break;
            case "office_ready":
                $result = ($this->stock_office_ready_coef[$karat_id]/100) * ($this->stock_office_ready_array[$karat_id]['berat_real'] ?? 0);
                $this->stock_office_ready_24[$karat_id] = $result;
                break;
            case "cabang":
                $params = $karat_id;
                $karat_id = $params['karat_id'] ?? null;
                $cabang = $params['cabang'] ?? null;
                $status = $params['status'] ?? null;
                if(!empty($karat_id) && !empty($cabang) && !empty($status)) {
                    $result = ($this->stock_cabang_coef[$cabang][$status][$karat_id]/100) * ($this->stock_cabang_array[$cabang][$status][$karat_id]['berat_real'] ?? 0);
                    $this->stock_cabang_24[$cabang][$status][$karat_id] = $result;
                }
                break;
            default:
              return true;
          }
    }
}
