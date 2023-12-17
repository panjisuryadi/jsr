<?php

namespace App\Http\Livewire\Pos;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Livewire\Component;
use Modules\Cabang\Models\Cabang;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Sale\Entities\SaleManual;

class Checkout extends Component
{

    public $cabangs;
    public $cabang_id;
    public $other_fees = [];
    public $payment_method = '';
    public $paid_amount = 0;
    public $return_amount = 0;
    public $note = '';
    public $listeners = ['productSelected',  'discountModalRefresh'];

    public $cart_instance;
    public $row_id;
    public $customers;
    public $data;
    public $customer_id;
    public $total_amount;

    public $discount;
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

    public function getTotalAmountTextProperty()
    {
        return format_uang($this->total_amount);
    }

    public function getGrandTotalTextProperty()
    {
        return format_uang($this->grand_total);
    }

    public function updatedDiskon($value)
    {
        if ($value != '' && $value > 0) {
            $this->calculateGrandTotal();
        }
    }

    public function add_other_fee()
    {
        $this->other_fees[] = [
            'nominal' => 0,
            'note' => ''
        ];
    }

    public function remove_other_fee($index)
    {
        unset($this->other_fees[$index]);
        $this->calculateGrandTotal();
    }

    public function updatedPaidAmount($value)
    {
        if ($value != '' && $value >= $this->grand_total) {
            $this->return_amount = $value - $this->grand_total;
        }
    }

    public function getReturnAmountTextProperty()
    {
        return format_uang($this->return_amount);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }



    protected function rules()
    {
        $rules = [
            'cabang_id' => 'required',
            'diskon' => 'gt:-1',
            'payment_method' => 'required',
            'paid_amount' => [
                'required_if:payment_method,tunai',
                function ($attribute, $value, $fail) {
                    if ($this->payment_method === 'tunai') {
                        if (empty($value)) {
                            $fail('Wajib diisi');
                        }
                        if ($value < $this->grand_total) {
                            $fail('Jumlah yang dibayarkan tidak cukup.');
                        }
                    }
                },
            ],
            'total_amount' => 'required|max:191',
            'grand_total' => 'required|max:191',
        ];

        foreach ($this->other_fees as $index => $fee) {
            $rules['other_fees.' . $index . '.note'] = ['required'];
            $rules['other_fees.' . $index . '.nominal'] = ['required', 'gt:0'];
        }

        return $rules;
    }


