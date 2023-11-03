<?php

namespace Modules\GoodsReceiptBerlian\Http\Controllers;

use App\Models\LookUp;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\Adjustment\Entities\AdjustmentSetting;
use App\Models\User;
use Modules\GoodsReceiptBerlian\Models\QcAttribute;
use Modules\People\Entities\Supplier;
use Lang;
use Image;
use Illuminate\Support\Facades\DB;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;

class GoodsReceiptBerliansController extends Controller
{
    private $module_title;
    private $module_name;
    private $module_path;
    private $module_icon;
    private $module_model;
    private $module_categories;
    private $module_products;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Good Receipt Berlian';
        $this->module_name = 'goodsreceiptberlian';
        $this->module_path = 'goodsreceiptberlians';
        $this->module_icon = 'fas fa-sitemap';
        $this->module_model = "Modules\GoodsReceipt\Models\GoodsReceipt";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_name_singular = Str::singular($this->module_name);
        $module_action = 'List';
        $data = [
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_action' => $module_action,
            'module_icon' => $this->module_icon,
            'module_model' => $this->module_model,
        ];
        abort_if(Gate::denies('access_'.$this->module_name.''), 403);
        return view(''.$this->module_name.'::' . $this->module_path .'.index',$data);
    }
    
    public function indexqc()
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_name_singular = Str::singular($this->module_name);
        $module_action = 'List';
        $data = [
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_action' => $module_action,
            'module_icon' => $this->module_icon,
            'module_model' => $this->module_model,
        ];
        abort_if(Gate::denies('access_'.$this->module_name.''), 403);
        return view(''.$this->module_name.'::' . $this->module_path .'.qc.index',$data);
    }

    public function index_data(Request $request)
    {
        $module_name = $this->module_name;
        $module_name = \Modules\GoodsReceipt\Models\GoodsReceipt::with('pembelian');
        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;

        $module_name->where('kategoriproduk_id', $id_kategoriproduk_berlian);
        if($request->has('is_qc')){
            $module_name->where('is_qc', $request->input('is_qc'));
        }
        $module_name->latest()->get();
        
        return Datatables::of($module_name)

            ->addColumn('action', function ($data) {
                $datas = [
                    'module_name' => $this->module_name,
                    'module_model' => $this->module_model,
                    'data' => $data,
                ];
                    return view(''.$this->module_name.'::'.$this->module_path.'.action', $datas);
                })

            ->editColumn('image', function ($data) {
                    if ($data->images) {
                        $url = asset(imageUrl(). @$data->images);
                    } else {
                        $url = $data->getFirstMediaUrl('pembelian', 'thumb');
                    }
                    return '<img src="'.$url.'" border="0" width="50" class="img-thumbnail" align="center"/>';
                })

            ->editColumn('date', function ($data) {
                    $tb = '<div class="text-xs font-semibold">
                        ' .$data->code . '
                    </div>';
                    $tb .= '<div class="text-xs text-left">
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
                    $tb = '<div class="text-xs">
                            Berat Kotor :' .$data->total_berat_kotor . '
                        </div>';
                        $tb .= '<div class="text-xs text-left">
                        Total Emas :' .$data->total_emas . '
                        </div>';   
                    return $tb;
                }) 

            ->editColumn('harga', function ($data) {
                    $tb = '<div class="text-xs">
                        Gram : <span class="font-semibold">' .$data->selisih . '</span>
                        </div>';
                        $tb .= '<div class="text-xs text-left">
                            Nominal :<span class="font-semibold">' .number_format($data->selisih) . '</span>
                        </div>';   
                    return $tb;
                })
            ->editColumn('pembayaran', function ($data) {
                if(!empty($data->pembelian->tipe_pembayaran)){
                    if ($data->pembelian->tipe_pembayaran == 'jatuh_tempo') {
                        $info =  'Jatuh Tempo';
                        $pembayaran =  tgljam(@$data->pembelian->jatuh_tempo);
                        if(!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                        $info .=' (Lunas) ';
                        }
                    }else if ($data->pembelian->tipe_pembayaran == 'cicil') {
                        $info =  'Cicilan';
                        $pembayaran =  @$data->pembelian->cicil .' kali';
                        if(!empty(@$data->pembelian->lunas) && @$data->pembelian->lunas == 'lunas') {
                        $pembayaran .=' (Lunas) ';
                        }
                    } else {
                        $info =  '';
                        $pembayaran =  'Lunas';
                    }
                    $tb ='<div class="items-left text-left">
                            <div class="small text-gray-800">'.$info.'</div>
                            <div class="text-gray-800">' .$pembayaran. '</div>
                            </div>';
                    return $tb;
                }
                })

            ->editColumn('supplier', function ($data) {
                    $tb = '<div class="items-left text-left">
                        <div>'.$data->supplier->supplier_name . '</div>
                        </div>';
                    return $tb;
                })
            ->editColumn('updated_at', function ($data) {
                    $diff = Carbon::now()->diffInHours($data->updated_at);
                    if ($diff < 25) {
                        return \Carbon\Carbon::parse($data->updated_at)->diffForHumans();
                    } else {
                        return \Carbon\Carbon::parse($data->created_at)->isoFormat('L');
                    }
                })
                
            ->editColumn('keterangan', function ($data) {
                return '';
            })
                
            ->editColumn('note', function ($data) {
                return '';
            })
            ->rawColumns(['updated_at',
                'date',
                'action',
                'code',
                'berat',
                'harga',
                'image', 
                'pembayaran', 
                'supplier', 
                'nama_produk'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create_qc()
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        $module_name_singular = Str::singular($this->module_name);
        $code = $this->module_model::generateCode();
        $kasir = User::role('Kasir')->orderBy('name')->get();
        $module_action = 'Create';
        $dataSupplier = Supplier::all();
        $qcattribute = QcAttribute::all();
        
        $data = [
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_action' => $module_action,
            'module_icon' => $this->module_icon,
            'module_model' => $this->module_model,
            'code' => $code,
            'kasir' => $kasir,
            'dataSupplier' => $dataSupplier,
            'qcAttribute' => $qcattribute,
        ];
        abort_if(Gate::denies('add_'.$this->module_name.''), 403);
        return view(''.$this->module_name.'::'.$this->module_path.'.qc.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store_qc(Request $request)
    {
        if(AdjustmentSetting::exists()){
            toast('Stock Opname sedang Aktif!', 'error');
            return redirect()->back();
        }
        
        try {
            $module_name_singular = Str::singular($this->module_name);
            $input = $request->except('_token','document');
            $input['images'] = '';
            if ($request->filled('image')) {
                $img = $request->image;
                $folderPath = "uploads/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('public')->put($file,$image_base64);
                $input['images'] = "$fileName";
            }
            DB::beginTransaction();
            $goodsreceipt = $this->module_model::create([
                'code'                  => $input['code'],
                'date'                  => $input['tanggal'],
                'no_invoice'            => $input['code'],
                'total_berat_kotor'     => !empty($input['total_berat_kotor']) ? $input['total_berat_kotor'] :  0,
                'total_emas'            => !empty($input['total_emas']) ? $input['total_emas'] :  0,
                'berat_timbangan'       => !empty($input['berat_timbangan']) ? $input['berat_timbangan'] :  0,
                'total_karat'           => !empty($input['total_karat']) ? $input['total_karat'] :  0,
                'supplier_id'           => $input['supplier_id'],
                'karat_id'              => $input['karat_id'],
                'user_id'               => $input['pic_id'],
                'nama_produk'           => $input['nama_produk'],
                'kategoriproduk_id'     => $input['kategoriproduk_id'],
                'images'                => $input['images'],
                'is_qc'                 => 1,
            ]);
            $goodsreceipt_id = $goodsreceipt->id;
            $qcattribute_data = [];
            if(!empty($input['items'])){
                foreach($input['items'] as $val) {
                    $val['goodsreceipt_id'] = $goodsreceipt_id;
                    $val['berat_real'] = !empty($val['berat_real']) ? $val['berat_real'] : 0;
                    $val['berat_kotor'] = !empty($val['berat_kotor']) ? $val['berat_kotor'] : 0;
                    if(!empty($val['karatberlians_id'])) {
                        $qcattribute_data[] = $val;
                    }
                }
            }

            if(!empty($qcattribute_data)) {
                GoodsReceiptItem::insert($qcattribute_data);
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
        DB::commit();
        activity()->log(' '.auth()->user()->name.' input data penerimaan QC');
        toast(''. $this->module_title.' QC Created!', 'success');
        return redirect()->route(''.$this->module_name.'.qc.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show_qc($id)
    {
        $id = decode_id($id);
        $module_name_singular = Str::singular($this->module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_'.$this->module_name.''), 403);
        $detail = $this->module_model::with('goodsReceiptQcAttribute.qcAttribute','supplier')->findOrFail($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        return view(''.$this->module_name.'::'.$this->module_path.'.qc.show',
        compact('module_name',
        'module_action',
        'detail',
        'module_title',
        'module_icon', 'module_model'));

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
          return view(''.$module_name.'::'.$module_path.'.show',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit_qc($id)
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
        $dataSupplier = Supplier::all();
          return view(''.$module_name.'::'.$module_path.'.qc.edit',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'dataSupplier',
            'module_icon', 'module_model'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update_qc(Request $request)
    {
        try {
            $module_title = $this->module_title;
            $module_name = $this->module_name;
            $module_model = $this->module_model;
            $id = $request->input('id');

            DB::beginTransaction();
            
            $data = $module_model::findOrFail($id);
            $params = $request->except('_token', 'code');
            $keterangan = isset($params['keterangan']) && is_array($params['keterangan']) ? $params['keterangan'] : [];
            $notes = isset($params['note']) && is_array($params['note']) ? $params['note'] : [];
            $ids = isset($params['attributesqc_id']) && is_array($params['attributesqc_id']) ? $params['attributesqc_id'] : [];

            $params['images'] =  "";
            if ($request->filled('image')) {
                $img = $request->image;
                $folderPath = "uploads/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('public')->put($file,$image_base64);
                $params['images'] = "$fileName";
            }

            $update_data = [
                'date'                  => $params['tanggal'],
                'total_berat_kotor'     => 0,
                'berat_timbangan'       => 0,
                'supplier_id'           => $params['supplier_id'],
                'nama_produk'           => $params['nama_produk'],
                'kategoriproduk_id'     => $params['kategoriproduk_id'],
                'images'                => isset($params['images']) ? $params['images'] : '',
                'is_qc'                 => 1,
            ];
            $data->update($update_data);
            
            $goodsreceipt_id = $id;
            
            $qcattribute_data = [];
            foreach ($keterangan as $key => $value) {
                $qcattribute_data[] = [
                    'id' => $key,
                    'goodsreceipt_id' => $goodsreceipt_id,
                    'attributesqc_id' => isset($ids[$key]) ? $ids[$key] :'',
                    'keterangan' => $value,
                    'note' => isset($notes[$key]) ? $notes[$key] :'',
                ];
            }
            GoodsReceiptQcAttribute::upsert($qcattribute_data, ['id']);
            DB::commit();
        } catch (\Throwable $th) {
            return $th->getMessage();
            DB::rollBack();
            toast($th->getMessage() .' '. $module_title.' QC Not Updated!', 'failed');
            return redirect()->back();
        }
        activity()->log(' '.auth()->user()->name.' update goodreceipts berlian qc');
        toast(''. $module_title.' QC Updated!', 'success');
        return redirect()->route(''.$module_name.'.qc.index');
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
        // dd($e);
                toast(''. $module_title.' error!', 'warning');
                return redirect()->back();
            }

    }

    }
