<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Modules\People\Entities\Supplier;
use DateTime;
use Modules\Karat\Models\Karat;
use Modules\Product\Entities\Category;
use Modules\Group\Models\Group;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\GoodsReceipt\Models\TipePembelian;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\Stok\Models\StockOffice;
use App\Models\Harga;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_categories;
    private $module_products;
    private $code;

    public function __construct()
    {
        $this->module_title = 'Products';
        $this->module_name = 'products';
        $this->module_path = 'product';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Product\Entities\Product";
        $this->module_item = "Modules\Product\Entities\ProductItem";
        $this->module_categories = "Modules\Product\Entities\Category";
        $this->module_pembelian = "Modules\GoodsReceipt\Models\GoodsReceipt";
        // $this->module_title = 'Product';
        // $this->module_name = 'Product';
        // $this->module_path = 'Products';
        // $this->module_icon = 'fas fa-sitemap';
        // $this->module_model = "Modules\Product\Models\Product";
    }
    
    public function insert(Request $request)
    {
        $i = 0;
        // echo json_encode($_POST);
        // exit();
        $group  = Group::where('id', $request->new_product_group_id)->first();
        $group_name = $group->name;
        $model  = ProdukModel::where('id', $request->new_product_model_id)->first();
        $model_name = $model->name;
        $product_name   = $group_name.' '.$model_name;
        $product    = Product::create([
            'category_id'       => $request->new_product_category_id,
            'product_code'       => $request->new_product_code_id,
            'product_name'       => $product_name,
            'product_barcode_symbology'       => 'C128',
            'product_unit'       => 'Gram',
            'product_stock_alert'       => 5,
            'status'       => 0,
            'images'       => 'jpg',
            'berat_emas'       => $request->new_product_gold_weight,
            'product_price'       => 0,
            'status_id'       => 11,
            'group_id'       => $request->new_product_group_id,
            'model_id'       => $request->new_product_model_id,
            'goodreceipt_item_id' => 0,
            'is_nota' => false,
        ]);

        $productItem    = ProductItem::create([
            'product_id'       => $product->id,
            'berat_total'       => $request->new_product_total_weight,
            'berat_emas'       => $request->new_product_gold_weight,
            'berat_accessories'       => $request->new_product_accessories_weight,
            'tag_label'       => 0,
            'berat_label'       => 0,
        ]);

        // $product    = Harga::create([
        //     'tanggal'   => date('Y-m-d'),
        //     'harga'     => $request->harga,
        //     'user'      => 1,
        // ]);

        return redirect()->action([ProductController::class, 'list']);
    }

    public function update(Request $request)
    {
        $harga = Harga::where('tanggal', date('Y-m-d'))->firstOrFail();
        $harga->harga = $request->harga;
        $harga->save();

        return redirect()->action([KaratController::class, 'list']);
    }

    public function list(Request $request)
    {
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'Products.list', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                // 'inputs',
                'dataKarat',
            )
        );
    }

    public function list_all(Request $request)
    {
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'Products.list_all', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                // 'inputs',
                'dataKarat',
            )
        );
    }

    public function list_emas(Request $request)
    {
        $product_categories = Category::all();  // Assuming Supplier model is set up
        $groups = Group::all();  // Assuming Supplier model is set up
        $models = ProdukModel::all();  // Assuming Supplier model is set up
        $dataKarat = Karat::whereNull('parent_id')->get();
        $hari_ini = new DateTime();
        $hari_ini = $hari_ini->format('Y-m-d');
        $isLogamMulia   = true;
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'Products.list_all', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'product_categories',
                'groups',
                'models',
                'isLogamMulia',
                'hari_ini',
                // 'inputs',
                'dataKarat',
            )
        );
    }

    public function data_nota(Request $request)
    {   
        $id     = $request->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item');
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
        // $harga  = 1000000;
        $$module_name = $$module_name->latest()->get();
        $$module_name->each(function ($item) use ($harga) {
            $item->harga = $harga; // Add the harga attribute to the model
        });
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.actions',
                    compact('module_name', 'data', 'module_model')
                );
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
                                <b>' . @$data->karat->label . ' </b><br>
                                Rp .' . @rupiah($data->product_price) . ' <br>
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

    public function index_data(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = $module_model::with('category', 'product_item');
        if ($request->get('status')) {
            $$module_name = $$module_name->where('status_id', $request->get('status'));
        }
        $$module_name = $$module_name->latest()->get();
        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                return view(
                    'product::products.partials.actions',
                    compact('module_name', 'data', 'module_model')
                );
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
                                <b>' . @$data->karat->label . ' </b><br>
                                Rp .' . @rupiah($data->product_price) . ' <br>
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
