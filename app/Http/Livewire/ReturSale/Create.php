<?php

namespace App\Http\Livewire\ReturSale;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
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
            'nominal' => ''
        ]
    ];

    public $dataSales = [];
    public $dataKarat = [];

    public function add()
    {
        $this->retur_sales_detail[] = [
            'karat_id' => '',
            'weight' => '',
            'nominal' => ''
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
                'nominal' => ''
            ]
        ];
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
        $this->dataKarat = Karat::all();
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
            'retur_sales.total_nominal' => 'required',
            'retur_sales_detail.0.weight'     => 'required',
            'retur_sales_detail.*.weight'     => 'required',
            'retur_sales_detail.0.nominal'     => 'required',
            'retur_sales_detail.*.nominal'     => 'required',
            'retur_sales_detail.0.karat_id' => 'required',
            'retur_sales_detail.*.karat_id' => 'required',
            'retur_sales.sales_id' => 'required',
            'retur_sales.date' => 'required',

        ];

        foreach ($this->retur_sales_detail as $key => $value) {

            $rules['retur_sales_detail.0.karat_id'] = 'required';
            $rules['retur_sales_detail.'.$key.'.karat_id'] = 'required';
            $rules['retur_sales_detail.0.weight'] = 'required';
            $rules['retur_sales_detail.'.$key.'.weight'] = 'required';
            $rules['retur_sales_detail.0.nominal'] = 'required';
            $rules['retur_sales_detail.'.$key.'.nominal'] = 'required';
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
            $this->retur_sales['total_nominal'] += intval($this->retur_sales_detail[$key]['nominal']);
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
                    'karat_id' => $this->retur_sales_detail[$key]['karat_id'],
                    'weight' => $this->retur_sales_detail[$key]['weight'],
                    'nominal' => $this->retur_sales_detail[$key]['nominal'],
                ]);
                // event(new ReturSaleDetail($retur_sale,$retur_sale_detail));
            }

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
        

        $this->resetInputFields();
        // session()->flash('message', 'Created Successfully.');
        return redirect(route('retursale.index'));
    }
}
