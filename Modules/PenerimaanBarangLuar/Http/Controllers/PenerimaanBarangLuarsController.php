<?php

namespace Modules\PenerimaanBarangLuar\Http\Controllers;
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
use Auth;
use Modules\PenerimaanBarangLuar\Events\PenerimaanBarangLuarCreated;
use Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar;
use Modules\Cabang\Models\Cabang;
use Modules\Status\Models\ProsesStatus;

class PenerimaanBarangLuarsController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Penerimaan Barang Luar';
        $this->module_name = 'penerimaanbarangluar';
        $this->module_path = 'penerimaanbarangluars';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\PenerimaanBarangLuar\Models\PenerimaanBarangLuar";

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
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.aksi',
                            compact('module_name', 'data', 'module_model'));
                                })

                           ->editColumn('no_barang_luar', function ($data) {
                             $tb = '<div class="justify items-left text-left">'; 
                             $tb .= '<div class="text-blue-400">
                                     Nomor :<strong>' . $data->no_barang_luar . '
                                    </strong></div>';
                             $tb .= '<div class="text-gray-800">
                                     Cabang :<strong>' . $data->cabang->name . '
                                    </strong></div>'; 
                             $tb .= '<div class="text-gray-800">
                                     Customer :<strong>' . $data->customer_name . '
                                    </strong></div>';               
                             $tb .= '</div>'; 
                                return $tb;
                              })

                      
                             ->editColumn('nama_produk', function ($data) {
                             $tb = '<div class="justify items-left text-left">'; 
                           
                             $tb .= '<div class="text-gray-800">
                                     Prduk :<strong>' . $data->product_name . '
                                    </strong></div>'; 
                             $tb .= '<div class="text-gray-800">
                                     Karat :<strong>' . $data->karat->name . '
                                    </strong></div>';   

                             $tb .= '<div class="text-gray-800">
                                     Berat :<strong>' . $data->weight . '
                                    </strong></div>';               
                             $tb .= '</div>'; 
                                return $tb;
                              })


                          ->editColumn('kadar', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                        ' . $data->karat->name . '
                                       </div>';
                                   return $tb;
                               })
                            ->editColumn('berat', function ($data) {
                            $tb = '<div class="font-semibold items-center text-center">
                                    ' . $data->weight . '
                                     gram </div>';
                                return $tb;
                            })
                            ->editColumn('nominal_beli', function ($data) {
                            $tb = '<div class="font-semibold items-center text-center">
                                    ' . format_uang($data->nominal) . '
                                    </div>';
                                return $tb;
                            })

                         ->addColumn('status', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.status',
                            compact('module_name', 'data', 'module_model'));
                                })


                            ->editColumn('cabang', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                        ' . $data->cabang->name . '
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
                        ->rawColumns(['action','nama_customer',
                               'no_barang_luar',
                               'nama_produk',
                               'kadar',
                               'berat',
                               'status',
                               'nominal_beli',
                               'updated_at',
                               'keterangan',
                               'cabang'])
                        ->make(true);
                     }







