<?php

namespace Modules\Produksi\Http\Controllers;

use App\Models\LookUp;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Produksi\Models\ProduksiItems;
use Modules\Produksi\Models\Produksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Lang;
use Image;
use Modules\Produksi\Models\DiamondCertificateAttribute;
use Modules\Produksi\Models\DiamondCertifikatT;
use Modules\Stok\Models\PenerimaanLantakan;
use Modules\Stok\Models\StockKroom;

class ProduksisController extends Controller
{

    public $module_title;
    public $module_name;
    public $module_path;
    public $module_icon;
    public $module_model;


    public function __construct()
    {
        // Page Title
        $this->module_title = 'Produksi';
        $this->module_name = 'produksi';
        $this->module_path = 'produksis';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\Produksi\Models\Produksi";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index() 
    {
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
        $module_name = $this->module_name;
        $module_model = $this->module_model;

        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;

        $module_name = $module_model::with('karatasal', 'karatjadi', 'model')->where('kategoriproduk_id', $id_kategoriproduk_berlian)->get();

        return Datatables::of($module_name)
                    ->addColumn('karat_asal', function ($data) {
                        return $data->karatasal?->name;
                    })
                    ->addColumn('karat_jadi', function ($data) {
                        return $data->karatjadi?->name;
                    })
                    ->addColumn('model', function ($data) {
                        return $data->model?->name;
                    })
                    ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            return view('includes.action',
                            compact('module_name', 'data', 'module_model'));
                    })
                    ->editColumn('name', function ($data) {
                        $tb = '<div class="items-center text-center">
                            <h3 class="text-sm font-medium text-gray-800">
                                ' .$data->name . '</h3>
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
                    ->rawColumns(['updated_at', 'action', 'name'])
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
    public function store_default(Request $request)
    {
        abort_if(Gate::denies('create_produksi'), 403);
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

         $module_name_singular = $module_model::create($params);
         toast(''. $module_title.' Created!', 'success');
         return redirect()->route(''.$module_name.'.index');
    }

    public function store(Request $request)
    {

        try {
            
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_path = $this->module_path;
            $module_icon = $this->module_icon;
            $module_model = $this->module_model;
            $module_name_singular = Str::singular($module_name);

            DB::beginTransaction();
            $input = $request->except('_token');

            $input['image'] = '';
            if ($request->filled('image')) {
                $img = $request->image;
                $folderPath = "uploads/produksi/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('public')->put($file,$image_base64);
                $input['image'] = "$fileName";
            }
            dd($input['image']);
            $produksis = $this->module_model::create([
                'code' => !empty($input['code']) ? $input['code'] : null,
                'image' => !empty($input['karatasal_id']) ? $input['karatasal_id'] : null,
                'karatasal_id' => !empty($input['karatasal_id']) ? $input['karatasal_id'] : null,
                'source_kode' => !empty($input['source_kode']) ? $input['source_kode'] : null,
                'karat_id' => !empty($input['karat_id']) ? $input['karat_id'] : null,
                'model_id' => !empty($input['model_id']) ? $input['model_id'] : null,
                'berat_asal' => !empty($input['berat_asal']) ? $input['berat_asal'] : null,
                'berat' => !empty($input['berat']) ? $input['berat'] : null,
                'tanggal' => !empty($input['tanggal']) ? $input['tanggal'] : null,
                'created_by' => auth()->user()->id,
                'kategoriproduk_id' => !empty($input['kategoriproduk_id']) ? $input['kategoriproduk_id'] : '',
            ]);
            $produksi_id = $produksis->id;
            $product_items = [];
            if(!empty($input['items'])){
                foreach($input['items'] as $val) {
                    $val['produksis_id'] = $produksi_id;
                    $val['shapeberlian_id'] = !empty($val['shapeberlian_id']) ? $val['shapeberlian_id'] : null;
                    $val['kategoriproduk_id'] = !empty($input['kategoriproduk_id']) ? $input['kategoriproduk_id'] : null;
                    if(!empty($val['karatberlians_id'])) {
                        $product_items[] = $val;
                    }
                }
            }

            if(!empty($product_items)) {
                $arraySertifikatAttributes = [];
                $hari_ini = new DateTime();
                $hari_ini = $hari_ini->format('Y-m-d');
                foreach($product_items as $val) {
                    $sertifikat = !empty($val['sertifikat']) ? $val['sertifikat'] : [];
                    if(!empty($sertifikat)) {
                        $attribute = !empty($sertifikat['attribute']) ? $sertifikat['attribute'] : [];
                        if(isset($sertifikat['attribute'])) {
                            unset($sertifikat['attribute']);
                        }
                        $sertifikat['tanggal'] = empty($sertifikat['tanggal']) ? $sertifikat['tanggal'] : $hari_ini;
                        $diamond_certificate = DiamondCertifikatT::create($sertifikat);
                        $arraySertifikatAttributes[$diamond_certificate->id] = $attribute;
                        $val['diamond_certificate_id'] = $diamond_certificate->id;
                    }
                    if(isset($val['sertifikat'])) {
                        unset($val['sertifikat']);
                    }
                    ProduksiItems::create($val);
                }
                $dataInsertSertifikatAttribute = [];
                foreach($arraySertifikatAttributes as $key => $val) { 
                    foreach($val as $k => $row){
                        $dataInsertSertifikatAttribute[] = [
                            'diamond_certificate_id' => $key,
                            'diamond_certificate_attributes_id' => $k,
                            'keterangan' => !empty($row['keterangan']) ? $row['keterangan'] : '',
                        ];
                    }
                }
                DiamondCertificateAttribute::insert($dataInsertSertifikatAttribute);
            }

            $stok_lantakan = PenerimaanLantakan::where('karat_id', $produksis->karatasal_id)->first();
            $stok_lantakan->weight = $stok_lantakan->weight - $produksis->berat_asal;
            $stok_lantakan->save();

        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
        DB::commit();
        activity()->log(' '.auth()->user()->name.' input data pembuatan stok produksi ' . !empty($produksis->id) ? $produksis->id : '');
        toast(''. $this->module_title.' Berhasil dibuat!', 'success');
        return redirect()->route(''.$this->module_name.'.index');

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
                toast(''. $module_title.' error!', 'warning');
                return redirect()->back();
            }

    }

}
