<?php

namespace Modules\GoodsReceipt\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
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
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\KategoriProduk\Models\KategoriProduk;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
        $this->module_categories = "Modules\Product\Entities\Category";
        $this->module_products = "Modules\Product\Entities\Product";


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

 public function riwayat_penerimaan() {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'List';
        abort_if(Gate::denies('access_'.$module_name.''), 403);
         return view(''.$module_name.'::'.$module_path.'.riwayat',
           compact('module_name',
            'module_action',
            'module_title',
            'module_icon', 'module_model'));
    }




public function index_data_product(Request $request ,$kode_pembelian)

    {
       // $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        //$$module_name = $module_model::get();

        $$module_name = $module_model::select('goodsreceipts.*'
            ,
            'products.id AS id_produk',
            'products.product_name',
            'products.product_code',
            'products.product_cost',
            'products.product_price',
            'product_items.berat_total')
           ->leftJoin('products', 'goodsreceipts.code', '=', 'products.kode_pembelian')
           ->leftJoin('product_items', 'products.id', '=', 'product_items.product_id')
            ->where('products.kode_pembelian',$kode_pembelian)
            ->get();


        $data = $$module_name;



        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                            $module_products = $this->module_products;
                              return view(''.$module_name.'::'.$module_path.'.actiondetail',
                            compact('module_name', 'data', 'module_model'));
                                })
                          ->editColumn('date', function ($data) {
                             $tb = '<div class="text-xs items-left text-left">
                                     ' .tanggal($data->date) . '
                                    </div>';
                                return $tb;
                            }) 
                           ->editColumn('name', function ($data) {
                             $tb = '<div class="text-xs items-left text-left">

                                     <div class="text-gray-500">' .$data->product_code . '</div>
                                     <div class="text-blue-500">' .$data->product_name . '</div>
                                     <div class="text-gray-500">' .$data->berat_total . ' / 005</div>

                                    </div>';
                                return $tb;
                            })
                           ->editColumn('qty', function ($data) {
                             $tb = '<div class="small text-gray-500 items-center text-center">
                                     Beli ;' .$data->product_cost . '

                                    </div>';
                                     $tb .= '<div class="small text-gray-500  items-center text-center">
                                     Jual :' .$data->product_price . '

                                    </div>';
                                return $tb;
                            }) 
                           ->editColumn('image', function ($data) {
                             $module_products = $this->module_products;
                             $produk = $module_products::findOrFail($data->id_produk);
                               $images ='<div class="content-center items-center">
                               <img class="w-10 h-10 rounded" src="'. $produk->getFirstMediaUrl('images') . '"
                               style="height:50px; width:50px;">';
                                return $images;
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
                         'detail', 
                         'name'])
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

        $$module_name = $module_model::active()->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                              return view(''.$module_name.'::'.$module_path.'.action',
                            compact('module_name', 'data', 'module_model'));
                                })

                         ->editColumn('image', function ($data) {
                               $images ='<div class="content-center items-center">
                               <img class="w-10 h-10 rounded" src="'.  asset(imageUrl(). @$data->images) . '"
                               style="height:50px; width:50px;">';
                                return $images;
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
                                     ' .$data->berat_barang . ' Gram
                                    </div>';
                                return $tb;
                            }) 

                          ->editColumn('detail', function ($data) {
                            if ($data->count == 0) {
                               $qty = $data->qty_diterima;
                            } else {
                               $qty = $data->count;
                            }

                             $tb = '<div class="font-semibold items-center text-center">

                             <div class="bg-green-400 px-1 items-center text-center rounded-lg">
                                    ' .$qty . '  / ' .$data->qty_diterima . '

                             </div>
                                  
                                    </div>';
                                return $tb;
                            })  

                           ->editColumn('qty', function ($data) {
                             $tb = '<div class="items-left text-left">
                                    <div>Diterima : ' .$data->qty_diterima . '</div>
                                    <div>Nota :' .$data->qty . '</div>
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
                         'detail', 
                         'name'])
                        ->make(true);
                     }



