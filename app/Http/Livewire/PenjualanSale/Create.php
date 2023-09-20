<?php

namespace App\Http\Livewire\PenjualanSale;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\DataSale\Models\DataSale;
use Modules\Karat\Models\Karat;
use Modules\PenjualanSale\Events\PenjualanSaleDetailCreated;
use Modules\PenjualanSale\Models\PenjualanSale;

class Create extends Component
{
    public $penjualan_sales = [
        'date' => '',
        'sales_id' => '',
        'invoice_no' => '',
        'store_name' => '',
        'total_weight' => 0,
        'total_nominal' => 0,
        'tipe_pembayaran' => '',
        'cicil' => '',
        'tgl_jatuh_tempo' => '',
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

    public $hari_ini;

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
        $this->dataKarat = Karat::where(function($query){
            $query
            ->whereHas('stockSales', function ($query) {
                $query->where('weight', '>',0);
            });
        })->get();
        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
    }

    public function remove($key)
    {
        $this->resetErrorBag();
        unset($this->penjualan_sales_details[$key]);
        $this->penjualan_sales_details = array_values($this->penjualan_sales_details);
        $this->calculateTotalBerat();
    }


    public function rules()
    {
        $rules = [
            'penjualan_sales.invoice_no' => 'required|string|max:50',
            'penjualan_sales.store_name' => 'string',
            'penjualan_sales.total_weight' => 'required',
            'penjualan_sales.total_nominal' => 'required',
            'penjualan_sales_details.0.nominal'     => 'required',
            'penjualan_sales_details.*.nominal'     => 'required',
            'penjualan_sales_details.0.karat_id' => 'required',
            'penjualan_sales_details.*.karat_id' => 'required',
            'penjualan_sales.sales_id' => 'required',
            'penjualan_sales.date' => 'required',
            'penjualan_sales.tipe_pembayaran' => 'required',
            'penjualan_sales.cicil' => 'required_if:penjualan_sales.tipe_pembayaran,cicil',
            'penjualan_sales.tgl_jatuh_tempo' => [
                'required_if:penjualan_sales.tipe_pembayaran,jatuh_tempo',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);

                    if ($inputDate < $today) {
                        $fail($attribute . ' harus tanggal hari ini atau setelahnya.');
                    }
                }
            ],

        ];

        foreach ($this->penjualan_sales_details as $key => $value) {

            $rules['penjualan_sales_details.0.karat_id'] = 'required';
            $rules['penjualan_sales_details.'.$key.'.karat_id'] = 'required';
            $rules['penjualan_sales_details.'.$key.'.weight'] = [
                'required',
                function ($attribute, $value, $fail) use ($key) {
                    // Cek apakah nilai weight lebih besar dari kolom weight di tabel stock_sales
                    // dengan karat_id 1 dan sales_id 48
                    $isKaratFilled = $this->penjualan_sales_details[$key]['karat_id'] != '';
                    $isSalesFilled = $this->penjualan_sales['sales_id'] != '';
                    if($isKaratFilled && $isSalesFilled){
                        $maxWeight = DB::table('stock_sales')
                            ->where('karat_id', $this->penjualan_sales_details[$key]['karat_id'])
                            ->where('sales_id', $this->penjualan_sales['sales_id'])
                            ->max('weight');
                        if ($value > $maxWeight) {
                            $fail("Berat melebihi stok yang tersedia. Jumlah Stok ($maxWeight).");
                        }
                    }
    
                },
            ];
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
            $this->penjualan_sales['total_weight'] = formatWeight($this->penjualan_sales['total_weight']);
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
        DB::beginTransaction();
        try{
            $penjualan_sale = PenjualanSale::create([
                'sales_id' => $this->penjualan_sales['sales_id'],
                'date' => $this->penjualan_sales['date'],
                'store_name' => $this->penjualan_sales['store_name'],
                'invoice_no' => $this->penjualan_sales['invoice_no'],
                'total_weight' => $this->penjualan_sales['total_weight'],
                'total_nominal' => $this->penjualan_sales['total_nominal'],
                'created_by' => auth()->user()->name
            ]);
    
            $penjualan_sale->payment()->create([
                'tipe_pembayaran' => $this->penjualan_sales['tipe_pembayaran'],
                'jatuh_tempo'     => $this->penjualan_sales['tgl_jatuh_tempo'] ? $this->penjualan_sales['tgl_jatuh_tempo'] : null,
                'cicil'           => $this->penjualan_sales['cicil'] ? $this->penjualan_sales['cicil']:  0,
                'lunas'           => $this->penjualan_sales['tipe_pembayaran'] == 'lunas' ? 'lunas': null,
            ]);
    
            foreach($this->penjualan_sales_details as $key => $value) {
                $penjualan_sale_detail = $penjualan_sale->detail()->create([
                    'karat_id' => $this->penjualan_sales_details[$key]['karat_id'],
                    'weight' => $this->penjualan_sales_details[$key]['weight'],
                    'nominal' => $this->penjualan_sales_details[$key]['nominal'],
                    'created_by' => auth()->user()->name
                ]);
                event(new PenjualanSaleDetailCreated($penjualan_sale,$penjualan_sale_detail));
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->resetInputFields();
        // session()->flash('message', 'Created Successfully.');
        return redirect(route('penjualansale.index'));
    }

    public function updateKaratList(){
        $this->dataKarat = Karat::where(function($query){
            $query
            ->whereHas('stockSales', function ($query) {
                $query->where('weight', '>',0);
                $query->where('sales_id', $this->penjualan_sales['sales_id']);
            });
        })->get();
        
        $this->resetPenjualanSalesDetails();
    }

    public function clearWeight($key){
        $this->penjualan_sales_details[$key]['weight'] = '';
    }
}
