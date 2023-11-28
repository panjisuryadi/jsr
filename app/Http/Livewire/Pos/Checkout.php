<?php

namespace App\Http\Livewire\Pos;

use Gloudemans\Shoppingcart\Facades\Cart;
use LivewireUI\Modal\ModalComponent;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Livewire\Component;

class Checkout extends Component
{


    public $listeners = ['productSelected',  'discountModalRefresh'];

    public $cart_instance;
    public $row_id;
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

    public $discount;
    public $paid_amount = '';
    public $diskon = 0;
    public $bayar = 0;
    public $kembali = 0;
    public $total = 0;
    public $keterangan = 0;


    public $keterangan_manual = '';
    public $manual = 0;
    public $manual_item = 0;
    public $manual_price = 0;

    public $sub_total = 0;
    public $sub_total_hidden = 0;
    public $discountAmount = 0;
    public $grand_total;
    public $show = false;
    public $showTunai = true;
    public $showTransfer = false;
    public $showEdc = false;
    public $loading = false;
    public $PaymentType;
    public $showPaymentType = 'tunai';


    protected function rules()
            {
               return [
                     'total_amount' => 'required|max:191',
                     'keterangan' => 'required|max:191',
                     'grand_total' => 'required|max:191',
                 

                ];
             }


   public function mount($cartInstance, $customers) {
        $this->cart_instance = $cartInstance;
        $this->customers = $customers;
        $this->customer_id = \Modules\People\Entities\Customer::limit(1)->first()->id;
        $this->global_discount = 0;
        $this->global_tax = 0;
        $this->shipping = 0.00;
        $this->check_quantity = [];
        $this->quantity = [];
        $this->discount_type = [];
        $this->item_discount = [];
        $this->cart = [];
        $this->total_amount;
        $this->manual_item;
        $this->manual_price;
        $this->manual;
        $this->row_id;
        $this->showPaymentType;
        $this->paid_amount;



    }


 public function PaymentType($type)
    {
        $this->loading = true;
        sleep(1);
        $this->showPaymentType = $type;
        $this->loading = false;
    }


 public function totalbayar()
       {
        //$this->resetInput();
        if ($this->paid_amount == 0  && $this->sub_total == 0) {
                $this->sub_total = $this->total_amount;
        }
       $subtotal = preg_replace("/[^0-9]/", "", $this->total_amount);
       $hitung_bayar = preg_replace("/[^0-9]/", "", $this->paid_amount);
       $kembalian = (int)$hitung_bayar - (int)$subtotal;
       $this->kembali = 'Rp ' . number_format($kembalian, 0, ',', '.');

       $this->grand_total = 'Rp ' . number_format($this->total_amount, 0, ',', '.');

        

    }


   

 public function recalculateTotal()
       {
        if ($this->total_amount == 0 
            && $this->diskon == 0) {
            $this->total = 0;
        }

       $hitung_bayar = preg_replace("/[^0-9]/", "", $this->total_amount);
       $hitung_diskon =preg_replace("/[^0-9]/", "", $this->diskon);
       $total = (int)$hitung_bayar - (int)$hitung_diskon;
      
     
      if ($hitung_diskon > $hitung_bayar) {
          session()->flash('pesan', 'Diskon melebihi jumlah yang dibayar.');
          $this->diskon = 0;
          $this->sub_total = $this->total_amount;
          $this->sub_total_hidden = $hitung_bayar;

        } else{
         $this->sub_total = 'Rp ' . number_format($total, 0, ',', '.');
         $this->grand_total = 'Rp ' . number_format($total, 0, ',', '.');
         $this->total =$total;
         $this->sub_total_hidden = $total;
        }
       // dd($hitung_bayar);
        

    }



    public function togglePanel()
    {
        $this->showEdc = false;
        $this->showTransfer = false;
        $this->loading = true;
        sleep(1);
        $this->showTunai = !$this->showTunai;
        $this->loading = false;
    }




  public function btnTransfer()
    {

        $this->showEdc = false;
        $this->showTunai = false;
        $this->loading = true;
        sleep(1);
      
        $this->showTransfer = !$this->showTransfer;
        $this->loading = false;
    }  