public function index_data_insentif(Request $request)

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
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.aksi',
                            compact('module_name', 'data', 'module_model'));
                                })

                           ->editColumn('bulan', function ($data) {
                                return \Carbon\Carbon::parse($data->created_at)->format('F');
                              })

                            ->editColumn('kadar', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                        ' . $data->karat->name . '
                                       </div>';
                                   return $tb;
                               })
                            ->editColumn('berat', function ($data) {
                            $tb = '<div class="font-semibold items-center text-center">
                                    ' . $data->weight . '
                                     gram </div>';
                                return $tb;
                            })
                            ->editColumn('nominal_beli', function ($data) {
                            $tb = '<div class="font-semibold items-center text-center">
                                    ' . format_uang($data->nominal) . '
                                    </div>';
                                return $tb;
                            })

                         ->addColumn('status', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            return view(''.$module_name.'::'.$module_path.'.status',
                            compact('module_name', 'data', 'module_model'));
                                })


                            ->editColumn('cabang', function ($data) {
                                $tb = '<div class="font-semibold items-center text-center">
                                        ' . $data->cabang->name . '
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
                        ->rawColumns(['action','nama_customer',
                               'bulan',
                               'cabang',
                               'kadar',
                               'berat',
                               'status',
                               'nominal_beli',
                               'updated_at',
                               'keterangan',
                               'cabang'])
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
            $cabang = Cabang::where('id',Auth::user()->namacabang->cabang()->first()->id)->get();
            abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.create',
               compact('module_name',
                'module_action',
                'module_title',
                'cabang',
                'module_icon', 'module_model'));
        }




        public function index_insentif() {
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'List';
            abort_if(Gate::denies('access_'.$module_name.''), 403);
             return view(''.$module_name.'::'.$module_path.'.index_insentif',
               compact('module_name',
                'module_action',
                'module_title',
                'module_icon', 'module_model'));
        }



      public function tambah_insentif()
        {
           $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);
            $module_action = 'Create';
            $cabang = Cabang::where('id',Auth::user()->namacabang->cabang()->first()->id)->get();
            abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.modal.tambah_insentif',
               compact('module_name',
                'module_action',
                'module_title',
                'cabang',
                'module_icon', 'module_model'));
        }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_default(Request $request)
    {
        abort_if(Gate::denies('create_penerimaanbarangluars'), 403);
        $validated = $request->validate([
            'no_barang_luar' => 'required',
            'date' => 'required',
            'customer_name' => 'required',
            'nama_products' => 'required',
            'kadar' => 'required',
            'berat' => 'required',
            'nominal' => 'required',
        ]);
        
        BuysBack::create([
            'date' => $request->input('date'),
            'customer_name' => $request->input('customer_name')??null,
            'note' => $request->input('note')??null,
            'no_barang_luar' => $request->input('no_barang_luar'),
            'product_name' => $request->input('nama_products'),
            'karat_id' => $request->input('kadar'),
            'weight' => $request->input('berat'),
            'nominal' => $request->input('nominal')
        ]);

        toast('Penerimaan Barang Luar Created!', 'success');
        return redirect()->route('penerimaanbarangluar.index');
    }



//store ajax version

public function store(Request $request)
    {
        abort_if(Gate::denies('create_penerimaanbarangluars'), 403);
        $validated = $request->validate([
            'no_barang_luar' => 'required',
            'date' => 'required',
            'customer_name' => 'required',
            'nama_products' => 'required',
            'kadar' => 'required',
            'berat' => 'required',
            'nominal' => 'required',
            'cabang_id' => 'required|exists:cabangs,id'
        ]);

        $nominal = preg_replace("/[^0-9]/", "", $request->input('nominal'));
        $penerimaanBarangLuar = PenerimaanBarangLuar::create([
            'date' => $request->input('date'),
            'customer_name' => $request->input('customer_name')??null,
            'note' => $request->input('note')??null,
            'no_barang_luar' => $request->input('no_barang_luar'),
            'product_name' => $request->input('nama_products'),
            'karat_id' => $request->input('kadar'),
            'weight' => $request->input('berat'),
            'nominal' =>  $nominal,
            'cabang_id' => $request->input('cabang_id')
        ]);
        event(new PenerimaanBarangLuarCreated($penerimaanBarangLuar));
        toast('Penerimaan Barang Luar Created!', 'success');
        return redirect()->route('penerimaanbarangluar.index');
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
        $detail = $module_model::with('cabang','karat')->findOrFail($id);
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.show',
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
          return view(''.$module_name.'::'.$module_path.'.modal.edit',
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
    public function update_default(Request $request, $id)
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


    public function status($id)
    {
       $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Status';
        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
        $proses_statuses = ProsesStatus::all();
          return view(''.$module_name.'::'.$module_path.'.modal.status',
           compact('module_name',
            'module_action',
            'detail',
            'proses_statuses',
            'module_title',
            'module_icon', 'module_model'));
         }


    //update ajax version
    public function update_status(Request $request, $id)
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
                'status_id' => 'required|exists:proses_statuses,id',
        ]);

       if (!$validator->passes()) {
          return response()->json(['error'=>$validator->errors()]);
        }

        //$input = $request->all();
        $params = $request->except('_token');
        $$module_name_singular->update($params);
        $$module_name_singular->statuses()->attach($params['status_id']);
        
        return response()->json(['success'=>'  '.$module_title.' Sukses diupdate.']);

 }










//update ajax version
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
