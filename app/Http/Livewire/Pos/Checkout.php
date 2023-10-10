<?php

namespace App\Http\Livewire\Pos;

use Gloudemans\Shoppingcart\Facades\Cart;
use LivewireUI\Modal\ModalComponent;
use Livewire\Component;

class Checkout extends Component
{


    public $listeners = ['productSelected',  'discountModalRefresh'];

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
    public $total_amount;
    public $paid_amount;
    public $show = false;
    public $showPanel = true;
    public $showTransfer = false;
    public $showEdc = false;
    public $loading = false;

    public function togglePanel()
    {
        $this->showEdc = false;
        $this->showTransfer = false;
        $this->loading = true;
        sleep(1);
        $this->showPanel = !$this->showPanel;
        $this->loading = false;
    }

  public function btnTransfer()
    {

        $this->showEdc = false;
        $this->showPanel = false;
        $this->loading = true;
        sleep(1);
      
        $this->showTransfer = !$this->showTransfer;
        $this->loading = false;
    }  

    public function btnEdc()
    {
        $this->showTransfer = false;
        $this->showPanel = false;
        $this->loading = true;
        sleep(1);
        $this->showEdc = !$this->showEdc;
        $this->loading = false;
    }



    public function mount($cartInstance, $customers) {
        $this->cart_instance = $cartInstance;
        $this->customers = $customers;
        $this->global_discount = 0;
        $this->global_tax = 0;
        $this->shipping = 0.00;
        $this->check_quantity = [];
        $this->quantity = [];
        $this->discount_type = [];
        $this->item_discount = [];
        $this->cart = [];
        $this->total_amount;
        $this->paid_amount;
        $this->grand_total = 0;
    }

    public function hydrate() {
        $this->total_amount = $this->calculateTotal();
        $this->updatedCustomerId();
    }

       public function hitung()
       {
          //dd('sdsdsds');
       }
    public function render() {
        $cart_items = Cart::instance($this->cart_instance)->content();
        return view('livewire.pos.checkout', [
            'cart_items' => $cart_items
        ]);
    }

    public function proceed() {
        if ($this->customer_id != null) {
           //  $cart = $this->total_amount;
             $cart = [
                   "customer_id" => $this->customer_id,
                   "total_amount" => $this->total_amount,
                   "paid" => $this->total_amount];
           // dd($cart);
             $this->emit('cartAdded', $cart);
             $this->dispatchBrowserEvent('showCheckoutModal', 
                [  
                    'customer_id' => $this->customer_id

                 ]);
          
          
        } else {
            session()->flash('message', 'Please Select Customer!');
        }
    }

     public function selectcartModal() {
         $cart = Cart::instance($this->cart_instance)->content();
         //$this->emit('cartModal', $cart);
    }

    public function calculateTotal() {
        return Cart::instance($this->cart_instance)->total() + $this->shipping;
    }

    public function resetCart() {
        Cart::instance($this->cart_instance)->destroy();
    }