public function index_data_completed(Request $request)

    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::completed()->get();

        $data = $$module_name;

        return Datatables::of($$module_name)
                        ->addColumn('action', function ($data) {
                            $module_name = $this->module_name;
                            $module_model = $this->module_model;
                            $module_path = $this->module_path;
                              return view(''.$module_name.'::'.$module_path.'.action',
                            compact('module_name', 'data', 'module_model'));
                                })

                         ->editColumn('image', function ($data) {
                               $images ='<div class="content-center items-center">
                               <img class="w-10 h-10 rounded" src="'.  asset(imageUrl(). @$data->images) . '"
                               style="height:50px; width:50px;">';
                                return $images;
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
                                     ' .$data->berat_barang . ' Gram
                                    </div>';
                                return $tb;
                            })

                          ->editColumn('detail', function ($data) {
                            if ($data->count == 0) {
                               $qty = $data->qty_diterima;
                            } else {
                               $qty = $data->count;
                            }

                             $tb = '<div class="font-semibold items-center text-center">

                             <div class="bg-green-400 px-1 items-center text-center rounded-lg">
                                    ' .$qty . '  / ' .$data->qty_diterima . '

                             </div>

                                    </div>';
                                return $tb;
                            })

                           ->editColumn('qty', function ($data) {
                             $tb = '<div class="items-left text-left">
                                    <div>Diterima : ' .$data->qty_diterima . '</div>
                                    <div>Nota :' .$data->qty . '</div>
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
                         'detail',
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
            $kasir = User::role('Kasir')->orderBy('name')->get();
            $module_action = 'Create';
            abort_if(Gate::denies('add_'.$module_name.''), 403);
              return view(''.$module_name.'::'.$module_path.'.create',
               compact('module_name',
                'module_action',
                'code',
                'kasir',
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
        if ($image = $request->file('images')) {
         $gambar = 'pembelian_'.date('YmdHis') . "." . $image->getClientOriginalExtension();
           // dd($gambar);
         $normal = Image::make($image)->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    })->encode();
         $normalpath = 'uploads/' . $gambar;
         Storage::disk('public')->put($normalpath, (string) $normal);
                $input['images'] = "$gambar";
         //dd($xx);
        }else{
           $input['images'] = 'no_foto.png';
        }


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
             $input['images'] =  "$fileName";
          
            }


        //dd($input);
        $$module_name_singular = $module_model::create([
            'code'                       => $input['code'],
            'no_invoice'                 => $input['no_invoice'],
            'qty'                        => $input['qty'],
            'qty_diterima'               => $input['qty_diterima'],
            'date'                       => $input['date'],
            'status'                     => $input['status'],
            'supplier_id'                => $input['supplier_id'],
            'user_id'                    => $input['user_id'],
            'parameter_kadar_id'         => null,
            'berat_barang'               => $input['berat_barang'],
            'berat_real'                 => $input['berat_real'],
            'count'                      => $input['qty'],
            'images'                     => $input['images'],
            'pengirim'                   => $input['pengirim']
        ]);

        
          
           activity()->log(' '.auth()->user()->name.' input data pembelian');
         
          toast(''. $module_title.' Created!', 'success');
           return redirect()->route(''.$module_name.'.index');
  
         }




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
            'no_invoice' => 'required|min:3|max:191',
                 ]);
        $params = $request->except('_token','upload','image');
        $params['no_invoice'] = $params['no_invoice'];
        $params['count'] = $params['qty_diterima'];
        $params['date'] = $params['date'];


        if ($request->filled('images')) {
            $img = $request->image;
            $folderPath = "uploads/";
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName ='webcam_'. uniqid() . '.jpg';
            $file = $folderPath . $fileName;
            Storage::disk('public')->put($file,$image_base64);
             $params['images'] =  "$fileName";

            }
            else{
            unset($params['images']);
             }

         activity()->log(' '.auth()->user()->name.' Edit Data pembelian');
        $$module_name_singular->update($params);
         toast(''. $module_title.' Updated!', 'success');
         return redirect()->route(''.$module_name.'.index');
    }


 public function update_status(Request $request, $id)
     {
                $id = decode_id($id);
                $module_name = $this->module_name;
                $module_model = $this->module_model;
                $module_title = $this->module_title;
                $penerimaan = $module_model::findOrFail($id);
                $penerimaan->status = 2;
                $penerimaan->save();
                toast(''. $module_title.' Updated!', 'success');
                activity()->log(' '.auth()->user()->name.' Update  pembelian');
                 return redirect()->route(''.$module_name.'.riwayat_penerimaan');
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

        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model = $this->module_model;
        $module_products = $this->module_products;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
        $list = $module_products::where('kode_pembelian',$detail->code)->get();
      //  dd($detail->code);
          return view(''.$module_name.'::'.$module_path.'.detail',
           compact('module_name',
            'module_action',
            'detail',
            'list',
            'module_title',
            'module_icon', 'module_model'));

    }

