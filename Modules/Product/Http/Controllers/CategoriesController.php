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
        $this->module_title = 'Product Category';

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
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Store';
        $request->validate([
            'category_code' => 'required|unique:categories,category_code',
            'category_name' => 'required'
        ]);
        $params = $request->except('_token');
        $params['category_code'] = $params['category_code'];
        $params['category_name'] = $params['category_name'];

     if ($image = $request->file('image')) {
         $gambar = 'products_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
         $normal = Image::make($image)->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->encode();
         $normalpath = 'uploads/' . $gambar;
         if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
         Storage::disk($storage)->put($normalpath, (string) $normal);
         $params['image'] = "$gambar";
        }else{
           $params['image'] = 'no_foto.png';
        }
         $$module_name_singular = $module_model::create($params);
         toast(''. $module_title.' Created!', 'success');

           return redirect()->back();
    }


    public function edit($id) {
        abort_if(Gate::denies('access_product_categories'), 403);

        $category = Category::findOrFail($id);

        return view('product::categories.edit', compact('category'));
    }



    public function update(Request $request, $id) {
        abort_if(Gate::denies('access_product_categories'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';

        $$module_name_singular = $module_model::findOrFail($id);
        $request->validate([
            'category_code' => 'required|unique:categories,category_code,' . $id,
            'category_name' => 'required'
        ]);
        $params = $request->except('_token');
        $params['category_code'] = $params['category_code'];
        $params['category_name'] = $params['category_name'];

       if ($image = $request->file('image')) {
                      if ($$module_name_singular->image !== 'no_foto.png') {
                          @unlink(imageUrl() . $$module_name_singular->image);
                        }
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
        $$module_name_singular->update($params);
          toast(''. $module_title.' Updated!', 'success');

        return redirect()->route('product-categories.index');
    }


    public function destroy($id) {
        abort_if(Gate::denies('access_product_categories'), 403);
        $category = Category::findOrFail($id);
        $produk = Product::where('category_id',$id)->get();

        if ($produk->isNotEmpty()) {
            return back()->withErrors('Can\'t delete beacuse there are products associated with this category.');
        }
              if ($category->image !== 'no_foto.png') {
                   @unlink(imageUrl() . $category->image);
                }
        $category->delete();

        toast('Product Category Deleted!', 'warning');
        return redirect()->route('product-categories.index');
    }
}
