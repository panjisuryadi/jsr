<?php

namespace App\Http\Livewire\Product;


        use Livewire\Component;
        use App\Http\Livewire\Field;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Validator;
        use Modules\GoodsReceipt\Models\GoodsReceipt;
        use Livewire\WithFileUploads;
        class Sales extends Component
        {
            use WithFileUploads;
            public $goodsreceipt,
             $berat_barang,
             $code,
             $no_invoice,
             $harga,
             $qty,
             $qty_diterima,
             $pengirim,
             $berat_real,
             $kategori,
             $berat_kotor,
             $berat_bersih,
             $jumlah,
             $kadar,
             $no_nota,
           
             $karat_id;
 
            public $updateMode = false;
            public $total_qty = 0;
            public $pilih_po = 1;
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
                 $this->goodsreceipt = GoodsReceipt::all();
                return view('livewire.product.sales');
            }

            private function resetInputFields(){
                $this->code = '';
                $this->karat_id = '';
                $this->kategori = '';
                $this->no_invoice = '';
                $this->qty = '';
                $this->berat_barang = '';
                $this->berat_real = '';
                $this->harga = '';
                $this->pengirim = '';
                $this->berat_kotor = '';
                $this->berat_bersih = '';
                $this->jumlah = '';
                $this->kadar = '';
                $this->no_nota = '';
                $this->pilih_po = '';
              
            }


               public function rules()
                {
                        $rules = [
                              'karat_id.0'     => 'required',
                              'karat_id.*'     => 'required', 
                              'jumlah.0'     => 'required',
                              'jumlah.*'     => 'required', 
                              'berat_kotor.0'     => 'required',
                              'berat_kotor.*'     => 'required',  
                              'berat_bersih.0'     => 'required',
                              'berat_bersih.*'     => 'required',
                              'no_nota.0'     => 'required',
                              'no_nota.*'     => 'required',
                               'kadar.0'     => 'required',
                              'kadar.*'     => 'required',
                              'kategori.0'     => 'required',
                              'code.*'         => 'required',  
                              'code.0'         => 'required',
                              'kategori.*'     => 'required',
                              'qty.0'          => 'required',
                              'qty.*'          => 'required'
                        ];

                        foreach($this->inputs as $key => $value)
                        {
                            $rules['code.0'] = 'required';
                            $rules['code.'.$value] = 'required';  
                            $rules['karat_id.0'] = 'required';
                            $rules['karat_id.'.$value] = 'required';
                            $rules['no_nota.0'] = 'required';
                            $rules['no_nota.'.$value] = 'required';
                            $rules['kadar.0'] = 'required';
                            $rules['kadar.'.$value] = 'required';
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

             public function pilihPo($value)
                {

                    //dd($value);
                    $this->pilih_po = $value;
                }

            public function updated($propertyName)
                {
                    $this->total_qty = 0;
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
