<?php

namespace App\Http\Livewire\ReturSale;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
use Modules\ReturSale\Events\ReturSaleDetailCreated;
use Modules\ReturSale\Models\ReturSale;
use Modules\ReturSale\Models\ReturSaleDetail;

class Create extends Component
{
    public $retur_sales = [
        'date' => '',
        'sales_id' => '',
        'retur_no' => '',
        'total_weight' => 0,
        'total_nominal' => 0
    ];

    public $retur_sales_detail = [
        [
            'karat_id' => '',
            'weight' => '',
            'nominal' => 0,
            'sub_karat_id' => '',
            'sub_karat_choice' => []
        ]
    ];

    public $dataSales = [];
    public $dataKarat = [];

    public $hari_ini;



    public function add()
    {
        $this->retur_sales_detail[] = [
            'karat_id' => '',
            'weight' => '',
            'nominal' => 0,
            'sub_karat_id' => '',
            'sub_karat_choice' => []
        ];
    }

    private function resetReturSales(){
        $this->retur_sales = [
            'date' => '',
            'sales_id' => '',
            'retur_no' => '',
            'total_weight' => 0,
            'total_nominal' => 0
        ];
    }
    private function resetReturSalesDetails(){
        $this->retur_sales_detail = [
            [
                'karat_id' => '',
                'weight' => '',
                'nominal' => 0,
                'sub_karat_id' => '',
                'sub_karat_choice' => []
            ]
        ];
    }

    private function resetTotal(){
        $this->retur_sales['total_weight'] = 0;
        $this->retur_sales['total_nominal'] = 0;
    }

    private function resetInputFields(){
        $this->resetReturSales();
        $this->resetReturSalesDetails();
    }

    public function render()
    {
        return view('livewire.retur-sale.create');
    }

    public function mount()
    {
        $this->dataSales = DataSale::all();
        $this->dataKarat = Karat::where(function($query){
            $query
                ->where('parent_id',null)
                ->whereHas('children', function($query){
                    $query->whereHas('stockSales', function ($query) {
                        $query->where('weight', '>',0);
                    });
                });
        })->get();

        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
    }

    public function remove($key)
    {
        $this->resetErrorBag();
        unset($this->retur_sales_detail[$key]);
        $this->retur_sales_detail = array_values($this->retur_sales_detail);
        $this->calculateTotalBerat();
    }