    public function productSelected($product) {

      //  dd($product['product_item'][0]['karat']['penentuan_harga']['harga_emas']);

        $cart = Cart::instance($this->cart_instance);
        $exists = $cart->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id == $product['id'];
        });


        if (!isset($product['product_item'][0]['karat']['penentuan_harga']['harga_emas'])) {
            session()->flash('message', 'Penentuan Harga '.$product['product_item'][0]['karat']['name'].' Belum di setting!');
            return;
        } 

 
        if ($exists->isNotEmpty()) {
            session()->flash('message', 'Product exists in the cart!');
            return;
        }

        $cart->add([
        'id'      => $product['id'],
        'name'    => $product['product_name'],
        'qty'     => 1,
        'price'   => $product['product_item'][0]['karat']['penentuan_harga']['harga_emas'],
        'weight'  => 1,
            'options' => [
                'product_discount'      => 0.00,
                'product_discount_type' => 'fixed',
                'sub_total'             => 1,
                'code'                  => $product['product_code'],
                'stock'                 => 1,
                'unit'          =>$product['product_unit'],
                'karat_id'      =>$product['product_item'][0]['karat']['id'],
                'karat'         =>$product['product_item'][0]['karat']['name'],
                'harga_karat'   =>$product['product_item'][0]['karat']['penentuan_harga']['harga_emas'],

                'product_tax'           => 1,
                'unit_price'            =>1
            ]
            ]);

        $this->check_quantity[$product['id']] = 1;
        $this->quantity[$product['id']] = 1;
        $this->discount_type[$product['id']] = 'fixed';
        $this->item_discount[$product['id']] = 0;
        $this->total_amount = $this->calculateTotal();
        //$this->emit('cartModal', $product);
    }

    public function removeItem($row_id) {
        Cart::instance($this->cart_instance)->remove($row_id);
    }

    public function updatedGlobalTax() {
        Cart::instance($this->cart_instance)->setGlobalTax((integer)$this->global_tax);
    }

    public function updatedGlobalDiscount() {
        Cart::instance($this->cart_instance)->setGlobalDiscount((integer)$this->global_discount);
    }

    public function updateQuantity($row_id, $product_id) {
        if ($this->check_quantity[$product_id] < $this->quantity[$product_id]) {
            session()->flash('message', 'The requested quantity is not available in stock.');

            return;
        }

        Cart::instance($this->cart_instance)->update($row_id, $this->quantity[$product_id]);

        $cart_item = Cart::instance($this->cart_instance)->get($row_id);

        Cart::instance($this->cart_instance)->update($row_id, [
            'options' => [
                'sub_total'             => $cart_item->price * $cart_item->qty,
                'code'                  => $cart_item->options->code,
                'stock'                 => $cart_item->options->stock,
                'unit'                  => $cart_item->options->unit,
                'product_tax'           => $cart_item->options->product_tax,
                'unit_price'            => $cart_item->options->unit_price,
                'product_discount'      => $cart_item->options->product_discount,
                'product_discount_type' => $cart_item->options->product_discount_type,
            ]
        ]);
    }

    public function updatedDiscountType($value, $name) {
        $this->item_discount[$name] = 0;
    }

    public function discountModalRefresh($product_id, $row_id) {
        $this->updateQuantity($row_id, $product_id);
    }


//set utk diskon
    public function setProductDiscount($row_id, $product_id) {
        $cart_item = Cart::instance($this->cart_instance)->get($row_id);

        if ($this->discount_type[$product_id] == 'fixed') {
            Cart::instance($this->cart_instance)
                ->update($row_id, [
                    'price' => ($cart_item->price + $cart_item->options->product_discount) - $this->item_discount[$product_id]
                ]);

            $discount_amount = $this->item_discount[$product_id];

            $this->updateCartOptions($row_id, $product_id, $cart_item, $discount_amount);
        } elseif ($this->discount_type[$product_id] == 'percentage') {
            $discount_amount = ($cart_item->price + $cart_item->options->product_discount) * ($this->item_discount[$product_id] / 100);

            Cart::instance($this->cart_instance)
                ->update($row_id, [
                    'price' => ($cart_item->price + $cart_item->options->product_discount) - $discount_amount
                ]);

            $this->updateCartOptions($row_id, $product_id, $cart_item, $discount_amount);
        }

        session()->flash('discount_message' . $product_id, 'Discount added to the product!');
    }


    public function calculate($product) {
        $price = 0;
        $unit_price = 0;
        $product_tax = 0;
        $sub_total = 0;

        // if ($product['product_tax_type'] == 1) {
        //     $price = 1000;
        //     $unit_price = 1000;
        //     $product_tax = 100;
        //     $sub_total = 1000;
        // } 

        // elseif ($product['product_tax_type'] == 2) {
        //     $price = $product['product_price'];
        //     $unit_price = $product['product_price'] - ($product['product_price'] * ($product['product_order_tax'] / 100));
        //     $product_tax = $product['product_price'] * ($product['product_order_tax'] / 100);
        //     $sub_total = $product['product_price'];
        // } else {
        //     $price = $product['product_price'];
        //     $unit_price = $product['product_price'];
        //     $product_tax = 0.00;
        //     $sub_total = $product['product_price'];
        // }

        return ['price' => $price, 'unit_price' => $unit_price, 'product_tax' => $product_tax, 'sub_total' => $sub_total];
    }

    public function updateCartOptions($row_id, $product_id, $cart_item, $discount_amount) {
        Cart::instance($this->cart_instance)->update($row_id, ['options' => [
            'sub_total'             => $cart_item->price * $cart_item->qty,
            'code'                  => $cart_item->options->code,
            'stock'                 => $cart_item->options->stock,
            'unit'                  => $cart_item->options->unit,
            'product_tax'           => $cart_item->options->product_tax,
            'unit_price'            => $cart_item->options->unit_price,
            'product_discount'      => $discount_amount,
            'product_discount_type' => $this->discount_type[$product_id],
        ]]);
    }
}
