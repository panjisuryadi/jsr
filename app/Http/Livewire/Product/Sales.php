<?php

namespace App\Http\Livewire\Product;


        use Livewire\Component;
        use App\Http\Livewire\Field;
        use App\Models\User;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Validator;
        use Modules\GoodsReceipt\Models\GoodsReceipt;
        use Livewire\WithFileUploads;
use Modules\DataSale\Models\DataSale;
use Modules\DistribusiSale\Events\DistribusiSaleDetailCreated;
use Modules\DistribusiSale\Models\DistribusiSale;
use Modules\Iventory\Models\DistSales;
use Modules\Karat\Models\Karat;

        class Sales extends Component
        {
            use WithFileUploads;
            public 
             $berat_bersih,
             $kasir,
             $dataSales = [],
             $karat_id = [''];
 
            public $pilih_po = [];
            public $inputs = [];
            public $sales = [
                "sales_id" => ""
            ];
            public $i = 0;

            public function calculateTotalJumlah(){
                $this->sales['total_jumlah'] = $this->berat_bersih[0]??0;
                if(count($this->inputs)>0){
                    foreach($this->inputs as $key => $value){
                        $this->sales['total_jumlah'] += $this->berat_bersih[$value]??0;
                        $this->sales['total_jumlah'] = number_format(round($this->sales['total_jumlah'], 3), 3, '.', '');
                    }
                }
            }

            public function add($i)
            {
                $i = $i + 1;
                $this->i = $i;
                array_push($this->inputs ,$i);
                $this->karat_id[] = '';
            }

            public function remove($i)
            {
                unset($this->inputs[$i]);
                $this->calculateTotalJumlah();
            }

            public function render()
            {
                $this->kasir = User::role('Kasir')->orderBy('name')->get();
                return view('livewire.product.sales');
            }



            private function resetInput()
                {
                    $this->sales['invoice'] = null;
                    $this->sales['date'] = null;
                    $this->sales['sales_id'] = null;
                  
                }



            private function resetInputFields(){
                $this->karat_id = '';
                $this->berat_bersih = '';
                $this->pilih_po = [];
              
            }


               public function rules()
                {
                        $rules = [
                              'sales.invoice' => 'required|string|max:50',
                              'berat_bersih.0'     => 'required',  
                              'berat_bersih.*'     => 'required',
                              'karat_id.0' => 'required',
                              'karat_id.*' => 'required',
                              'sales.sales_id' => 'required',
                              'sales.date' => 'required',

                        ];

                        foreach($this->inputs as $key => $value)
                        {
                            
                            $rules['karat_id.0'] = 'required';
                            $rules['karat_id.'.$value] = 'required'; 
                            $rules['berat_bersih.0'] = 'required';
                            $rules['berat_bersih.'.$value] = 'required';
                        }
                        return $rules;
                   }



                public function messages()
                {
                    $messages = [];
                      foreach($this->inputs as $key => $value)
                      {
                        $messages['karat_id.0'] = 'required';
                        $messages['karat_id.'.$value] = 'required';
                        $messages['sales.sales_id'] = 'required';
                      }
                      return $messages;

                }


             public function pilihPo($key,$value)
                {
                    $karat = Karat::find($value);
                    $this->pilih_po[$key] = $karat->kode;
                }

            public function updated($propertyName)
                {
                    if ($this->inputs) {
                        $this->validateOnly($propertyName);
                    }
                }

            public function mount(){
                $this->dataSales = DataSale::all();
            }

            public function store()
            {
                $this->validate();
                // create dist sales
                $dist_sale = DistribusiSale::create([
                    'sales_id' => $this->sales['sales_id'],
                    'date' => $this->sales['date'],
                    'invoice_no' => $this->sales['invoice'],
                    'created_by' => auth()->user()->name
                ]);

                $dist_sale_detail = $dist_sale->detail()->create([
                    'karat_id' => $this->karat_id[0],
                    'berat_bersih' => $this->berat_bersih[0],
                ]);

                event(new DistribusiSaleDetailCreated($dist_sale,$dist_sale_detail));

                // if input more than 1
                if(count($this->inputs) > 0){
                    foreach($this->inputs as $key => $value){
                        $dist_sale_detail = $dist_sale->detail()->create([
                            'karat_id' => $this->karat_id[$value],
                            'berat_bersih' => $this->berat_bersih[$value],
                        ]);
                        event(new DistribusiSaleDetailCreated($dist_sale,$dist_sale_detail));
                    }
                }
                
                $this->inputs = [];
                $this->resetInputFields();
                session()->flash('message', 'Created Successfully.');
                return redirect(route('iventory.index'));

            }




}
