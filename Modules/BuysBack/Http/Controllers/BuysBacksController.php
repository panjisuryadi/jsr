<?php

namespace Modules\BuysBack\Http\Controllers;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\BuysBack\Models\BuysBack;
use Modules\BuysBack\Models\BuysBackDetails;
use Modules\People\Entities\Supplier;
use Modules\People\Entities\Customer;
use Modules\BuysBack\Http\Requests\StoreBuyBackRequest;
use Lang;
use DB;
class BuysBacksController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Buys Back';
        $this->module_name =  'buysback';
        $this->module_path =  'buysbacks';
        $this->module_icon =  'fas fa-sitemap';
        $this->module_model = "Modules\BuysBack\Models\BuysBack";

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

  public function index() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }




public function index_data(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.aksi',
                            compact('module_name', 'data', 'module_model'));
                                })

                          ->editColumn('date', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <span class="text-xs text-gray-800">
                                     ' .tanggal($data->created_at) . '</span>
                                    </div>';
                                return $tb;
                            })

                          ->editColumn('status_barang', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <label class="bg-red-500 py-1 px-2 rounded reounded-xl text-xs text-white">
                                     ' .@$data->jenis->name . '</label>
                                    </div>';
                                return $tb;
                            })


                           ->editColumn('produk', function ($data) {
                             $tb = '<div class="font-semibold items-center text-center">
                                     ' .@$data->buysbacksDetails[0]->product_name . '
                                    </div>';
                                return $tb;
                            })

                               ->editColumn('name', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->reference . '</h3>
                                    </div>';
                                return $tb;
                            })


                           ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);
                            if ($diff < 25) {
                                return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                            } else {
                                return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                            }
                        })
                        ->rawColumns(['updated_at', 'action',
                         'status_barang', 'date', 'produk', 'name'])
                        ->make(true);
                     }







    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
        public function create()
        {
           $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'Create';
            abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.create',
               compact('module_name',
                'module_action',
                'module_title',
                'module_icon', 'module_model'));
        }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */

      public function type(Request $request) {

                $type = $request->type;
                $module_title = $this->module_title;
                $module_name = $this->module_name;
                $module_path = $this->module_path;
                $module_icon = $this->module_icon;
                $module_model = $this->module_model;

                    Cart::instance('purchase')->destroy();
                    if ($type == 'NonMember') {
                     return view(''.$module_name.'::'.$module_path.'.type.member');
                    }
                     elseif ($type == 'toko') {
                    return view(''.$module_name.'::'.$module_path.'.type.toko');
                    }
                    else {
                       return view(''.$module_name.'::'.$module_path.'.create');
                    }

            }




   public function saveTypeCustomer(StoreBuyBackRequest $request) {

        $params = $request->all();
        //dd($params);
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;
            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

          if ($request->customer == 1) {
              $customer_name = $request->customer_id;
              } else {
               $none_customer  = $request->none_customer;
               $customer_email = randomEmail($none_customer);
               $phone = $this->randomPhone();
               $customer_new =  customer::create([
                            'customer_name'  => $none_customer,
                            'customer_phone' => $phone,
                            'customer_email' => $customer_email,
                            'city'           => 'Jakarta',
                            'country'        => 'Indonesia',
                            'address'        => 'Jln. Jakarta no 123'
                        ]);

                $customer_name = $customer_new->id;
                //dd($customer_name);

           }

        $purchase = BuysBack::create([
                'date' => $request->date,
                'supplier_id' => null,
                'supplier_name' => 'none',
                'customer_id' => $customer_name,
                'customer_name' => Customer::findOrFail($customer_name)->customer_name,
                'jenis_buyback_id' => $request->jenis_buyback_id,
                'tax_percentage' => $request->tax_percentage,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => $request->status,
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('purchase')->tax() * 100,
                'discount_amount' => Cart::instance('purchase')->discount() * 100,
                'status' => 'Completed',
            ]);

            foreach (Cart::instance('purchase')->content() as $cart_item) {
                //dd($params);
                BuysBackDetails::create([
                    'purchase_id' => $purchase->id,
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
                    'location_id' => $request->location_id,

                ]);

            }
            Cart::instance('purchase')->destroy();
        });

        toast('BuyBacks Created!', 'success');

        return redirect()->route('buysback.index');
    }






 public function store(StoreBuyBackRequest $request) {

        $params = $request->all();
       // dd($params);
        DB::transaction(function () use ($request) {
            $due_amount = $request->total_amount - $request->paid_amount;
            if ($due_amount == $request->total_amount) {
                $payment_status = 'Unpaid';
            } elseif ($due_amount > 0) {
                $payment_status = 'Partial';
            } else {
                $payment_status = 'Paid';
            }

          if ($request->supplier == 1) {
              $supplier_name = $request->supplier_id;
              } else {
               $none_supplier  = $request->none_supplier;
               $supplier_email = randomEmail($none_supplier);
               $phone = $this->randomPhone();
               $supplier_new =  Supplier::create([
                            'supplier_name'  => $none_supplier,
                            'supplier_phone' => $phone,
                            'supplier_email' => $supplier_email,
                            'city'           => 'Jakarta',
                            'country'        => 'Indonesia',
                            'address'        => 'Jln. Jakarta no 123'
                        ]);
                $supplier_name = $supplier_new->id;
                // dd($supplier_name);

           }

        $purchase = BuysBack::create([
                'date' => $request->date,
                'kode_sales' => $request->kode_sales,
                'supplier_id' => $supplier_name,
                'supplier_name' => Supplier::findOrFail($supplier_name)->supplier_name,
                'tax_percentage' => $request->tax_percentage,
                'jenis_buyback_id' => $request->jenis_buyback_id,
                'discount_percentage' => $request->discount_percentage,
                'shipping_amount' => $request->shipping_amount * 100,
                'paid_amount' => $request->paid_amount * 100,
                'total_amount' => $request->total_amount * 100,
                'due_amount' => $due_amount * 100,
                'status' => 'Completed',
                'payment_status' => $payment_status,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'tax_amount' => Cart::instance('purchase')->tax() * 100,
                'discount_amount' => Cart::instance('purchase')->discount() * 100,
                'status' => 'Completed',
            ]);

            foreach (Cart::instance('purchase')->content() as $cart_item) {
                 // dd('purchase');
                BuysBackDetails::create([
                    'purchase_id' => $purchase->id,
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
                    'location_id' => $request->location_id,

                ]);
                  //add history purchases
                 }

            Cart::instance('purchase')->destroy();
            // if ($purchase->paid_amount > 0) {
            //     PurchasePayment::create([
            //         'date' => $request->date,
            //         'reference' => 'INV/'.$purchase->reference,
            //         'amount' => $purchase->paid_amount,
            //         'purchase_id' => $purchase->id,
            //         'payment_method' => $request->payment_method
            //     ]);
            // }
        });

        toast('Buys Back Created!', 'success');
        return redirect()->route('buysback.index');
    }