public function view_produk($id)
    {

        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model = $this->module_model;
        $module_products = $this->module_products;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_'.$module_name.''), 403);
        $detail = $module_products::select('products.*',
                                'products.id AS id_produk',
                                'goodsreceipts.code AS code',
                                'goodsreceipts.berat_barang'
                                 )
                    ->where('products.id',$id)
                    ->leftJoin('goodsreceipts', 'products.kode_pembelian', '=', 'goodsreceipts.code')
                    ->first();


        $produk = $module_products::findOrFail($detail->id_produk);
        $list = $module_products::where('kode_pembelian',$detail->code)->get();
      //  dd($detail->code);
          return view(''.$module_name.'::'.$module_path.'.view_produk',
           compact('module_name',
            'module_action',
            'detail',
            'produk',
            'list',
            'module_title',
            'module_icon', 'module_model'));

    }







public function print_produk($kode_pembelian)
    {

        //$kode_pembelian = decode_id($kode_pembelian);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_model = $this->module_model;
        $module_products = $this->module_products;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_'.$module_name.''), 403);
        $detail = $module_products::select('products.*',
                                'goodsreceipts.code AS code',
                                'goodsreceipts.berat_barang'
                                 )
                    ->where('products.kode_pembelian',$kode_pembelian)
                    ->leftJoin('goodsreceipts', 'products.kode_pembelian', '=', 'goodsreceipts.code')
                    ->get();


      //  dd($detail->code);
          return view(''.$module_name.'::'.$module_path.'.print_produk',
           compact('module_name',
            'module_action',
            'detail',
            'module_title',
            'module_icon', 'module_model'));

    }













//add produk detail modal
   public function add_produk_modal($id)
    {

        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';
        abort_if(Gate::denies('show_'.$module_name.''), 403);
        $listcategories = KategoriProduk::with('category')->get();
        $pembelian = $module_model::findOrFail($id);
        //dd($detail);
          return view(''.$module_name.'::'.$module_path.'.modal.catlist',
           compact('module_name',
            'module_action',
            'pembelian',
            'listcategories',
            'module_title',
            'module_icon', 'module_model'));

    }


 public function add_products_by_categories(Request $request ,$id) {
        $id = decode_id($id);
        $no_pembelian = $request->get('po') ?? '0';
        //dd($no_pembelian);
        abort_if(Gate::denies('access_products'), 403);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_categories = $this->module_categories;
        $module_name_singular = Str::singular($module_name);
        $main = KategoriProduk::where('id', $id)->first();
        $produkkategori = Category::where('kategori_produk_id', $id)->get();
        $categories = Category::where('kategori_produk_id', $id)->get();
        $pembelian = $module_model::where('code', $no_pembelian)->first();
        $code = Product::generateCode();
        $module_action = 'List';
         return view(''.$module_name.'::'.$module_path.'.form.create',
           compact('module_name',
                    'module_title',
                    'produkkategori',
                    'categories',
                    'main',
                    'no_pembelian',
                    'pembelian',
                    'code',
                    'module_icon', 'module_model'));
         }



    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderables
     */
    public function edit($id)
    {
        $id = decode_id($id);
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Edit';
        abort_if(Gate::denies('edit_'.$module_name.''), 403);
        $detail = $module_model::findOrFail($id);
        $kasir = User::role('Kasir')->orderBy('name')->get();
          return view(''.$module_name.'::'.$module_path.'.edit',
           compact('module_name',
            'module_action',
            'detail',
            'kasir',
            'module_title',
            'module_icon', 'module_model'));
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