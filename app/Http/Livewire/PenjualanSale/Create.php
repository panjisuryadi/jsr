<?php

namespace App\Http\Livewire\PenjualanSale;

use Livewire\Component;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;

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
            $rules['penjualan_sales_details.'.$key.'.nominal.' . $key] = 'required';
        }
        return $rules;
    }

    public function calculateTotalBerat()
    {
        $this->penjualan_sales['total_weight'] = 0;
        foreach ($this->penjualan_sales_details as $key => $value) {
            $this->penjualan_sales['total_weight'] += floatval($this->penjualan_sales_details[$key]['weight']);
            $this->penjualan_sales['total_weight'] = number_format(round($this->penjualan_sales['total_weight'], 3), 3, '.', '');
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
        // create dist sales
        // $dist_sale = DistribusiSale::create([
        //     'sales_id' => $this->sales['sales_id'],
        //     'date' => $this->sales['date'],
        //     'invoice_no' => $this->sales['invoice'],
        //     'created_by' => auth()->user()->name
        // ]);

        // $dist_sale_detail = $dist_sale->detail()->create([
        //     'karat_id' => $this->karat_id[0],
        //     'berat_bersih' => $this->berat_bersih[0],
        // ]);

        // event(new DistribusiSaleDetailCreated($dist_sale, $dist_sale_detail));

        // // if input more than 1
        // if (count($this->inputs) > 0) {
        //     foreach ($this->inputs as $key => $value) {
        //         $dist_sale_detail = $dist_sale->detail()->create([
        //             'karat_id' => $this->karat_id[$value],
        //             'berat_bersih' => $this->berat_bersih[$value],
        //         ]);
        //         event(new DistribusiSaleDetailCreated($dist_sale, $dist_sale_detail));
        //     }
        // }

        // $this->inputs = [];
        // $this->resetInputFields();
        // session()->flash('message', 'Created Successfully.');
        // return redirect(route('iventory.index'));
    }
}
