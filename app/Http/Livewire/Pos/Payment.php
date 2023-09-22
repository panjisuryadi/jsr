<?php

namespace App\Http\Livewire\Pos;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class Payment extends Component
{
    public $listeners = ['cartModal'];
    public $total_with_shipping;
    public $bayar = 0;
    public $total_amount = 0;
    public $grandtotal = 0;
  
 public function updated()
{
    $this->grandtotal = ($this->total_amount ?? 0) + ($this->bayar ?? 0);
}

    public function render() {
        return view('livewire.pos.payment');
    }


public function calculate()
       {
           dd($this->grandtotal);
       }
   public function cartModal($product) {
       $this->product = $product;
    }

    public function updatedBayar(){

      $this->grandtotal = ($this->total_amount ?? 0) + ($this->bayar ?? 0);

      // dd($hasil);
    }

}
