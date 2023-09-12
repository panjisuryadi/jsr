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
use Modules\DistribusiSale\Models\DistribusiSale;
use Modules\Iventory\Models\DistSales;
use Modules\Karat\Models\Karat;

        class Sales extends Component
        {
            use WithFileUploads;
            public 
             $harga,
             $berat_kotor,
             $berat_bersih,
             $jumlah,
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
                $this->sales['total_jumlah'] = $this->jumlah[0]??0;
                if(count($this->inputs)>0){
                    foreach($this->inputs as $key => $value){
                        $this->sales['total_jumlah'] += $this->jumlah[$value]??0;
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
                $this->harga = '';
                $this->berat_kotor = '';
                $this->berat_bersih = '';
                $this->jumlah = '';
                $this->pilih_po = [];
              
            }


               public function rules()
                {
                        $rules = [
                              'sales.invoice' => 'required|string|max:50',
                              'jumlah.0'     => 'required', 
                              'jumlah.*'     => 'required',
                              'berat_kotor.0'     => 'required',  
                              'berat_kotor.*'     => 'required',
                              'berat_bersih.0'     => 'required',  
                              'berat_bersih.*'     => 'required',
                              'harga.0'     => 'numeric|between:0,99.99',
                              'harga.*'     => 'numeric|between:0,99.99',
                              'karat_id.0' => 'required',
                              'karat_id.*' => 'required',
                              'sales.sales_id' => 'required',
                              'sales.date' => 'required',

                        ];

                        foreach($this->inputs as $key => $value)
                        {
                            
                            $rules['harga.0'] = 'numeric|between:0,99.99';
                            $rules['harga.'.$value] = 'numeric|between:0,99.99';
                            $rules['karat_id.0'] = 'required';
                            $rules['karat_id.'.$value] = 'required'; 
                            $rules['berat_bersih.0'] = 'required';
                            $rules['berat_bersih.'.$value] = 'required';
                            $rules['berat_kotor.0'] = 'required';
                            $rules['berat_kotor.'.$value] = 'required';   
                            $rules['jumlah.0'] = 'required';
                            $rules['jumlah.'.$value] = 'required';
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

                $dist_sale->detail()->create([
                    'karat_id' => $this->karat_id[0],
                    'berat_kotor' => $this->berat_kotor[0],
                    'berat_bersih' => $this->berat_bersih[0],
                    'jumlah' => $this->jumlah[0],
                    'harga' => $this->harga[0]
                ]);

                // if input more than 1
                if(count($this->inputs) > 0){
                    foreach($this->inputs as $key => $value){
                        $dist_sale->detail()->create([
                            'karat_id' => $this->karat_id[$value],
                            'berat_kotor' => $this->berat_kotor[$value],
                            'berat_bersih' => $this->berat_bersih[$value],
                            'jumlah' => $this->jumlah[$value],
                            'harga' => $this->harga[$value]
                        ]);
                    }
                }

                // dd($rawData);
                //  foreach ($this->no_invoice as $key => $value) {
                //     $harga = preg_replace("/[^0-9]/", "", $this->harga[$key]);
                //    // dd($harga);
                //     //GoodsReceipt::create(['code' => $this->code[$key], 'no_invoice' => $this->no_invoice[$key]]);
                // }
                
                $this->inputs = [];
                $this->resetInputFields();
                session()->flash('message', 'Created Successfully.');
                return redirect(route('iventory.index'));

            }




}
