<?php

namespace App\Http\Livewire\Reports;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Reports\Models\AssetReports;
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

    public $stock_office_pending;
    public $stock_office_pending_coef = [];
    public $stock_office_pending_24 = [];
    public $stock_office_pending_array = [];

    public $stock_office_ready;
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

    public $assetsReport;

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    public function mount() {
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');

        $this->getDataAssets();
        $this->getProductQueries();
        $this->setArrayForProductBase();
        
        // Generate default coef
        $this->generate_default_coef();

        $this->assetsReport = AssetReports::where('date', date('y-m-d'))->first();
    }

    public function getDataAssets() {

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
        
    }

    public function getProductQueries(){

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
    }

    public function setArrayForProductBase() {

        // Stok Pending Office berupa product
        $this->stock_office_pending_array = $this->stock_office_pending->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();
        
        // Stok Ready Office berupa product
        $this->stock_office_ready_array = $this->stock_office_ready->map(function($data){
                return $data;
            })
            ->flatten()
            ->keyBy('karat_id')
            ->toArray();

    }

    public function render() {
        $this->getProductQueries();
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
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_array[$item->karat_id]['pure_gold'] = $item->berat_real * ($coef/100); 
                $this->stock_office_array[$item->karat_id]['coef'] = $coef;
            }
        }
        if(!empty($this->stock_office_lantakan)){
            foreach($this->stock_office_lantakan as $item) {
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_lantakan_array[$item->karat_id]['pure_gold'] = $item->weight * ($coef/100); 
                $this->stock_office_lantakan_array[$item->karat_id]['coef'] = $coef;
            }
        }
        if(!empty($this->stock_office_rongsok)){
            foreach($this->stock_office_rongsok as $item) {
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_rongsok_array[$item->karat_id]['pure_gold'] = $item->weight * ($coef/100); 
                $this->stock_office_rongsok_array[$item->karat_id]['coef'] = $coef;
            }
        }
        if(!empty($this->stock_office_pending)){
            foreach($this->stock_office_pending as $item) {
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_pending_array[$item->karat_id]['pure_gold'] = $item->berat_real * ($coef/100); 
                $this->stock_office_pending_array[$item->karat_id]['coef'] = $coef;
            }
        }
        if(!empty($this->stock_office_ready)){
            foreach($this->stock_office_ready as $item) {
                $coef = !empty($item->karat?->coef) ? $item->karat?->coef*100 : 0;
                $this->stock_office_ready_array[$item->karat_id]['pure_gold'] = $item->berat_real * ($coef/100); 
                $this->stock_office_ready_array[$item->karat_id]['coef'] = $coef;
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
                $result = (($this->stock_office_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_array[$karat_id]['berat_real'] ?? 0);
                $this->stock_office_array[$karat_id]['pure_gold'] = $result; 
                break;
            case "office_lantakan":
                $result = (($this->stock_office_lantakan_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_lantakan_array[$karat_id]['weight'] ?? 0);
                $this->stock_office_lantakan_array[$karat_id]['pure_gold'] = $result;
                break;
            case "office_rongsok":
                $result = (($this->stock_office_rongsok_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_rongsok_array[$karat_id]['weight'] ?? 0);
                $this->stock_office_rongsok_array[$karat_id]['pure_gold'] = $result;
                break;
            case "office_pending":
                $result = (($this->stock_office_pending_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_pending_array[$karat_id]['berat_real'] ?? 0);
                $this->stock_office_pending_array[$karat_id]['pure_gold'] = $result;
                break;
            case "office_ready":
                $result = (($this->stock_office_ready_array[$karat_id]['coef'] ?? 0) /100) * ($this->stock_office_ready_array[$karat_id]['berat_real'] ?? 0);
                $this->stock_office_ready_array[$karat_id]['pure_gold'] = $result;
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

    public function submit(){
        $data = [];
        DB::beginTransaction();
        try {

            $data = array_merge($this->collectData('office', $this->stock_office_array), $data);
            $data = array_merge($this->collectData('office_lantakan', $this->stock_office_lantakan_array), $data);
            $data = array_merge($this->collectData('office_rongsok', $this->stock_office_rongsok_array), $data);
            $data = array_merge($this->collectData('office_pending', $this->stock_office_pending_array), $data);
            $data = array_merge($this->collectData('office_ready', $this->stock_office_ready_array), $data);
            $data = array_merge($this->collectData('cabang', $this->stock_cabang_array), $data);
            
            if($this->assetsReport){
                toast('Report Asset Untuk Bulan ini sudah dibuat!', 'error');
            }else{

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            toast($e->getMessage(), 'error');
        }
        return redirect()->route('laporanasset.index');

    }

    public function collectData($slug, $datas){
        $results = [];
        foreach($datas as $key => $items) {
            if($slug == 'cabang') {
                foreach ($items as $k => $rows) {
                    foreach ($rows as $value) {
                        $berat_real = ($value['berat_real'] ?? 0) ?? ($value['weight'] ?? 0);
                        $results[] = [
                            'slug' => $slug,
                            'karat_id' => $value['karat_id'] ?? null,
                            'status_id' => $value['status_id'] ?? null,
                            'cabang_id' => $value['cabang_id'] ?? null,
                            'berat_real' => $berat_real,
                            'coef' => $value['coef'] ?? null,
                            'pure_gold' => $value['pure_gold'] ?? null,
                            'created_by' => auth()->user()->id,
                        ];
                    }
                }
            } else {
                $berat_real = ($item['berat_real'] ?? 0) ?? ($item['weight'] ?? 0);
                $results[] = [
                    'slug' => $slug,
                    'karat_id' => $items['karat_id'] ?? null,
                    'status_id' => $items['status_id'] ?? null,
                    'cabang_id' => $items['cabang_id'] ?? null,
                    'berat_real' => $berat_real,
                    'coef' => $items['coef'] ?? null,
                    'pure_gold' => $items['pure_gold'] ?? null,
                    'created_by' => auth()->user()->id,
                ];
            }
        }
        return $results;
    }
}
