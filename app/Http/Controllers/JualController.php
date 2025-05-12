<?php


namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Category;
use Modules\Group\Models\Group;
use Modules\Product\Entities\Product;
use App\Models\SalesGold;
use App\Models\SalesItem;
use App\Models\Service;
use App\Models\Harga;
use App\Models\Config;
use App\Models\ProductHistories;
use Modules\Product\Entities\ProductItem;
use Modules\Sale\Entities\Sale;
use Modules\Sale\Entities\SaleDetails;
use Modules\Sale\Entities\SalePayment;
use Modules\Sale\Entities\SaleManual;
use Modules\Sale\Http\Requests\StorePosSaleRequest;
use PDF;
use Auth;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Product\Models\ProductStatus;
use Yajra\DataTables\DataTables;
use Modules\Karat\Models\Karat;
use Modules\ProdukModel\Models\ProdukModel;

class JualController extends Controller
{

    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_detail;
    private $module_payment;
    private $module_product;

    public function __construct()
    {
        $this->module_title = 'Sale';

        $this->module_name = 'sales';

        $this->module_path = 'sale';

        $this->module_icon = 'fas fa-sitemap';

        $this->module_model = "Modules\Sale\Entities\Sale";
        $this->module_detail = "Modules\Sale\Entities\SaleDetails";
        $this->module_payment = "Modules\Sale\Entities\SalePayment";
        $this->module_product = "Modules\Product\Entities\Product";
    }


    public function list() {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        Cart::instance('sale')->destroy();
        $karat  = Karat::latest()->get();
        $category  = Category::latest()->get();
        $group  = Group::latest()->get();
        $models  = ProdukModel::latest()->get();
        $customers = Customer::all();
        $product_categories = Category::all();

        return view('Sale.list', compact('product_categories', 'customers', 'karat', 'category', 'group', 'models'));
    }

    public function test_pdf(){
        $data = [
            'title' => 'Nota Emas',
            'date' => date('d/m/Y H:i:s'),
            'products' => [
                ['name' => 'Produk A', 'code' => 'CEmas 17K160125435', 'gram' => 1, 'price' => 10000],
                ['name' => 'Produk B', 'code' => 'GEMAS 375140225232', 'gram' => 2, 'price' => 15000],
                ['name' => 'Produk B', 'code' => 'GEMAS 375140225232', 'gram' => 2, 'price' => 15000],
            ]
        ];

        $pdf = PDF::loadView('sale.invoice', $data)->setPaper('a5', 'landscape');
        return $pdf->stream('invoice.pdf');
        // return $pdf->download('invoice.pdf');
    }

