<?php

namespace App\Http\Livewire\Pos;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class Payment extends Component
{
    public $listeners = ['cartModal'];
    public $cart_instance;
    public $customers;
    public $global_discount;
    public $global_tax;
    public $shipping;
    public $quantity;
    public $check_quantity;
    public $discount_type;
    public $item_discount;
    public $data;
    public $customer_id;
    public $product;
    public $total_amount;
    public $cart_items;

 

    public function mount() {
        $this->product = 0;
    }



    public function render() {
        $cart_items =0;
        return view('livewire.pos.payment', [
            'cart_items' =>$this->cart_items
        ]);
    }

   public function cartModal($product) {
       $this->product = $product;
    }


}
