<?php

namespace App\Http\Livewire\GoodsReceipt;

use Livewire\Component;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;
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

     protected $rules = [
                'qty.0' => 'required',
                'qty.*' => 'required',
            ];
         public function updated($propertyName)
            {
                $this->validateOnly($propertyName);
            }


    public function store()
    {


        $validatedDate = $this->validate();

        // foreach ($this->code as $key => $value) {
        //     GoodsReceipt::create(['code' => $this->code[$key], 'no_invoice' => $this->no_invoice[$key]]);
        // }

        $this->inputs = [];

        $this->resetInputFields();

        session()->flash('message', 'Employee Has Been Created Successfully.');
    }


}
