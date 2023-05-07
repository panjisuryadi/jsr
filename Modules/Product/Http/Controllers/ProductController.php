<?php

namespace Modules\Product\Http\Controllers;
use Carbon\Carbon;
use Modules\Product\DataTables\ProductDataTable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\Product\Http\Requests\StoreProductRequest;
use Modules\Product\Http\Requests\UpdateProductRequest;
use Modules\Upload\Entities\Upload;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lang;
use Yajra\DataTables\DataTables;
use Image;
class ProductController extends Controller
{


public function __construct()
    {
        // Page Title
        $this->module_title = 'Products';

        // module name
        $this->module_name = 'products';

        // directory path of the module
        $this->module_path = 'products';

        // module icon
        $this->module_icon = 'fas fa-sitemap';

        // module model name, path
        $this->module_model = "Modules\Product\Entities\Product";
        $this->module_item = "Modules\Product\Entities\ProductItem";


    }


 public function index() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_products'), 403);
         return view('product::products.index',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }




    public function index_data_table(ProductDataTable $dataTable) {
        abort_if(Gate::denies('access_products'), 403);

        return $dataTable->render('product::products.index');
    }


    public function add_products_categories(Request $request ,$id) {
        abort_if(Gate::denies('access_products'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $category = Category::where('id', $id)->first();
        $module_action = 'List';
         return view('product::products.add_kategori',
           compact('module_name',
            'category',
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


        $$module_name = $module_model::with('category','product_item')->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('product::products.partials.actions',
                            compact('module_name', 'data', 'module_model'));
                                })
           ->editColumn('product_name', function ($data) {
                $tb = '<div class="flex items-center gap-x-2">
                        <div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white "> ' . $data->product_name . '</h3>
                            <p class="text-xs font-normal text-yellow-600 dark:text-gray-400">
                            ' . $data->category->category_name . '</p>
                        </div>
                    </div>';
                return $tb;
            })
           ->addColumn('product_image', function ($data) {
            $url = $data->getFirstMediaUrl('images', 'thumb');
            return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
        })

           ->addColumn('product_price', function ($data) {
              return format_currency($data->product_price);
          })
           ->addColumn('product_quantity', function ($data) {
            return $data->product_quantity . ' ' . $data->product_unit;
        })

           ->editColumn('product_quantity', function ($data) {
            $tb = '<div class="items-center small text-center">
            <span class="bg-green-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' . $data->product_quantity . ' ' . $data->product_unit . '</span></div>';
            return $tb;
        })

           ->editColumn('weight', function ($data) {
              $berat = @$data->product_item[0]->berat_emas;
            if ($berat) {
                 $weight = @$data->product_item[0]->berat_emas;
            } else {
                $weight = '0';
            }

            $tb = '<div class="items-center small text-center">
            <span class="bg-yellow-200 px-3 text-dark py-1 rounded reounded-xl text-center font-semibold">
            ' .  $weight . '</span></div>';
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
           ->rawColumns(['updated_at','product_image','weight',
            'product_name','product_quantity','product_price', 'action'])
           ->make(true);
    }






    public function create() {
        abort_if(Gate::denies('create_products'), 403);

        return view('product::products.create');
    }


    public function store(StoreProductRequest $request) {
         $params = $request->all();
        $params = $request->except('_token');
         dd($params);
        $product = Product::create($request->except('document'));

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        toast('Product Created!', 'success');

        return redirect()->route('products.index');
    }


  public function save(StoreProductRequest $request)
    {


        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_item = $this->module_item;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Store';
        $input = $request->all();
        $input = $request->except(['document']);
        $input['product_price'] = preg_replace("/[^0-9]/", "", $input['product_price']);
        $input['product_cost'] = preg_replace("/[^0-9]/", "", $input['product_cost']);
         //dd($input);
          $product_price = preg_replace("/[^0-9]/", "", $input['product_price']);
          $product_cost = preg_replace("/[^0-9]/", "", $input['product_cost']);
          $$module_name_singular = $module_model::create([
            'category_id'                       => $input['category_id'],
            'product_stock_alert'               => $input['product_stock_alert'],
            'product_name'                      => $input['product_name'],
            'product_code'                      => $input['product_code'],
            'product_price'                     => $product_price,
            'product_quantity'                  => $input['product_quantity'],
            'product_barcode_symbology'         => $input['product_barcode_symbology'],
            'product_unit'                      => $input['product_unit'],
            'product_cost'                      =>  $product_cost
        ]);
        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $$module_name_singular->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }
         $produk = $$module_name_singular->id;
         $this->_saveProductsItem($input ,$produk);
         toast('Product Created!', 'success');

        return redirect()->route('products.index');
    }



    private function _saveProductsItem($input ,$produk)
    {

          $product_price = preg_replace("/[^0-9]/", "", $input['product_price']);
          $product_cost = preg_replace("/[^0-9]/", "", $input['product_cost']);
          $product_sale = preg_replace("/[^0-9]/", "", $input['product_sale']);

       ProductItem::create([
            'product_id'                  => $produk,
            'karat_id'                    => $input['karat_id'],
            'certificate_id'              => $input['certificate_id'],
            'shape_id'                    => $input['shape_id'],
            'round_id'                    => $input['round_id'],
            'product_cost'                => $product_cost,
            'product_price'               => $product_price,
            'product_sale'                => $product_sale,
            'berat_emas'                  => $input['berat_emas'],
            'berat_label'                 => $input['berat_label'],
            'gudang'                      => $input['gudang'],
            'brankas'                     => $input['brankas'],
            'kode_baki'                   => $input['kode_baki'],
            'berat_total'                 => $input['berat_total']
        ]);
       // dd($produk);
      }


    public function show(Product $product) {
        abort_if(Gate::denies('show_products'), 403);

        return view('product::products.show', compact('product'));
    }






    public function edit(Product $product) {
        abort_if(Gate::denies('edit_products'), 403);

        return view('product::products.edit', compact('product'));
    }


    public function update(UpdateProductRequest $request, Product $product) {
        $product->update($request->except('document'));

        if ($request->has('document')) {
            if (count($product->getMedia('images')) > 0) {
                foreach ($product->getMedia('images') as $media) {
                    if (!in_array($media->file_name, $request->input('document', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $product->getMedia('images')->pluck('file_name')->toArray();

            foreach ($request->input('document', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
                }
            }
        }

        toast('Product Updated!', 'info');

        return redirect()->route('products.index');
    }


    public function destroy(Product $product) {
        abort_if(Gate::denies('delete_products'), 403);

        $product->delete();

        toast('Product Deleted!', 'warning');
        return redirect()->route('products.index');
    }
}