//store ajax version

public function store_ajax(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $validator = \Validator::make($request->all(),[
             'code' => 'required|max:191|unique:'.$module_model.',code',
             'name' => 'required|max:191',

        ]);


        if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $input = $request->except('_token');
        //$input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $input['code'] = $input['code'];
        $input['name'] = $input['name'];
        $$module_name_singular = $module_model::create($input);

        return response()->json(['success'=>'  '.$module_title.' Sukses disimpan.']);
    }










    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
public function show($id)
    {


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.show',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
       $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Edit';
        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
          return view(''.$module_name.'::'.$module_path.'.edit',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */



//update ajax version
public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';
        $$module_name_singular = $module_model::findOrFail($id);
        $validator = \Validator::make($request->all(),
            [
            'code' => [
                'required',
                'unique:'.$module_model.',code,'.$id
            ],
            'name' => 'required|max:191',


        ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        $input = $request->all();
        $params = $request->except('_token');
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
        $params['code'] = $params['code'];
        $params['name'] = $params['name'];
        $$module_name_singular->update($params);
        return response()->json(['success'=>'  '.$module_title.' Sukses diupdate.']);

 }



    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

        try {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Delete';

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->delete();
         toast(''. $module_title.' Deleted!', 'success');
         return redirect()->route(''.$module_name.'.index');

          } catch (\Exception $e) {
           // dd($e);
                toast(''. $module_title.' error!', 'warning');
                return redirect()->back();
            }

    }

private function randomPhone()
    {
        $countryCode = '+628'; // Change this to the desired country code
        $phone = $countryCode;
      // Generate random digits for the remaining 10 digits (excluding country code)
        for ($i = 0; $i < 10; $i++) {
            $phone .= rand(0, 9);
        }
        return $phone;
    }







}