    public function mount($cartInstance, $customers)
    {
        $this->cart_instance = $cartInstance;
        $this->customers = $customers;
        $this->customer_id = null;
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
        $this->cabangs = Cabang::all();
        $this->cabang_id = auth()->user()->isUserCabang() ? auth()->user()->namacabang()->id : '';
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
        if (
            $this->total_amount == 0
            && $this->diskon == 0
        ) {
            $this->total = 0;
        }

        $hitung_bayar = preg_replace("/[^0-9]/", "", $this->total_amount);
        $hitung_diskon = preg_replace("/[^0-9]/", "", $this->diskon);
        $total = (int)$hitung_bayar - (int)$hitung_diskon;


        if ($hitung_diskon > $hitung_bayar) {
            session()->flash('pesan', 'Diskon melebihi jumlah yang dibayar.');
            $this->diskon = 0;
            $this->sub_total = $this->total_amount;
            $this->sub_total_hidden = $hitung_bayar;
        } else {
            $this->sub_total = 'Rp ' . number_format($total, 0, ',', '.');
            $this->grand_total = 'Rp ' . number_format($total, 0, ',', '.');
            $this->total = $total;
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

    public function hydrate()
    {
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



    public function render()
    {
        $cart_items = Cart::instance($this->cart_instance)->content();
        return view('livewire.pos.checkout', [
            'cart_items' => $cart_items
        ]);
    }



    public function proceed()
    {


        //  $cart = $this->total_amount;
        $cart = [
            "customer_id" => $this->customer_id,
            "total_amount" => $this->total_amount,
            "paid" => $this->total_amount
        ];
        // dd($cart);
        $this->emit('cartAdded', $cart);
        $this->dispatchBrowserEvent(
            'showCheckoutModal',
            [
                'customer_id' => $this->customer_id

            ]
        );
    }

    public function selectcartModal()
    {
        $cart = Cart::instance($this->cart_instance)->content();
        //$this->emit('cartModal', $cart);
    }

    public function calculateTotal()
    {
        $this->total_amount = Cart::instance($this->cart_instance)->total() + $this->shipping;
    }

    public function resetCart()
    {
        Cart::instance($this->cart_instance)->destroy();
    }

    public function productSelected(Product $product)
    {
        $cart = Cart::instance($this->cart_instance);
        $exists = $cart->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id == $product->id;
        });


        if (empty($product->product_price) && empty($product->karat->penentuanHarga->harga_jual)) {
            session()->flash('message', 'Penentuan Harga ' . $product->karat->label . ' Belum di setting!');
            return;
        }

        if ($exists->isNotEmpty()) {
            session()->flash('message', 'Product exists in the cart!');
            return;
        }

        $cart->add([
            'id'      => $product->id,
            'name'    => $product->product_name,
            'qty'     => 1,
            //'price'   => $product['karat']['penentuan_harga']['harga_jual']*$product['berat_emas'],
            'price'   => $this->HitungHarga($product),
            'weight'  => 1,
            'options' => [
                'product_discount'      => 0.00,
                'product_discount_type' => 'fixed',
                'sub_total'             => 1,
                'code'                  => $product->product_code,
                'stock'                 => 1,
                'unit'                  => $product->product_unit,
                'karat_id'              => $product->karat_id,
                'karat'                 => $product->karat->label,
                'harga_jual'            => $this->HitungHarga($product),
                'berat_emas'            => $product->berat_emas,
                'images'                => $product->images,
                'product_tax'           => 1,
                'manual'                => 0,
                'manual_item'           => 0,
                'manual_price'          => 0,
                'unit_price'            => 1
            ]
        ]);

        $this->check_quantity[$product->id] = 1;
        $this->quantity[$product->id] = 1;
        $this->discount_type[$product->id] = 'fixed';
        $this->item_discount[$product->id] = 0;
        $this->calculateTotal();
        $this->calculateGrandTotal();
        //$this->emit('cartModal', $product);
    }

    public function calculateGrandTotal()
    {
        $this->grand_total = ($this->total_amount - $this->diskon) + $this->totalOtherFees();
        if ($this->payment_method === 'tunai') {
            $this->return_amount = $this->paid_amount - $this->grand_total;
        }
    }

    private function totalOtherFees()
    {
        $total = 0;
        if (count($this->other_fees)) {
            foreach ($this->other_fees as $fee) {
                if ($fee['nominal'] > 0) {
                    $total += $fee['nominal'];
                }
            }
        }
        return $total;
    }


    public function setManualtype()
    {
        $manual_price = $this->manual_price;
        $manual_item = $this->manual_item;
        $row_id = Cart::instance($this->cart_instance)->content()->first()->rowId;
        $this->updateManualOptions($row_id, $manual_item, $manual_price);
        session()->flash('manual', 'Manual tipe diupdate');
    }



    public function removeItem($row_id)
    {
        Cart::instance($this->cart_instance)->remove($row_id);
        $this->calculateTotal();
        $this->calculateGrandTotal();
    }



    public function updatedGlobalTax()
    {
        Cart::instance($this->cart_instance)->setGlobalTax((int)$this->global_tax);
    }



    public function updatedGlobalDiscount()
    {
        Cart::instance($this->cart_instance)->setGlobalDiscount((int)$this->global_discount);
    }



    public function updateQuantity($row_id, $product_id)
    {
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



    public function HitungHarga($product)
    {
        $totalPrice = 0;
        if (empty($product->product_price)) {
            $totalPrice = $product->karat->penentuanHarga->harga_jual * $product->berat_emas;
        } else {
            $totalPrice = $product->product_price;
        }
        return $totalPrice;
    }



    public function updatedDiscountType($value, $name)
    {
        $this->item_discount[$name] = 0;
    }





    public function discountModalRefresh($product_id, $row_id)
    {
        $this->updateQuantity($row_id, $product_id);
    }


    //set utk diskon
    public function setProductDiscount($row_id, $product_id)
    {
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








    public function calculate($product)
    {
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





    public function updateCartOptions($row_id, $product_id, $cart_item, $discount_amount)
    {
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

    public function updateManualOptions($row_id, $manual_item, $manual_price)
    {
        Cart::instance($this->cart_instance)->update($row_id, ['options' => [
            'manual'                => 1,
            'manual_item'           => $manual_item,
            'manual_price'          => $manual_price,

        ]]);
    }





    public function store()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $sale = Sale::create([
                'date' => date('Y-m-d'),
                'reference' => 'jsr',
                'customer_id' => !empty($this->customer_id)?$this->customer_id:null,
                'customer_name' => Customer::find($this->customer_id)?->customer_name,
                'total_amount' => $this->total_amount,
                'grand_total_amount' => $this->grand_total,
                'other_total_amount' => $this->totalOtherFees(),
                'discount_amount' => !empty($this->diskon)?$this->diskon:0,
                'note' => !empty($this->note)?$this->note:null,
                'user_id' => Auth::user()->id,
                'cabang_id' => $this->cabang_id,
            ]);
            foreach (Cart::instance('sale')->content() as $cart_item) {
                $detail = SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'price' => $cart_item->options->harga_jual,
                    'unit_price' => 1,
                    'product_discount_amount' => 0,
                    'product_tax_amount' => 0,

                ]);
                $detail->product->updateTracking(ProductStatus::SOLD, $sale->cabang_id);
            }

            // sale manual
            $this->manageSaleManual($sale);

            // payment
            $this->managePayment($sale);

            Cart::instance('sale')->destroy();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        toast('POS Sale Created!', 'success');
        return redirect()->route('sales.index');
    }

    private function managePayment($sale){
        $data = [
            'date' => now()->format('Y-m-d'),
            'reference' => 'INV/'.$sale->reference,
            'paid_amount' => $this->paid_amount,
            'payment_method' => $this->payment_method
        ];
        if($this->payment_method === 'tunai'){
            $data['return_amount'] = $this->return_amount;
        }
        $sale->salePayments()->create($data);
    }

    private function manageSaleManual($sale){
        if (count($this->other_fees)) {
            foreach($this->other_fees as $index => $fee){
                $sale->manual()->create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/' . $sale->reference,
                    'nominal' => $fee['nominal'],
                    'note' => $fee['note']
                ]);
            }
        }
    }
}
