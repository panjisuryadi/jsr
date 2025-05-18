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
use Modules\ProdukModel\Models\ProdukModel;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\GoodsReceipt\Models\TipePembelian;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\Stok\Models\StockOffice;
use App\Models\Harga;
use App\Models\Baki;
use App\Models\StockOpname;
use App\Models\StockOpnameBaki;
use App\Models\StockOpnameProduct;
use Modules\Product\Entities\Product;
use Yajra\DataTables\DataTables;

class StockopnameController extends Controller
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
        $this->module_title = 'Baki';
        $this->module_name = 'baki';
        $this->module_path = 'bakis';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "App\Models";
    }
    
    public function insert(Request $request)
    {
        $baki    = Baki::create([
            'code'      => $request->code,
            'posisi'    => $request->posisi,
            'name'      => $request->name,
            'capacity'  => $request->capacity,
        ]);

        return redirect()->action([BakiController::class, 'list']);
    }

    public function update(Request $request)
    {
        $baki = Baki::where('id', $request->id)->firstOrFail();
        $baki->posisi = $request->posisi;
        $baki->code = $request->code;
        $baki->name = $request->name;
        $baki->capacity = $request->capacity;
        $baki->save();

        return redirect()->action([BakiController::class, 'list']);
    }

    public function list(Request $request)
    {
        $stockopname   = Stockopname::latest()->first();
        $status = $stockopname->status;
        if($status !== 'A'){
            $stockopname    = Stockopname::create([
                'status'      => 'A',
            ]);
        }
        $stockopname_id = $stockopname->id;
        $baki   = Baki::latest()->get();
        if($status !== 'A'){
            foreach($baki as $b){
                $baki_id    = $b->id;
                $code       = $b->code;
                $name       = $b->name;
                $capacity   = $b->capacity;
                $posisi     = $b->posisi;
                $used       = Product::where('baki_id', $baki_id)->count();
    
                $stockopnamebaki    = StockopnameBaki::create([
                    'stock_opname_id'   => $stockopname_id,
                    'baki_id'           => $baki_id,
                    'name'              => $name,
                    'code'              => $code,
                    'used'              => $used,
                    'capacity'          => $capacity,
                    'posisi'            => $posisi,
                ]);
            }
        }
        
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(
            'stockopname.list', // Path to your create view file
            compact(
                'stockopname',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function detail(Request $request)
    {
        $id     = $request->id;
        // $stockopnamebaki    = stockopnamebaki::where('id', $id)->first()->get();
        $stockopnamebaki    = stockopnamebaki::where('id', $id)->firstOrFail();
        $status             = $stockopnamebaki->status;
        $stockopname_id     = $stockopnamebaki->stock_opname_id;
        $baki_id            = $stockopnamebaki->baki_id;
        if($status !== 'P'){
            $stockopnamebaki->status = 'P';
            $stockopnamebaki->save();
            $product            = Product::where('baki_id', $baki_id)->latest()->get();
            foreach($product as $p){
                $product_id = $p->id;
                $stockopnameproduct    = StockopnameProduct::create([
                    'stock_opname_id'   => $stockopname_id,
                    'baki_id'           => $baki_id,
                    'product_id'        => $product_id,
                ]);
            }
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $baki   = StockOpnameBaki::findorFail($id);
        return view(
            'stockopname.detail', // Path to your create view file
            compact(
                'id',
                'baki',
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
            )
        );
    }

    public function index_data($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $$module_name = StockOpnameBaki::where('stock_opname_id', $id)->latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('stockopname.action',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                return ($data->created_at);
            })
            ->editColumn('status', function ($data) {
                $stat   = 'Waiting';
                if($data->status == 'D'){
                    $stat   = 'Done';
                }
                return $stat;
            })
                
            ->rawColumns(['code', 'posisi', 'used', 'name', 'capacity'])
            ->make(true);
    }

    public function detail_data($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $stockopnamebaki    = StockOpnameBaki::where('id', $id)->first();
        $stockopname_id     = $stockopnamebaki->stock_opname_id;
        $baki_id            = $stockopnamebaki->baki_id;

        $module_action = 'List';
        $$module_name = StockOpnameProduct::
        with('product', 'baki')
        ->where('stock_opname_id', $stockopname_id)
        ->where('baki_id', $baki_id)
        ->where('status', 'W')
        ->latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('stockopname.action',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                return ($data->created_at);
            })
            ->editColumn('product_code', function ($data) {
                return ($data->product->product_code);
            })
            ->editColumn('product_name', function ($data) {
                return ($data->product->product_name);
            })
            ->editColumn('baki', function ($data) {
                return ($data->baki->name);
            })
            ->editColumn('berat_emas', function ($data) {
                return ($data->product->berat_emas);
            })
            ->editColumn('status', function ($data) {
                $stat   = 'Waiting';
                if($data->status == 'D'){
                    $stat   = 'Done';
                }
                return $stat;
            })
                
            ->rawColumns(['code', 'posisi', 'used', 'name', 'capacity'])
            ->make(true);
    }

    public function opname_data($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $stockopnamebaki    = StockOpnameBaki::where('id', $id)->first();
        $stockopname_id     = $stockopnamebaki->stock_opname_id;
        $baki_id            = $stockopnamebaki->baki_id;

        $module_action = 'List';
        $$module_name = StockOpnameProduct::
        with('product', 'baki')
        ->where('stock_opname_id', $stockopname_id)
        ->where('baki_id', $baki_id)
        ->where('status', 'D')
        ->latest()->get();
        $data = $$module_name;
        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_path = $this->module_path;
                return view('stockopname.action',
                compact('module_name', 'data', 'module_model'));
            })

            ->editColumn('created', function ($data) {
                return ($data->created_at);
            })
            ->editColumn('product_code', function ($data) {
                return ($data->product->product_code);
            })
            ->editColumn('product_name', function ($data) {
                return ($data->product->product_name);
            })
            ->editColumn('baki', function ($data) {
                return ($data->baki->name);
            })
            ->editColumn('berat_emas', function ($data) {
                return ($data->product->berat_emas);
            })
            ->editColumn('status', function ($data) {
                $stat   = 'Waiting';
                if($data->status == 'D'){
                    $stat   = 'Done';
                }
                return $stat;
            })
                
            ->rawColumns(['code', 'posisi', 'used', 'name', 'capacity'])
            ->make(true);
    }
}
