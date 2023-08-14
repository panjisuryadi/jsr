<?php

namespace Modules\GoodsReceipt\Http\Controllers;
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
use Modules\Upload\Entities\Upload;

class GoodsReceiptsController extends Controller
{

  public function __construct()
    {
        // Page Title
        $this->module_title = 'Goods Receipt';
        $this->module_name = 'goodsreceipt';
        $this->module_path = 'goodsreceipts';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\GoodsReceipt\Models\GoodsReceipt";

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
                            return view('includes.action_gr',
                            compact('module_name', 'data', 'module_model'));
                                })

                            ->addColumn('image', function ($data) {
                                $url = $data->getFirstMediaUrl('pembelian', 'thumbnail');
                                return '<div class="items-center text-center">
                                <img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/></div>';
                                 })

                        ->editColumn('date', function ($data) {
                             $tb = '<div class="text-xs items-center text-center">
                                     ' .tanggal($data->date) . '
                                    </div>';
                                return $tb;
                            }) 
                            ->editColumn('code', function ($data) {
                             $tb = '<div class="text-xs text-blue-500 font-semibold items-center text-center">
                                     ' .$data->code . '
                                    </div>';
                                return $tb;
                            }) 

                              ->editColumn('berat', function ($data) {
                             $tb = '<div class="items-center text-center">
                                     ' .$data->berat_barang . ' 
                                    </div>';
                                return $tb;
                            })  

                           ->editColumn('qty', function ($data) {
                             $tb = '<div class="font-semibold items-center text-center">
                                     ' .$data->qty . ' 
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
                        ->rawColumns(['updated_at',
                         'date',
                         'action',
                         'code',
                         'berat',
                         'image', 
                         'qty', 
                         'name'])
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
            $code = $module_model::generateCode();
            $module_action = 'Create';
            abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.create',
               compact('module_name',
                'module_action',
                'code',
                'module_title',
                'module_icon', 'module_model'));
        }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function storesdsd(Request $request)
    {
        abort_if(Gate::denies('create_goodsreceipt'), 403);
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
        $params = $request->all();
        dd($params);
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





public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
          $request->validate([
             'code' => 'required|max:191|unique:'.$module_model.',code',
             'no_invoice' => 'required',
             'qty' => 'required',
             'berat_barang' => 'required',
             'date' => 'required',
             'berat_real' => 'required',
             'pengirim' => 'required',
             'qty_diterima' => 'required',
             'status' => 'required',
             'supplier_id' => 'required',
         ]);
        //$input = $request->all();
         $input = $request->except('_token');
        //dd($input);
        //$input['harga'] = preg_replace("/[^0-9]/", "", $input['harga']);


        if ($image = $request->file('document')) {
         $gambar = 'products_'.date('YmdHis') . "." . $image->getClientOriginalExtension();

            dd($gambar);
         $normal = Image::make($image)->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->encode();
         $normalpath = 'uploads/' . $gambar;
         if (config('app.env') === 'production') {$storage = 'public'; } else { $storage = 'public'; }
         Storage::disk($storage)->put($normalpath, (string) $normal);
         $input['image'] = "$gambar";
        }else{
           $input['image'] = 'no_foto.png';
        }




        $$module_name_singular = $module_model::create([
            'code'                       => $input['code'],
            'no_invoice'                 => $input['no_invoice'],
            'qty'                        => $input['qty'],
            'qty_diterima'               => $input['qty_diterima'],
            'date'                       => $input['date'],
            'status'                     => $input['status'],
            'supplier_id'                => $input['supplier_id'],
            'berat_barang'               => $input['berat_barang'],
            'berat_real'                 => $input['berat_real'],
            'pengirim'                   => $input['pengirim']
        ]);

         // if ($request->filled('image')) {
         //        $img = $request->image;
         //        $folderPath = "uploads/";
         //        $image_parts = explode(";base64,", $img);
         //        $image_type_aux = explode("image/", $image_parts[0]);
         //        $image_type = $image_type_aux[1];
         //        $image_base64 = base64_decode($image_parts[1]);
         //        $fileName ='webcam_'. uniqid() . '.jpg';
         //        $file = $folderPath . $fileName;
         //        Storage::disk('local')->put($file,$image_base64);
         //        $$module_name_singular->addMedia(Storage::path('uploads/' . $fileName))
         //        ->toMediaCollection('pembelian');
         //        }

          

         activity()->log(' '.auth()->user()->name.' input data pembelian');
         
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
