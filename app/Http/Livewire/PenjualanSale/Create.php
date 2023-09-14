<?php

namespace App\Http\Livewire\PenjualanSale;

use Livewire\Component;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
use Modules\PenjualanSale\Models\PenjualanSale;

class Create extends Component
{
    public $penjualan_sales = [
        'date' => '',
        'sales_id' => '',
        'invoice_no' => '',
        'store_name' => '',
        'total_weight' => 0,
        'total_nominal' => 0
    ];

    public $penjualan_sales_details = [
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
        $this->penjualan_sales_details[] = [
            'karat_id' => '',
            'weight' => '',
            'nominal' => ''
        ];
    }

    private function resetPenjualanSales(){
        $this->penjualan_sales = [
            'date' => '',
            'sales_id' => '',
            'invoice_no' => '',
            'store_name' => '',
            'total_weight' => 0,
            'total_nominal' => 0
        ];
    }
    private function resetPenjualanSalesDetails(){
        $this->penjualan_sales_details = [
            [
                'karat_id' => '',
                'weight' => '',
                'nominal' => ''
            ]
        ];
    }

    private function resetInputFields(){
        $this->resetPenjualanSales();
        $this->resetPenjualanSalesDetails();
    }

    public function render()
    {
        return view('livewire.penjualan-sale.create');
    }

    public function mount()
    {
        $this->dataSales = DataSale::all();
        $this->dataKarat = Karat::all();
    }

    public function remove($key)
    {
        $this->resetErrorBag();
        unset($this->penjualan_sales_details[$key]);
        $this->penjualan_sales_details = array_values($this->penjualan_sales_details);
    }


    public function rules()
    {
        $rules = [
            'penjualan_sales.invoice_no' => 'required|string|max:50',
            'penjualan_sales.store_name' => 'string',
            'penjualan_sales.total_weight' => 'required',
            'penjualan_sales.total_nominal' => 'required',
            'penjualan_sales_details.0.weight'     => 'required',
            'penjualan_sales_details.*.weight'     => 'required',
            'penjualan_sales_details.0.nominal'     => 'required',
            'penjualan_sales_details.*.nominal'     => 'required',
            'penjualan_sales_details.0.karat_id' => 'required',
            'penjualan_sales_details.*.karat_id' => 'required',
            'penjualan_sales.sales_id' => 'required',
            'penjualan_sales.date' => 'required',

        ];

        foreach ($this->penjualan_sales_details as $key => $value) {

            $rules['penjualan_sales_details.0.karat_id'] = 'required';
            $rules['penjualan_sales_details.'.$key.'.karat_id'] = 'required';
            $rules['penjualan_sales_details.0.weight'] = 'required';
            $rules['penjualan_sales_details.'.$key.'.weight'] = 'required';
            $rules['penjualan_sales_details.0.nominal'] = 'required';
            $rules['penjualan_sales_details.'.$key.'.nominal'] = 'required';
        }
        return $rules;
    }

    public function calculateTotalBerat()
    {
        $this->penjualan_sales['total_weight'] = 0;
        foreach ($this->penjualan_sales_details as $key => $value) {
            $this->penjualan_sales['total_weight'] += floatval($this->penjualan_sales_details[$key]['weight']);
            $this->penjualan_sales['total_weight'] = number_format(round($this->penjualan_sales['total_weight'], 3), 3, '.', '');
            $this->penjualan_sales['total_weight'] = rtrim($this->penjualan_sales['total_weight'], '0');
            if (substr($this->penjualan_sales['total_weight'], -1) === '.') {
                $this->penjualan_sales['total_weight'] = substr($this->penjualan_sales['total_weight'], 0, -1);
            }
        }
    }

    public function calculateTotalNominal()
    {
        $this->penjualan_sales['total_nominal'] = 0;
        foreach ($this->penjualan_sales_details as $key => $value) {
            $this->penjualan_sales['total_nominal'] += intval($this->penjualan_sales_details[$key]['nominal']);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();
        // create penjualan sales
        $penjualan_sale = PenjualanSale::create([
            'sales_id' => $this->penjualan_sales['sales_id'],
            'date' => $this->penjualan_sales['date'],
            'store_name' => $this->penjualan_sales['store_name'],
            'invoice_no' => $this->penjualan_sales['invoice_no'],
            'total_weight' => $this->penjualan_sales['total_weight'],
            'total_nominal' => $this->penjualan_sales['total_nominal'],
            'created_by' => auth()->user()->name
        ]);

        foreach($this->penjualan_sales_details as $key => $value) {
            $penjualan_sale->detail()->create([
                'karat_id' => $this->penjualan_sales_details[$key]['karat_id'],
                'weight' => $this->penjualan_sales_details[$key]['weight'],
                'nominal' => $this->penjualan_sales_details[$key]['nominal'],
                'created_by' => auth()->user()->name
            ]);
        }

        $this->resetInputFields();
        // session()->flash('message', 'Created Successfully.');
        return redirect(route('penjualansale.index'));
    }
}
