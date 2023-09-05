<?php

namespace App\Http\Livewire\Product;


        use Livewire\Component;
        use App\Http\Livewire\Field;
        use App\Models\User;
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
             $kasir,
           
             $karat_id;
 
            public $updateMode = false;
            public $total_qty = 0;
            public $pilih_po = 300;
            public $pilih_tipe_pembayaran = 'cicil';
            public $inputs = [];
            public $sales = [];
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
                 $this->kasir = User::role('Kasir')->orderBy('name')->get();
                return view('livewire.product.sales');
            }



            private function resetInput()
                {
                    $this->sales['invoice'] = null;
                    $this->sales['date'] = null;
                    $this->sales['nama_sales'] = null;
                    $this->sales['user_id'] = null;
                  
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
                              'sales.invoice' => 'required|string|max:50',
                              'sales.date' => 'required',
                              'sales.nama_sales' => 'required',
                              'sales.user_id' => 'required',
                              'jumlah.0'     => 'required',
                              'jumlah.*'     => 'required', 
                              'berat_kotor.0'     => 'required',
                              'berat_kotor.*'     => 'required',  
                              'berat_bersih.0'     => 'required',
                              'berat_bersih.*'     => 'required',
                              'no_nota.0'     => 'required',
                              'no_nota.*'     => 'required',
                              'kadar.0'     => 'required',
                              'kadar.*'     => 'required'
                        ];

                        foreach($this->inputs as $key => $value)
                        {
                            
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


             public function convertRupiah()
            {
                $this->product_price = 'Rp ' . number_format($this->price, 0, ',', '.');
            }



}
