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
use Yajra\DataTables\DataTables;

class KaratController extends Controller
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
        $this->module_title = 'Karat';
        $this->module_name = 'karat';
        $this->module_path = 'karats';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Karat\Models\Karat";
    }
    
    public function insert(Request $request)
    {
        $product    = Harga::create([
            'tanggal'   => date('Y-m-d'),
            'harga'     => $request->harga,
            'user'      => 1,
        ]);

        return redirect()->action([KaratController::class, 'list']);
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
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        $harga = Harga::latest()->first();
        // echo json_encode($harga);
        // exit();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'Karats.list', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'dataKarat',
                'harga',
            )
        );
    }

    public function history(Request $request)
    {
        $harga = Harga::latest()->first();

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $dataKarat = Karat::whereNull('parent_id')->get();
        return view(
            'Karats.history', // Path to your create view file
            compact(
                'module_title',
                'module_name',
                'module_path',
                'module_icon',
                'module_model',
                'dataKarat',
                'harga',
            )
        );
    }

    public function history_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        // $harga = Harga::where('tanggal', date('Y-m-d'))->first();
        $harga = Harga::where('tanggal', date('Y-m-d'))->first();  
        if($harga == null){
            $harga  = 0;
        }else{
            $harga = $harga->harga;
        }     
        // $harga  = 1000000;
        $$module_name = Harga::with('user')->latest()->get();
        // echo $$module_name;        
        $data = $$module_name;
        return Datatables::of($data)
                    ->addColumn('action', function ($data) {
                       $module_name = $this->module_name;
                        $module_model = $this->module_model;
                        $module_path = $this->module_path;
                        return view($module_name.'::'.$module_path.'.includes.action',
                        compact('module_name', 'data', 'module_model'));
                            })
                         
                        ->editColumn('harga', function($data){
                            // $output = '';
                            // if(is_null($data->parent_id)){
                            //     $output = "{$data->name} {$data->kode}";
                            // }else{
                            //     $output = "{$data->parent->name} {$data->parent->kode} - {$data->name}";
                            // }
                            return '<div class="items-center text-center">
                                            <h3 class="text-sm font-bold text-gray-800"> ' .number_format($data->harga) . '</h3>
                                    </div>';
                             })  

                      ->editColumn('tanggal', function($data){
                        $output = '';
                            
                       return '<div class="items-center text-center">' .($data->created_at) . '</div>';
                        }) 
                      ->editColumn('user', function($data){
                            $output = '';
                          
                        return '<div class="items-center text-center">
                                            <span class="text-sm font-medium text-gray-800"> ' .($data->user->name ?? 'Admin').'</span>
                                    </div>';

                        })   
                      
                        ->rawColumns(['harga', 'tanggal','user'])
                        ->make(true);
    }
}