    public function insert(Request $request){
        $config = Config::where('name', 'nota')->first();
        $value   = $config->value;
        $val    = json_decode($value, true);
        $alamat = $val['alamat'];
        $telp = $val['telp'];
        $info = $val['info'];

        $products   = array();        
        $services   = array();        
        $total      = 0;
        $number     = 0;
        $nama_cus   = '';
        if($request->customer != '0'){
            $customer   = Customer::where('id', $request->customer)->first();
            $nama_cus   = $customer->customer_name;
            $address    = $customer->address;
            //         $nama_cus   = '
            // <p style="text-align: right; font-size:13px">Kepada Yth : '.$nama_cus.'</p>
            //         ';
        }
        foreach ($request->product as $p) {
            if($p == 0){ // SERVICE NON PRODUCT
                $services[] = $p;
            }else{
                if(in_array($p, $products)){
                    return redirect()->action([JualController::class, 'list']);
                }
                $products[] = $p;
            }
            $harga  = $request->harga[$number];

            $total  = $total+$harga;
            $number++;
        }
        // INSERT SALES
        // $nomor  = '0000000001';
        $nomor  = SalesGold::latest()->first();
        // echo json_encode($nomor);
        // exit();
        $nomor  = $nomor->nomor;
        $nomor  = (int)$nomor+1;
        for ($i=0; $i < 8; $i++) { 
            if(strlen($nomor) !== $i){
                $nomor  = '0'.$nomor;
            }
        }

        $salesGold  = SalesGold::create([
            'nomor' => $nomor,
            'customer' => $request->customer,
            'products' => json_encode($products),
            'services' => json_encode($services),
            'total' => $total,
        ]);
        $id = $salesGold->id;

        // UPDATE STATUS PRODUCT
        $data   = array();
        $number     = 0;
        foreach ($request->product as $p) {
            if($p == 0){ // SERVICE NON PRODUCT
                $title  = 'Faktur';
                $name   = $request->product_name[$number];
                $desc   = $request->product_desc[$number];
                $gram   = '-';
                $images = '';
                $harga  = $request->harga[$number];

                $serv   = Service::create([
                    'sales' => $id,
                    'name'  => $name,
                    'desc'  => $desc,
                    'total' => $harga
                ]);

                $product_history = ProductHistories::create([
                    'product_id'    => $p,
                    'status'        => 'S',
                    'keterangan'    => $id,
                    'harga'         => $request->harga[$number],
                    'tanggal'       => date('Y-m-d'),
                ]);
            }else{
                $title  = 'Nota Emas';
                $product= Product::where('id', $p)->firstOrFail();
                $name   = $product->product_name;
                $images = $product->images;
                $desc   = $product->product_code;
                $gram   = $product->berat_emas;
                $harga  = $request->harga[$number];
                $product->status_id = 2;
                $product->save();

                // INSERT KE PRODUCT HISTORY
                $product_history = ProductHistories::create([
                    'product_id'    => $p,
                    'status'        => 'S',
                    'keterangan'    => 'terjual',
                    'harga'         => $request->harga[$number],
                    'tanggal'       => date('Y-m-d'),
                ]);
            }

            // INSERT SALES ITEMS
            $salesNomor = SalesItem::latest()->first();
            $salesNomor = $salesNomor->nomor != null ? $salesNomor->nomor : '0000000001';
            $salesNomor  = (int)$salesNomor+1;
            for ($i=0; $i < 9; $i++) { 
                if(strlen($salesNomor) !== $i){
                    $salesNomor  = '0'.$salesNomor;
                }
            }
            $salesItem  = SalesItem::create([
                'nomor'     => $salesNomor,
                'product'   => $p,
                'name'      => $name,
                'desc'      => $desc,
                'total'     => $harga,
            ]);
            $sales_id   = $salesItem->id;

            for ($i=0; $i < 8; $i++) { 
                if(strlen($sales_id) !== $i){
                    $sales_id  = '0'.$sales_id;
                }
            }

            $array['products'][$number]['title'] = $title;
            $array['products'][$number]['img'] = $images;
            $array['products'][$number]['name'] = $name;
            $array['products'][$number]['desc'] = $desc;
            $array['products'][$number]['gram'] = $gram;
            $array['products'][$number]['harga'] = $harga;
            $array['products'][$number]['nomor'] = $salesNomor;
            $array['products'][$number]['sales_id'] = $salesNomor;
            // $array['products'][$number]['sales_id'] = $sales_id;
            $array['products'][$number]['alamat'] = $alamat;
            $array['products'][$number]['telp'] = $telp;
            $array['products'][$number]['info'] = $info;
            $array['products'][$number]['customer'] =$nama_cus;
            $array['products'][$number]['address'] =$address;

            $number++;
        }

        // echo json_encode($array);
        // exit();

        $pdf = PDF::loadView('sale.invoice', $array)
              ->setPaper('a5', 'landscape')  // A5 paper size, landscape orientation
              ->setOptions([
                  'isHtml5ParserEnabled' => true,  // Enable HTML5
                  'isPhpEnabled' => true  // Enable PHP if necessary for advanced functionality
              ]);

        // $pdf = PDF::loadView('sale.invoice', $array)
        //       ->setPaper('a5', 'landscape')  // Set paper size to A5 and orientation to landscape
        //       ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);  // Enable HTML5 and PHP if needed
    
        return $pdf->stream('invoice.pdf');


        // $pdf = PDF::loadView('sale.invoice', $array)->setPaper('a5', 'landscape');
        // return $pdf->stream('invoice.pdf');
    }