    public function btnEdc()
    {
        $this->showTransfer = false;
        $this->showTunai = false;
        $this->loading = true;
        sleep(1);
        $this->showEdc = !$this->showEdc;
        $this->loading = false;
    }

            public function hydrate() {
                //$this->total_amount = $this->calculateTotal();
                //$this->updatedCustomerId();
            }


         public function convertRupiah()
            {
            $this->paid_amount = 'Rp ' . number_format($this->paid_amount, 0, ',', '.');
            }

      public function grandtotal()
            {
            return Cart::instance($this->cart_instance)->total();
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
            session()->flash('message', 'Kustomer Belum dipilih!');
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

        $cart = Cart::instance($this->cart_instance);
        $exists = $cart->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id == $product['id'];
        });


        if (!isset($product['karat']['penentuan_harga']['harga_jual'])) {
            session()->flash('message', 'Penentuan Harga '.$product['karat']['name'].' Belum di setting!');
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
//'price'   => $product['karat']['penentuan_harga']['harga_jual']*$product['berat_emas'],
'price'   => $this->HitungHarga($product),
'weight'  => 1,
    'options' => [
        'product_discount'      => 0.00,
        'product_discount_type' => 'fixed',
        'sub_total'             => 1,
        'code'                  => $product['product_code'],
        'stock'                 => 1,
        'unit'                  =>$product['product_unit'],
        'karat_id'              =>$product['karat']['id'],
        'karat'                 =>$product['karat']['name'],
        'harga_jual'            => $this->HitungHarga($product),
        'berat_emas'            =>$product['berat_emas'],
        'product_tax'           => 1,
        'manual'                => 0,
        'manual_item'           => 0,
        'manual_price'          => 0,
        'unit_price'            => 1
                ]
         ]);

        $this->check_quantity[$product['id']] = 1;
        $this->quantity[$product['id']] = 1;
        $this->discount_type[$product['id']] = 'fixed';
        $this->item_discount[$product['id']] = 0;
        $this->total_amount = $this->calculateTotal();
        //$this->emit('cartModal', $product);
    }


   public function setManualtype()
    {
        $manual_price = $this->manual_price;
        $manual_item = $this->manual_item;
        $row_id = Cart::instance($this->cart_instance)->content()->first()->rowId;
        $this->updateManualOptions($row_id, $manual_item,$manual_price);
            session()->flash('manual', 'Manual tipe diupdate');
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
                'harga_jual'           => $cart_item->options->harga_jual,
                'product_tax'           => $cart_item->options->product_tax,
                'unit_price'            => $cart_item->options->unit_price,
                'product_discount'      => $cart_item->options->product_discount,
                'product_discount_type' => $cart_item->options->product_discount_type,
            ]
        ]);
    }



public function HitungHarga($product) {
        $totalPrice = 0;
        if (empty($product['product_price'])) {
            $totalPrice = $product['karat']['penentuanHarga']['harga_jual'] * $product['berat_emas'];
        }else{
            $totalPrice = $product['product_price'];
        }      

        return $totalPrice;
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
            'harga_jual'            => $cart_item->options->harga_jual,
            'product_discount'      => $discount_amount,
            'product_discount_type' => $this->discount_type[$product_id],
        ]]);
    }

    public function updateManualOptions($row_id, $manual_item,$manual_price) {
        Cart::instance($this->cart_instance)->update($row_id, ['options' => [
            'manual'                => 1,
            'manual_item'           => $manual_item,
            'manual_price'          => $manual_price,

        ]]);
    }





 public function store()
       {

        $input= $this->validate();
        $input['grand_total'] = preg_replace("/[^0-9]/", "", $this->grand_total);
        $input['diskon'] = preg_replace("/[^0-9]/", "", $this->diskon);
        $input['paid_amount'] = preg_replace("/[^0-9]/", "", $this->paid_amount);
        $input['kembali'] = preg_replace("/[^0-9]/", "", $this->kembali);
        dd($input);



      
       }








}