    public function rules()
    {
        $rules = [
            'retur_sales.retur_no' => 'required|string|max:50',
            'retur_sales.total_weight' => 'required',
            'retur_sales.sales_id' => 'required',
            'retur_sales.date' => [
                'required',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);

                    if ($inputDate < $today) {
                        $fail($attribute . ' harus tanggal hari ini atau setelahnya.');
                    }
                }
            ],

        ];

        foreach ($this->retur_sales_detail as $key => $value) {

            $rules['retur_sales_detail.'.$key.'.karat_id'] = 'required';
            $rules['retur_sales_detail.'.$key.'.sub_karat_id'] = 'required';
            $rules['retur_sales_detail.'.$key.'.weight'] = [
                'required',
                'gt:0',
                function ($attribute, $value, $fail) use ($key) {
                    // Cek apakah nilai weight lebih besar dari kolom weight di tabel stock_sales
                    $isKaratFilled = $this->retur_sales_detail[$key]['sub_karat_id'] != '';
                    $isSalesFilled = $this->retur_sales['sales_id'] != '';
                    if($isKaratFilled && $isSalesFilled){
                        $maxWeight = DB::table('stock_sales')
                            ->where('karat_id', $this->retur_sales_detail[$key]['sub_karat_id'])
                            ->where('sales_id', $this->retur_sales['sales_id'])
                            ->max('weight');
                        if ($value > $maxWeight) {
                            $fail("Berat melebihi stok yang tersedia. Jumlah Stok ($maxWeight).");
                        }
                    }
    
                },
            
            ];
            $rules['retur_sales_detail.'.$key.'.nominal'] = 'gt:-1';
        }
        return $rules;
    }

    public function calculateTotalBerat()
    {
        $this->retur_sales['total_weight'] = 0;
        foreach ($this->retur_sales_detail as $key => $value) {
            $this->retur_sales['total_weight'] += floatval($this->retur_sales_detail[$key]['weight']);
            $this->retur_sales['total_weight'] = number_format(round($this->retur_sales['total_weight'], 3), 3, '.', '');
            $this->retur_sales['total_weight'] = rtrim($this->retur_sales['total_weight'], '0');
            $this->retur_sales['total_weight'] = formatWeight($this->retur_sales['total_weight']);
        }
    }

    public function calculateTotalNominal()
    {
        $this->retur_sales['total_nominal'] = 0;
        foreach ($this->retur_sales_detail as $key => $value) {
            $this->retur_sales['total_nominal'] += floatval($this->retur_sales_detail[$key]['nominal']);
            $this->retur_sales['total_nominal'] = number_format(round($this->retur_sales['total_nominal'], 3), 3, '.', '');
            $this->retur_sales['total_nominal'] = rtrim($this->retur_sales['total_nominal'], '0');
            $this->retur_sales['total_nominal'] = formatWeight($this->retur_sales['total_nominal']);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();
        DB::beginTransaction();
        try{
            // create retur sales
            $retur_sale = ReturSale::create([
                'sales_id' => $this->retur_sales['sales_id'],
                'date' => $this->retur_sales['date'],
                'retur_no' => $this->retur_sales['retur_no'],
                'total_weight' => $this->retur_sales['total_weight'],
                'total_nominal' => $this->retur_sales['total_nominal'],
                'created_by' => auth()->user()->name
            ]);
    
            foreach($this->retur_sales_detail as $key => $value) {
                $retur_sale_detail = $retur_sale->detail()->create([
                    'karat_id' => $this->retur_sales_detail[$key]['sub_karat_id'],
                    'weight' => $this->retur_sales_detail[$key]['weight'],
                    'nominal' => $this->retur_sales_detail[$key]['nominal']?$this->retur_sales_detail[$key]['nominal']:null,
                ]);
                event(new ReturSaleDetailCreated($retur_sale,$retur_sale_detail));
            }

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
        

        $this->resetInputFields();
        $this->resetTotal();
        // session()->flash('message', 'Created Successfully.');
        toast('Created Successfully','success');
        return redirect(route('retursale.index'));
    }



    public function updateKaratList(){
        $this->dataKarat = Karat::where(function($query){
            $query
                ->where('parent_id',null)
                ->whereHas('children', function($query){
                    $query->whereHas('stockSales', function ($query) {
                        $query->where('weight', '>',0);
                        $query->where('sales_id', $this->retur_sales['sales_id']);
                    });
                });
        })->get();
        
        $this->resetReturSalesDetails();
        $this->resetDataSubKarat();
    }

    public function clearWeight($key){
        $this->retur_sales_detail[$key]['weight'] = '';
    }

    public function changeParentKarat($key){
        $this->clearWeight($key);
        $karat = Karat::find($this->retur_sales_detail[$key]['karat_id']);

        if(is_null($karat)){
            $this->retur_sales_detail[$key]['sub_karat_choice'] = [];
        }else{
            $this->retur_sales_detail[$key]['sub_karat_choice'] = 
            $karat->children()->whereHas('stockSales', fn ($query) => $query->where('weight','>',0)->where('sales_id', $this->retur_sales['sales_id']))->whereNotIn('id',$this->getUsedSubKaratIds())->get();
        }
    }

    protected function resetDataSubKarat(){
        foreach ($this->retur_sales_detail as $detail) {
            $detail['sub_karat_choice'] = [];
        }
    }

    protected function getUsedSubKaratIds(){
        $subKaratIds = [];
        foreach ($this->retur_sales_detail as $detail) {
            if (isset($detail['sub_karat_id'])) {
                $subKaratIds[] = $detail['sub_karat_id'];
            }
        }
        return $subKaratIds;
    }

    public function updateHarga(Karat $karat,$key){
        $this->retur_sales_detail[$key]['nominal'] = formatBerat($karat->harga);
        $this->calculateTotalNominal();
    }
}