    public function index_data(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = Product::with('category', 'product_item', 'karats');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        if($id == 1){ // with nota
            $$module_name->where('is_nota', true)->get();
        }
        if($id == 2){ // without nota
            $$module_name->where('is_nota', false)->get();
        }
        $$module_name->where('status_id', 1)->get();

        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $$module_name;

        // echo json_encode($data);
        // exit();

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                // return view(
                //     'product::products.partials.actions',
                //     compact('module_name', 'data', 'module_model')
                // );
                return view('Sale.action', compact('module_name', 'data', 'module_model'));

            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('product_code', function ($data) {
                return $data->product_code;
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('rekomendasi', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                // $tb = '<div class="items-center gap-x-2">
                //                 <div class="text-sm text-center text-gray-500">
                //                 Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)) . ' <br>
                //                 </div>
                //                 </div>';
                // $karatnya   = $data->karat->name.' | '.$data->karat->kode;
                return $data->karat->name ?? '-';
                // return $data->karat->coef;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'rekomendasi', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }

    public function index_data_baki(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = Product::with('category', 'product_item', 'karats', 'baki');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        
        $$module_name->where('status_id', [1, 3])->get();
        $$module_name->where('baki_id', '!=', $id)->get();

        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $$module_name;

        // echo json_encode($data);
        // exit();

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                // return view(
                //     'product::products.partials.actions',
                //     compact('module_name', 'data', 'module_model')
                // );
                return view('Sale.action', compact('module_name', 'data', 'module_model'));

            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('product_code', function ($data) {
                return $data->product_code;
            })

            ->addColumn('baki', function ($data) {
                return $data->baki->name;
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('rekomendasi', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                // $tb = '<div class="items-center gap-x-2">
                //                 <div class="text-sm text-center text-gray-500">
                //                 Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)) . ' <br>
                //                 </div>
                //                 </div>';
                // $karatnya   = $data->karat->name.' | '.$data->karat->kode;
                return $data->karat->name ?? '-';
                // return $data->karat->coef;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'rekomendasi', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }

    public function index_data_custom(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = Product::with('category', 'product_item', 'karats', 'baki');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        
        $$module_name->where('baki_id', $id)->get();
        // $$module_name->where('status_id', 1)->get();

        $harga = Harga::latest()->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $$module_name;

        // echo json_encode($data);
        // exit();

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                // return view(
                //     'product::products.partials.actions',
                //     compact('module_name', 'data', 'module_model')
                // );
                return view('Sale.action', compact('module_name', 'data', 'module_model'));

            })

            ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                           <div class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category?->category_name . '</div>

                            <h3 class="small font-medium text-gray-600 dark:text-white "> ' . $data->product_name . '</h3>
                             <div class="text-xs font-normal text-blue-500 font-semibold">
                            ' . @$data->cabang->name . '</div>


                        </div>
                    </div>';
                return $tb;
            })
            //    ->addColumn('product_image', function ($data) {
            //     $url = $data->getFirstMediaUrl('images', 'thumb');
            //     return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
            // })


            ->addColumn('product_image', function ($data) {
                return view('product::products.partials.image', compact('data'));
            })

            ->addColumn('product_code', function ($data) {
                return $data->product_code;
            })

            ->addColumn('baki', function ($data) {
                return $data->baki->name;
            })

            ->addColumn('status', function ($data) {
                return view('product::products.partials.status', compact('data'));
            })

            ->editColumn('cabang', function ($data) {
                $tb = '<div class="text-center items-center gap-x-2">
                            <div class="text-sm text-center">
                              ' . @$data->cabang->name . '</div>
                                </div>';
                return $tb;
            })

            ->editColumn('rekomendasi', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)) . ' <br>
                                </div>
                                </div>';
                return $tb;
            })

            ->editColumn('karat', function ($data) {
                // $tb = '<div class="items-center gap-x-2">
                //                 <div class="text-sm text-center text-gray-500">
                //                 Rp .' . @rupiah((($data->karat->coef+$data->karat->margin)*$data->harga)) . ' <br>
                //                 </div>
                //                 </div>';
                // $karatnya   = $data->karat->name.' | '.$data->karat->kode;
                return $data->karat->name ?? '-';
                // return $data->karat->coef;
            })


            ->addColumn('tracking', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.qrcode_button',
                    compact('module_name', 'data', 'module_model')
                );
            })


            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;
                return tgljam($data->created_at);
            })
            ->rawColumns([
                'created_at', 'product_image', 'rekomendasi', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }
}
