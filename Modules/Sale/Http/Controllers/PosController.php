<?php

namespace Modules\Sale\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Http\Requests\StorePosSaleRequest;



class PosController extends Controller
{

    public function index() {
        Cart::instance('sale')->destroy();

        $customers = Customer::all();
        $product_categories = Category::all();

        return view('sale::pos.index', compact('product_categories', 'customers'));
    }


    public function store(StorePosSaleRequest $request) {
        DB::transaction(function () use ($request) {

           // dd($request);

            $due_amount    = $request->total_amount - $request->paid_amount;
            $member        = $request->member;
            if ($member == 'member') {
               $customers     = $request->customer_id;
               $customers_name =  Customer::findOrFail($request->customer_id)->customer_name;
                //dd($customers_name);
            } else {
                $non_member = Customer::where('customer_email', 'non_member@hokkie.com')->first();
                if ($non_member !== null) {
                    $non_member->update(['customer_name' => 'Non Member']);
                } else {
                    $non_member = Customer::create([
                            'customer_name'  => 'Non Member',
                            'customer_phone' => '09393444',
                            'customer_email' => 'non_member@hokkie.com',
                            'city'           => 'bandung',
                            'country'        => 'id',
                            'address'        => 'dummy address'
                    ]);
                }
               $customers = $non_member->id;
               $customers_name = $non_member->customer_name;
            }


            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

            //dd($customers_name);
            $sale = Sale::create([
                'date' => now()->format('Y-m-d'),
                'reference' => 'PSL',
                'customer_id' => $customers,
                'customer_name' => $customers_name,
                'tax_percentage' => $request->tax_percentage ?? 0,
                'discount_percentage' => $request->discount_percentage ?? 0,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => 'Completed',
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('sale')->tax() * 100,
                'discount_amount' => Cart::instance('sale')->discount() * 100,
            ]);


           // dd($sale);

            foreach (Cart::instance('sale')->content() as $cart_item) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $cart_item->id,
                    'product_name' => $cart_item->name,
                    'product_code' => $cart_item->options->code,
                    'quantity' => $cart_item->qty,
                    'price' => $cart_item->price * 100,
                    'unit_price' => $cart_item->options->unit_price * 100,
                    'sub_total' => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type' => $cart_item->options->product_discount_type,
                    'product_tax_amount' => $cart_item->options->product_tax * 100,
                ]);

                $product = Product::findOrFail($cart_item->id);
                $product->update([
                    'product_quantity' => $product->product_quantity - $cart_item->qty
                ]);
            }

            Cart::instance('sale')->destroy();

            if ($sale->paid_amount > 0) {
                SalePayment::create([
                    'date' => now()->format('Y-m-d'),
                    'reference' => 'INV/'.$sale->reference,
                    'amount' => $sale->paid_amount,
                    'sale_id' => $sale->id,
                    'payment_method' => $request->payment_method
                ]);
            }
        });

        toast('POS Sale Created!', 'success');

        return redirect()->route('sales.index');
    }




   public function salesummary(Request $request){
        $grand_total = 0;
        if(isset($request->quantity)){
            foreach ($request->product_id as $key => $value) {
                $grand_total = $grand_total + ($request->quantity[$key] * $request->price[$key]);
            }
        }

        if(isset($request->discount_amount)){
            $discount = $grand_total*($request->discount_amount/100);
            $grand_total = $grand_total-$discount;
        }

        if(isset($request->order_tax)){
            $tax = $grand_total*($request->order_tax/100);
            $grand_total = $grand_total-$tax;
        }

        if(isset($request->shipping_amount)){
            $grand_total = $grand_total+$request->shipping_amount;
        }

        return response()->json([
            'discount' => number_format($discount),
            'tax' => number_format($tax),
            'shipping' => number_format($request->shipping_amount),
            'grand_total' => number_format($grand_total),
            'total_amount' => $grand_total
        ]);
    }











}
