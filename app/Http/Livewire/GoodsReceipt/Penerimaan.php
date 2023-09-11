<?php

namespace App\Http\Livewire\GoodsReceipt;

        use Livewire\Component;
        use App\Http\Livewire\Field;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Validator;
        use Modules\GoodsReceipt\Models\GoodsReceipt;
        use App\Models\User;
        use Livewire\WithFileUploads;
        class Penerimaan extends Component
        {
            use WithFileUploads;
            public $goodsreceipt,
             $berat_barang,
             $code,
             $no_invoice,
             $harga,
             $berat_kotor,
             $berat_timbangan,
             $qty_diterima,
             $pengirim,
             $berat_real,
             $kategori,
             $karat_id;

            public $updateMode = false;
            public $total_qty = 0;
            public $total_berat = 0;
            public $pilih_tipe_pembayaran = 'cicil';
            public $inputs = [];
            public $i = 1;

            public function add($i)
            {
                $i = $i + 1;
                $this->i = $i;
                array_push($this->inputs ,$i);
            }

            public function remove($i)
            {
                unset($this->inputs[$i]);
            }

            public function render()

            {
                 $this->kasir = User::role('Kasir')->orderBy('name')->get();
                 $this->goodsreceipt = GoodsReceipt::all();
                return view('livewire.goods-receipt.penerimaan');
            }

            private function resetInputFields(){
                $this->karat_id = '';
                $this->kategori = '';
                $this->no_invoice = '';
                $this->berat_kotor = '';
                $this->berat_barang = '';
                $this->berat_real = '';
                $this->harga = '';
                $this->pengirim = '';
            }


               public function rules()
                {
                        $rules = [
                              'karat_id.0'     => 'required',
                              'karat_id.*'     => 'required',

                              'kategori.0'     => 'required',
                              'kategori.*'     => 'required',

                              'berat_real.0'     => 'required',
                              'berat_real.*'     => 'required',

                              'berat_kotor.0'     => 'required',
                              'berat_kotor.*'     => 'required'
                        ];

                        foreach($this->inputs as $key => $value)
                        {
                            $rules['kategori.0'] = 'required';
                            $rules['kategori.'.$value] = 'required';

                            $rules['berat_real.0'] = 'required';
                            $rules['berat_real.'.$value] = 'required';

                            $rules['berat_kotor.0'] = 'required';
                            $rules['berat_kotor.'.$value] = 'required';


                            $rules['karat_id.0'] = 'required';
                            $rules['karat_id.'.$value] = 'required';

                        }
                        return $rules;
                   }


                public function messages()
                {
                    $messages = [];
                      foreach($this->inputs as $key => $value)
                      {
                        $messages['qty.0'] = 'required';
                        $messages['qty.'.$value] = 'required';
                        $messages['kategori.0'] = 'kosong';
                        $messages['kategori.'.$value] = 'kosong';
                        $messages['karat_id.0'] = 'required';
                        $messages['karat_id.'.$value] = 'required';
                      }
                      return $messages;

                }




            public function changeEvent($value)
                {
                    $this->pilih_tipe_pembayaran = $value;
                }



            public function updated($propertyName)
                { 

                   
                    
                    if ($this->inputs) {
                        $this->validateOnly($propertyName);
                    }
                }


          
            public function store()
            {

                 $this->validate();
                 foreach ($this->no_invoice as $key => $value) {
                    $harga = preg_replace("/[^0-9]/", "", $this->harga[$key]);
                   // dd($harga);
                    //GoodsReceipt::create(['code' => $this->code[$key], 'no_invoice' => $this->no_invoice[$key]]);
                }

                $this->inputs = [];

                $this->resetInputFields();

                session()->flash('message', 'Created Successfully.');
                      }


             public function convertRupiah()
                {
                    $this->product_price = 'Rp ' . number_format($this->price, 0, ',', '.');
                }



}
