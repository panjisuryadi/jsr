<?php

namespace App\Http\Livewire\GoodsReceipt;


        use Livewire\Component;
        use App\Http\Livewire\Field;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Validator;
        use Modules\GoodsReceipt\Models\GoodsReceipt;

        class Goodsreceipts extends Component
        {
            public $goodsreceipt,
             $berat_barang,
             $code,
             $no_invoice,
             $qty,
             $qty_diterima,
             $pengirim,
             $berat_real,
             $employee_id;
            public $updateMode = false;
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
                return view('livewire.goods-receipt.goodsreceipt');
            }

            private function resetInputFields(){
                $this->code = '';
                $this->no_invoice = '';
                $this->qty = '';
                $this->berat_barang = '';
                $this->berat_real = '';
                $this->pengirim = '';
            }


               public function rules()
                {
                        $rules = [
                              'no_invoice.0'     => 'required',
                              'no_invoice.*'     => 'required',
                              'qty.0'     => 'required',
                              'qty.*'     => 'required'
                        ];

                        foreach($this->inputs as $key => $value)
                        {
                            $rules['qty.0'] = 'required';
                            $rules['no_invoice.0'] = 'required';
                            $rules['qty.'.$value] = 'required';
                            $rules['no_invoice.'.$value] = 'required';

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
                        $messages['no_invoice.0'] = 'required';
                        $messages['no_invoice.'.$value] = 'required';
                      }
                      return $messages;

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


                // foreach ($this->code as $key => $value) {
                //     GoodsReceipt::create(['code' => $this->code[$key], 'no_invoice' => $this->no_invoice[$key]]);
                // }

                $this->inputs = [];

                $this->resetInputFields();

                session()->flash('message', 'Created Successfully.');
            }


}
