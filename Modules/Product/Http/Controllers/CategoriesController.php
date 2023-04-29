<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\DataTables\ProductCategoriesDataTable;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lang;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Image;
class CategoriesController extends Controller
{



public function __construct()
    {
        // Page Title
        $this->module_title = 'Category';

        // module name
        $this->module_name = 'categories';

        // directory path of the module
        $this->module_path = 'categories';

        // module icon
        $this->module_icon = 'fas fa-sitemap';

        // module model name, path
        $this->module_model = "Modules\Product\Entities\Category";


    }

    public function index(ProductCategoriesDataTable $dataTable) {
        abort_if(Gate::denies('access_product_categories'), 403);

        return $dataTable->render('product::categories.index');
    }


    public function store(Request $request) {
        abort_if(Gate::denies('access_product_categories'), 403);

        $request->validate([
            'category_code' => 'required|unique:categories,category_code',
            'category_name' => 'required'
        ]);

        Category::create([
            'category_code' => $request->category_code,
            'category_name' => $request->category_name,
        ]);

        toast('Product Category Created!', 'success');

        return redirect()->back();
    }


    public function edit($id) {
        abort_if(Gate::denies('access_product_categories'), 403);

        $category = Category::findOrFail($id);

        return view('product::categories.edit', compact('category'));
    }



    public function update(Request $request, $id) {
        abort_if(Gate::denies('access_product_categories'), 403);

        $request->validate([
            'category_code' => 'required|unique:categories,category_code,' . $id,
            'category_name' => 'required'
        ]);
        $params = $request->except('_token');
        $params['category_code'] = $params['category_code'];
        $params['category_name'] = $params['category_name'];

       if ($image = $request->file('image')) {

         $gambar = 'category_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
         $normal = Image::make($image)->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->encode();
         $normalpath = 'uploads/' . $gambar;
        if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
         Storage::disk($storage)->put($normalpath, (string) $normal);
         $params['image'] = "$gambar";
        }else{
            unset($params['image']);
        }
        // dd($params);
        Category::findOrFail($id)->update($params);
        toast('Product Category Updated!', 'info');

        return redirect()->route('product-categories.index');
    }


    public function destroy($id) {
        abort_if(Gate::denies('access_product_categories'), 403);

        $category = Category::findOrFail($id);
        $produk = Product::where('category_id',$id)->get();
        if ($produk->isNotEmpty()) {
            return back()->withErrors('Can\'t delete beacuse there are products associated with this category.');
        }
        $category->delete();
        toast('Product Category Deleted!', 'warning');
        return redirect()->route('product-categories.index');
    }
}
