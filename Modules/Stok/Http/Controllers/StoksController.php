<?php

namespace Modules\Stok\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Lang;
use Image;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Modules\Stok\Models\StockOffice;


class StoksController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Stok';
        $this->module_name = 'stok';
        $this->module_path = 'stoks';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Stok\Models\StockSales";
        $this->module_office = "Modules\Stok\Models\StockOffice";
        $this->module_pending = "Modules\Stok\Models\StockPending";
        $this->module_sales = "Modules\Stok\Models\StockSales";
        $this->module_kroom = "Modules\Stok\Models\StockKroom";
        $this->module_dp = "Modules\Stok\Models\StokDp";

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

    public function office() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Office';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.index_office',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }


 public function pending() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Pending';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.page.index_pending',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }


 public function sales() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Sales';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.page.index_sales',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }


 public function dp() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'DP';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.page.index_dp',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }

 public function kroom() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Kroom';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.page.index_kroom',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }


public function index_data_kroom(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_kroom = $this->module_kroom;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_kroom::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                          ->editColumn('karat', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' .$data->karat->kode  . ' | ' .$data->karat->name  . '</h3>
                                    </div>';
                                return $tb;
                            })  
 

                           
                              ->editColumn('weight', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->weight . '</h3>
                                    </div>';
                                return $tb;
                            })
                 
                        ->rawColumns(['updated_at', 'karat','customer', 'cabang', 'action', 'weight'])
                        ->make(true);
                     }





public function index_data_dp(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_dp = $this->module_dp;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_dp::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                          ->editColumn('karat', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' .$data->karat->kode  . ' | ' .$data->karat->name  . '</h3>
                                    </div>';
                                return $tb;
                            })  

                          ->editColumn('cabang', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' .$data->cabang->code  . ' | ' .$data->cabang->name  . '</h3>
                                    </div>';
                                return $tb;
                            })  

                             ->editColumn('customer', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' .$data->customer->name  . '</h3>
                                    </div>';
                                return $tb;
                            }) 

                           
                              ->editColumn('weight', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->weight . '</h3>
                                    </div>';
                                return $tb;
                            })
                 
                        ->rawColumns(['updated_at', 'karat','customer', 'cabang', 'action', 'weight'])
                        ->make(true);
                     }







public function index_data_sales(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_sales = $this->module_sales;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_sales::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                          ->editColumn('karat', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' .$data->karat->kode  . ' | ' .$data->karat->name  . '</h3>
                                    </div>';
                                return $tb;
                            })  

                          ->editColumn('sales', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' .$data->sales->name. '</h3>
                                    </div>';
                                return $tb;
                            }) 

                           
                              ->editColumn('weight', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->weight . ' Gram</h3>
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
                        ->rawColumns(['updated_at', 'sales','karat','berat_real', 'berat_kotor', 'action', 'weight'])
                        ->make(true);
                     }
















public function index_data_pending(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_pending = $this->module_pending;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_pending::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                         ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.aksi',
                            compact('module_name', 'data', 'module_model'));
                                })
                              ->editColumn('karat', function ($data) {
                                 $tb = '<div class="items-center text-center">
                                        <h3 class="text-sm font-medium text-gray-800">
                                       ' .$data->karat->kode  . ' | ' .$data->karat->name  . '</h3>
                                        </div>';
                                    return $tb;
                                })  

                          ->editColumn('cabang', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' .@$data->cabang->name  . '</h3>
                                    </div>';
                                return $tb;
                            }) 
                           
                            ->editColumn('weight', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->weight . '</h3>
                                    </div>';
                                return $tb;
                            }) 

                             ->editColumn('type', function ($data) {
                              $tb = '<div class="items-center text-center">
                                    <p class="text-sm font-medium text-gray-800">
                                     ' .$data->type . '</p>
                                    </div>';
                                return $tb;
                            })
                        
                        ->rawColumns([
                                   'updated_at', 
                                   'karat',
                                   'cabang', 
                                   'status', 
                                   'action', 
                                   'type', 
                                   'weight'])
                               ->make(true);
                     }




public function index_data_office(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_office = $this->module_office;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_office::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                          ->editColumn('karat', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                   ' .$data->karat->kode  . '   | ' .$data->karat->name  . '</h3>
                                    </div>';
                                return $tb;
                            }) 

                               ->editColumn('berat_real', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->berat_real . '</h3>
                                    </div>';
                                return $tb;
                            })  
                              ->editColumn('berat_kotor', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->berat_kotor . '</h3>
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
                        ->rawColumns(['updated_at', 'karat','berat_real', 'berat_kotor', 'action', 'weight'])
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

        $$module_name = $module_model::get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                           $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                                })
                          ->editColumn('weight', function ($data) {
                             $tb = '<div class="items-center text-center">
                                    <h3 class="text-sm font-medium text-gray-800">
                                     ' .$data->weight . '</h3>
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
                        ->rawColumns(['updated_at', 'action', 'weight'])
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
    public function store(Request $request)
    {
         abort_if(Gate::denies('create_stok'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $request->validate([
             'name' => 'required|min:3|max:191',
             'description' => 'required|min:3|max:191',
         ]);
       // $params = $request->all();
        //dd($params);
        $params = $request->except('_token');
        $params['name'] = $params['name'];
        $params['description'] = $params['description'];
        //  if ($image = $request->file('image')) {
        //  $gambar = 'products_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
        //  $normal = Image::make($image)->resize(600, null, function ($constraint) {
        //             $constraint->aspectRatio();
        //             })->encode();
        //  $normalpath = 'uploads/' . $gambar;
        //  if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
        //  Storage::disk($storage)->put($normalpath, (string) $normal);
        //  $params['image'] = "$gambar";
        // }else{
        //    $params['image'] = 'no_foto.png';
        // }


         $$module_name_singular = $module_model::create($params);
         toast(''. $module_title.' Created!', 'success');
         return redirect()->route(''.$module_name.'.index');
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
        // $input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);
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



public function view_pending($id)
    {

         //dd($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_pending = $this->module_pending;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_'.$module_name.''), 403);
        $detail = $module_pending::findOrFail($id);
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.modal.pending',
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
        $request->validate([
            'name' => 'required|min:3|max:191',
                 ]);
        $params = $request->except('_token');
        $params['name'] = $params['name'];
        $params['description'] = $params['description'];

       // if ($image = $request->file('image')) {
       //                if ($$module_name_singular->image !== 'no_foto.png') {
       //                    @unlink(imageUrl() . $$module_name_singular->image);
       //                  }
       //   $gambar = 'category_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
       //   $normal = Image::make($image)->resize(1000, null, function ($constraint) {
       //              $constraint->aspectRatio();
       //              })->encode();
       //   $normalpath = 'uploads/' . $gambar;
       //  if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
       //   Storage::disk($storage)->put($normalpath, (string) $normal);
       //   $params['image'] = "$gambar";
       //  }else{
       //      unset($params['image']);
       //  }
        $$module_name_singular->update($params);
         toast(''. $module_title.' Updated!', 'success');
         return redirect()->route(''.$module_name.'.index');
    }




//update ajax version
public function update_ajax(Request $request, $id)
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

}
