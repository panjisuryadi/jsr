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
use App\Models\Harga;
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
        $nama_cus   = '';
        if(!empty($request->customer)){
            // $customer   = Customer::where('id', $request->customer)->first();
            // $nama_cus   = $customer->customer_name;
    //         $nama_cus   = '
    // <p style="text-align: right; font-size:13px">Kepada Yth : '.$nama_cus.'</p>
    //         ';
        }
        // UPDATE STATUS PRODUCT
        $number = 0;
        $data   = array();
        foreach ($request->product as $p) {
            if($p == 0){ // SERVICE NON PRODUCT
                $title  = 'Faktur';
                $name   = $request->product_name[$number];
                $desc   = $request->product_desc[$number];
                $gram   = '-';
                $harga  = $request->harga[$number];
            }else{
                $title  = 'Nota Emas';
                $product= Product::where('id', $p)->firstOrFail();
                $name   = $product->product_name;
                $name   = $product->product_name;
                $desc   = $product->product_code;
                $gram   = $product->berat_emas;
                $harga  = $request->harga[$number];
                $product->status_id = 1;
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
            $array['products'][$number]['title'] = $title;
            $array['products'][$number]['name'] = $name;
            $array['products'][$number]['desc'] = $desc;
            $array['products'][$number]['gram'] = $gram;
            $array['products'][$number]['harga'] = $harga;
            $array['products'][$number]['customer'] =$nama_cus;

            
            $number++;
        }
        // $pdf = PDF::loadView('sale.invoice', $data)->setPaper('a5', 'landscape');
        // return $pdf->download('invoice.pdf');
        // $data = [
        //     'title' => 'Nota Emas',
        //     'date' => date('d/m/Y H:i:s'),
        //     'products' => [
        //         ['name' => 'Produk A', 'code' => 'CEmas 17K160125435', 'gram' => 1, 'price' => 10000],
        //         ['name' => 'Produk B', 'code' => 'GEMAS 375140225232', 'gram' => 2, 'price' => 15000],
        //         ['name' => 'Produk B', 'code' => 'GEMAS 375140225232', 'gram' => 2, 'price' => 15000],
        //     ]
        // ];

        $pdf = PDF::loadView('sale.invoice', $array)->setPaper('a5', 'landscape');
        return $pdf->stream('invoice.pdf');
        // echo json_encode($request);
        // echo json_encode($_POST);
        // exit();
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

            ->editColumn('karat', function ($data) {
                $tb = '<div class="items-center gap-x-2">
                                <div class="text-sm text-center text-gray-500">
                                Rp .' . @rupiah(($data->karat->coef*$data->harga)) . ' <br>
                                </div>
                                </div>';
                return $tb;
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
                'created_at', 'product_image', 'weight', 'status', 'tracking',
                'product_name', 'karat', 'cabang', 'action'
            ])
            ->make(true);
    }
}
