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





public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';


        $$module_name = $module_model::with('category')->get();

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


                           ->editColumn('updated_at', function ($data) {
                            $module_name = $this->module_name;

                            $diff = Carbon::now()->diffInHours($data->updated_at);
                            if ($diff < 25) {
                                return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                            } else {
                                return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                            }
                        })
                        ->rawColumns(['updated_at','product_image','product_name','product_quantity','product_price', 'action'])
                        ->make(true);
    }










    public function create() {
        abort_if(Gate::denies('create_products'), 403);

        return view('product::products.create');
    }


    public function store(StoreProductRequest $request) {
        $product = Product::create($request->except('document'));

        if ($request->has('document')) {
            foreach ($request->input('document', []) as $file) {
                $product->addMedia(Storage::path('temp/dropzone/' . $file))->toMediaCollection('images');
            }
        }

        toast('Product Created!', 'success');

        return redirect()->route('products.index');
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
