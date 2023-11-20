<?php

namespace App\Http\Livewire\Produksi;

use Livewire\Component;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
use Modules\Produksi\Http\Controllers\ProduksisController;
use Modules\Karat\Models\Karat;
use Modules\KaratBerlian\Models\KaratBerlian;
use Modules\KaratBerlian\Models\ShapeBerlian;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Group\Models\Group;
use Modules\Produksi\Models\Produksi;
use Modules\Stok\Models\StockKroom;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use App\Models\LookUp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\GoodsReceipt\Models\GoodsReceiptItem;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductItem;
use Modules\Produksi\Models\DiamondCertificateAttribute;
use Modules\Produksi\Models\DiamondCertificateAttributes;
use Modules\Produksi\Models\DiamondCertifikatT;
use Modules\Produksi\Models\ProduksiItems;

use function PHPUnit\Framework\isEmpty;

class Create extends Component
{
    use WithFileUploads;
    public $source_kode = 'lantakan',
        $berat_asal,
        $karatasal_id,
        $karat_id,
        $kategoriproduk_id,
        $berat,
        $tanggal,
        $karat24k,
        $id_kategoriproduk_berlian,
        $code,
        $image,
        $harga_jual,
        $model_id;

    public $inputs = [
        [
            'id_items' => '',
            'type' => '2',
            'karatberlians' => '',
            'shapeberlian_id' => '',
            'qty' => 1,
            'gia_report_number' => '',
            'keterangan' => ''
        ]
    ];

    public $dataKarat = [];
    public $dataKaratArray = [];
    public $dataKaratBerlian = [];
    public $dataShapes = [];
    public $dataKategoriProduk = [];
    public $dataGroup = [];
    public $dataGroupArray = [];
    public $arrayKaratBerlian = [];
    public $dataCertificateAttribute = [];
    public $dataItemProduksi = [];
    public $dataItemProduksiArray = [];
    public $dataPenerimaanBerlian = [];
    public $dataPenerimaanBerlianArray = [];
    public $sertifikat = [
        'code' => '',
        'tanggal' => '',
    ];

    public $currentKey;
    public $tmpCertificate = [];

    public $hari_ini;
    public $category_id;
    public $produksi_item_id;

    public function mount()
    {
        $this->dataKarat = Karat::whereNull('parent_id')->get();
        $this->dataKaratBerlian = KaratBerlian::all();
        $this->dataShapes = ShapeBerlian::all();
        $this->dataGroup = Group::all();
        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
        $id_karat_24k = LookUp::select('value')->where('kode', 'id_karat_emas_24k')->first();
        $this->karat24k = !empty($id_karat_24k['value']) ? $id_karat_24k['value'] : 0;
        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $this->id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;
        $this->dataKategoriProduk = Category::where('kategori_produk_id', $this->id_kategoriproduk_berlian)->get();
        $this->dataCertificateAttribute = DiamondCertificateAttributes::all();
        $this->code = Product::generateCode();
        $this->sertifikat['tanggal'] = $this->hari_ini;

        $arrayKaratBerlian = [];
        foreach($this->dataKaratBerlian as $k => $row){
            $arrayKaratBerlian[$row->id] = $row->karat;
        }

        $this->arrayKaratBerlian = $arrayKaratBerlian;

        $this->karatasal_id = $this->karat24k;
        $this->kategoriproduk_id = $this->id_kategoriproduk_berlian;
        $this->category_id = Category::where('kategori_produk_id', $this->id_kategoriproduk_berlian)->first()->value('id');
        $this->dataItemProduksi = ProduksiItems::with('model', 'karat')->where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->where('status', 1)->get();
        $this->dataPenerimaanBerlian = GoodsReceiptItem::with('shape_berlian', 'goodsreceiptitem')->where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->where('status', 1)->get();
        $this->dataPenerimaanBerlianArray = $this->dataPenerimaanBerlian->map(function($data){
                                                                        return $data;
                                                                    })
                                                                    ->flatten()
                                                                    ->keyBy('id')
                                                                    ->toArray();
        $this->dataGroupArray = $this->dataGroup->map(function($data){
                                                    return $data;
                                                })
                                                ->flatten()
                                                ->keyBy('id')
                                                ->toArray();
        $this->dataKaratArray = $this->dataKarat->map(function($data){
                                                    return $data;
                                                })
                                                ->flatten()
                                                ->keyBy('id')
                                                ->toArray();
        $this->dataItemProduksiArray = $this->dataItemProduksi->map(function($data){
                                                    return $data;
                                                })
                                                ->flatten()
                                                ->keyBy('id')
                                                ->toArray();                                                                    
    }

    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset'
    ];

    public function handleWebcamCaptured($data_uri){
        $this->image= $data_uri;
    }

    public function addInput()
    {
        $this->inputs[] = [
            'id_items' => '',
            'type' => '2',
            'karatberlians' => '',
            'shapeberlian_id' => '',
            'qty' => 1,
            'gia_report_number' => '',
            'keterangan' => ''
        ];
    }

    public function remove($i)
    {
        $this->resetErrorBag();
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
    }

    public function render()
    {

        $this->model_id = !empty($this->dataItemProduksiArray[$this->produksi_item_id]['model_id']) ? $this->dataItemProduksiArray[$this->produksi_item_id]['model_id'] : null;
        $this->karat_id = !empty($this->dataItemProduksiArray[$this->produksi_item_id]['karat_id']) ? $this->dataItemProduksiArray[$this->produksi_item_id]['karat_id'] : null;
        $this->berat = !empty($this->dataItemProduksiArray[$this->produksi_item_id]['berat']) ? $this->dataItemProduksiArray[$this->produksi_item_id]['berat'] : null;
        $this->tanggal = $this->hari_ini;
        return view('livewire.produksi.create');
    }

    private function resetInputFields()
    {
        $this->inputs = [
            [
                'id_items' => '',
                'type' => '2',
                'karatberlians' => '',
                'shapeberlian_id' => '',
                'qty' => 1,
                'gia_report_number' => '',
                'keterangan' => ''
            ]
        ];
    }


    public function rules()
    {
        $rules = [
            'produksi_item_id' => 'required',
            'code' => 'required|unique:products,product_code',
            'model_id' => 'required',
            'karat_id' => 'required',
            'category_id' => 'required',
            'harga_jual' => 'required',
            'berat' => 'required',
        ];

        /** rules cek stok lantakan */
        // if($this->source_kode == "lantakan") {
        //     $rules['berat_asal'] = [
        //         'required',
        //         function ($attribute, $value, $fail) {
        //             $stok_lantakan = StockKroom::sum('weight');
        //             $stok_lantakan_terpakai = Produksi::where('source_kode', $this->source_kode)->sum('berat_asal');
        //             $sisa_stok_lantakan = $stok_lantakan - $stok_lantakan_terpakai;
        //             if ($value > $sisa_stok_lantakan) {
        //                 $fail('Sisa stok tidak mencukupi, berat asal harus kurang dari sama dengan '. $sisa_stok_lantakan);
        //             }
        //         }

        //     ];

        //     /** validasi stok berlian
        //      * cek dulu apakah ini produksi berlian
        //      * collect data stok per jenis karat
        //      * bandingkan stok
        //      */
        //     if($this->kategoriproduk_id == $this->id_kategoriproduk_berlian && !empty($this->inputs[0]['karatberlians'])) {
        //         $sisa_stok_berlian = GoodsReceipt::where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->sum('total_karat');
        //         $total_karat_dipinta = 0;
        //         foreach ($this->inputs as $key => $value) {
        //             $rules['inputs.' . $key . '.karatberlians'] = 'required|gt:0';
        //             $rules['inputs.' . $key . '.qty'] = 'required|gt:0';

        //             $qty = !empty($value['qty']) ? $value['qty'] : 0;
        //             $karat = !empty($value['karatberlians']) ? $value['karatberlians'] : 0;
        //             if(filter_var($karat, FILTER_VALIDATE_FLOAT)) {
        //                 $stok_berlian_terpakai = $karat * $qty;
        //                 $total_karat_dipinta += $stok_berlian_terpakai;
    
        //                 if($sisa_stok_berlian < $total_karat_dipinta) {
        //                     $rules['inputs.' . $key . '.karatberlians'] = [
        //                         function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
        //                             $fail('Sisa stok tidak mencukupi, sisa stok berlian saat ini ' . $sisa_stok_berlian . ' ct');
        //                         }
        //                     ];

        //                     $rules['inputs.' . $key . '.qty'] = [
        //                         function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
        //                             $fail('Sisa stok tidak mencukupi, sisa stok berlian saat ini ' . $sisa_stok_berlian . ' ct');
        //                         }
        //                     ];
    
        //                 }
        //             }else{
        //                 $rules['inputs.' . $key . '.karatberlians'] = [
        //                     function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
        //                         $fail('input karat berlians harus berupa decimal');
        //                     }
        //                 ];
        //             }
                    
        //         }

        //     }
        // }
            /** validasi stok berlian
              * cek dulu apakah ini produksi berlian
              * collect data stok per jenis karat
              * bandingkan stok
              */
            if($this->kategoriproduk_id == $this->id_kategoriproduk_berlian && !empty($this->inputs[0]['karatberlians'])) {
                $sisa_stok_berlian = GoodsReceipt::where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->sum('total_karat');
                $total_karat_dipinta = 0;
                foreach ($this->inputs as $key => $value) {
                    $rules['inputs.' . $key . '.id_items'] = 'required';
                    $rules['inputs.' . $key . '.karatberlians'] = 'required|gt:0';
                    $rules['inputs.' . $key . '.qty'] = 'required|gt:0';

                    $qty = !empty($value['qty']) ? $value['qty'] : 0;
                    $karat = !empty($value['karatberlians']) ? $value['karatberlians'] : 0;
                    if(filter_var($karat, FILTER_VALIDATE_FLOAT)) {
                        $stok_berlian_terpakai = $karat * $qty;
                        $total_karat_dipinta += $stok_berlian_terpakai;
    
                        if($sisa_stok_berlian < $total_karat_dipinta) {
                            $rules['inputs.' . $key . '.karatberlians'] = [
                                function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
                                    $fail('Sisa stok tidak mencukupi, sisa stok berlian saat ini ' . $sisa_stok_berlian . ' ct');
                                }
                            ];

                            $rules['inputs.' . $key . '.qty'] = [
                                function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
                                    $fail('Sisa stok tidak mencukupi, sisa stok berlian saat ini ' . $sisa_stok_berlian . ' ct');
                                }
                            ];
    
                        }
                    }else{
                        $rules['inputs.' . $key . '.karatberlians'] = [
                            function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
                                $fail('input karat berlians harus berupa decimal');
                            }
                        ];
                    }
                    
                }

            }

        return $rules;
    }

    public function messages()
    {
        return [
            'karatasal_id.required' => 'Karat asal harus diisi!',
            'karat_id.required' => 'Karat jadi harus diisi!',
            'berat.required' => 'Berat jadi harus diisi!',
        ];
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit(Request $request)
    {
        /** Blok untuk ngeset sertifikat ke item diamond 
         * Blok ini dicomment dlu, awalnya ini untuk sertifikat per item diamond
        */
        // if(!empty($this->inputs)) {
        //     foreach($this->inputs as $k => $item) {
        //         $this->inputs[$k]['sertifikat'] = !empty($this->sertifikat[$k]) ? $this->sertifikat[$k] : [];
        //     }
        // }

        $this->validate();

        $data = [
            'produksi_item_id' => $this->produksi_item_id,
            'code' => $this->code,
            'image' => $this->image,
            'karatasal_id' => $this->karatasal_id,
            'karat_id' => $this->karat_id,
            'model_id' => !empty($this->model_id) ? $this->model_id : null,
            'source_kode' => $this->source_kode,
            'berat_asal' => $this->berat_asal,
            'berat' => $this->berat,
            'tanggal' => $this->tanggal,
            'created_by' => auth()->user()->id,
            'items' => $this->inputs,
            'kategoriproduk_id' => $this->kategoriproduk_id,
            'category_id' => $this->category_id,
            'harga_jual' => $this->harga_jual,
        ];
        
        DB::beginTransaction();
        try {
            $attribute = [];
            if(!empty($this->sertifikat) && !empty($this->sertifikat['code'] || !empty($this->sertifikat['attribute']))) {
                $sertifikat = $this->sertifikat;
                $attribute = !empty($sertifikat['attribute']) ? $sertifikat['attribute'] : [];
                if(isset($sertifikat['attribute'])) {
                    unset($sertifikat['attribute']);
                }

                $hari_ini = new DateTime();
                $hari_ini = $hari_ini->format('Y-m-d');
                $sertifikat['tanggal'] = !empty($sertifikat['tanggal']) ? $sertifikat['tanggal'] : $hari_ini;
                $sertifikat['code'] = !empty($sertifikat['code']) ? $sertifikat['code'] : '-';
                $diamond_certificate = DiamondCertifikatT::create($sertifikat);
    
                $dataInsertSertifikatAttribute = $attribute;
                foreach($dataInsertSertifikatAttribute as $k => $row) {
                    $dataInsertSertifikatAttribute[$k]['diamond_certificate_id'] = $diamond_certificate->id;
                    $dataInsertSertifikatAttribute[$k]['diamond_certificate_attributes_id'] = $k;
                    $dataInsertSertifikatAttribute[$k]['keterangan'] = !empty($row['keterangan']) ? $row['keterangan'] : '';
                }
                DiamondCertificateAttribute::insert($dataInsertSertifikatAttribute);
    
            }
            $model_name = !empty($this->dataGroupArray[$this->model_id]['name']) ? $this->dataGroupArray[$this->model_id]['name'] : '';
            $karat_name = !empty($this->dataKaratArray[$this->karat_id]['name']) ? $this->dataKaratArray[$this->karat_id]['name'] : '';
            $total_karat_berlians = 0;
            if(!empty($this->inputs)) {
                foreach($this->inputs as $item) {
                    $total_karat_berlians += !empty($item['karatberlians']) ? $item['karatberlians'] : 0;
                }
            }

            $image= '';
            if ($this->image) {
                $img = $this->image;
                $folderPath = "uploads/produksi/";
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName ='webcam_'. uniqid() . '.jpg';
                $file = $folderPath . $fileName;
                Storage::disk('public')->put($file,$image_base64);
                $image = "$fileName";
            }

            $product = Product::create([
                'category_id' => $this->category_id,
                'cabang_id' => null,
                'product_stock_alert' => 5,
                'product_name' => $model_name .' '. $karat_name . ' Berlian',
                'product_code' => $this->code,
                'images' => $this->image,
                'product_price' => $this->harga_jual,
                'product_barcode_symbology' => 'C128',
                'product_unit'              => 'Gram',
                'karat_id'                  => $this->karat_id,
                'group_id'                  => $this->model_id,
                'berat_emas'                => $this->berat,
                'total_karatberlians'       => $total_karat_berlians,
                'diamond_certificate_id'    => !empty($diamond_certificate->id) ? $diamond_certificate->id : null,
                'images'                    => $image,
                'status_id'                 => 11,
                'produksi_item_id'          => $this->produksi_item_id,
            ]);

            
            $produksi_items = $this->inputs;

            if (!empty($produksi_items)) {
                $array_produksi_items = [];
                $array_goodsreceipt_item = [];
                foreach($produksi_items as $val) {
                    $goodsreceipt_item_id = !empty($val['id_items']) ? $val['id_items'] : null;
                    $valItem = !empty( $dataPenerimaanBerlianArray[$goodsreceipt_item_id]) ?  $dataPenerimaanBerlianArray[$goodsreceipt_item_id] : [];
                    $diamond_berlian_item = !empty($valItem['diamond_certificate_id']) ? $valItem['diamond_certificate_id'] : null;
                    $valGoodReceipt = !empty($valItem['goodsreceipt']) ? $valItem['goodsreceipt'] : [];
                    $diamond_berlian = !empty($valGoodReceipt['diamond_certificate_id']) ? $valGoodReceipt['diamond_certificate_id'] : null;
                    $karatberlians = !empty($val['karatberlians']) ? $val['karatberlians'] : 0;
                    $array_produksi_items[] = [
                        'product_id' => $product->id,
                        'goodsreceipt_item_id' => $goodsreceipt_item_id,
                        'karatberlians' => $karatberlians,
                        'shapeberlians_id' => !empty($val['shapeberlian_id']) ? $val['shapeberlian_id'] : null,
                        'qty' => !empty($val['qty']) ? $val['qty'] : 0,
                        'diamond_certificate_id' => !empty($diamond_berlian_item) ? $diamond_berlian_item : $diamond_berlian,
                        'gia_report_number' => !empty($val['gia_report_number']) ? $val['gia_report_number'] : null
                    ];
                    $oldkaratberlian = !empty($valItem['karatberlians']) ? $valItem['karatberlians'] : 0;
                    $karatberlianterpakai = !empty($valItem['karatberlians_terpakai']) ? $valItem['karatberlians_terpakai'] : 0;
                    
                    $status = ($oldkaratberlian >= $karatberlianterpakai + $karatberlians) ? 2 : 1;
                    $array_goodsreceipt_item[] = [
                        'id' => $goodsreceipt_item_id,
                        'karatberlians_terpakai' => $karatberlianterpakai + $karatberlians,
                        'status' => $status,
                    ];
                }

                ProductItem::insert($array_produksi_items);
                if(!empty($array_goodsreceipt_item)) { 
                    foreach($array_goodsreceipt_item as $item) {
                        GoodsReceiptItem::where('id', $item['id'])->update([
                            'karatberlians_terpakai' => $item['karatberlians_terpakai'],
                            'status' => $item['status'],
                        ]);
                    }
                }
                ProduksiItems::where('id', $this->produksi_item_id)->update(['status'=>2]);

            }

        } catch (\Throwable $th) {
            DB::rollBack();
            if(!empty($file)) {
                Storage::disk('public')->delete($file);
            }
            dd($th->getMessage());
            return $th->getMessage();
        }
        DB::commit();
        activity()->log(' '.auth()->user()->name.' input data pembuatan product ' . !empty($product->id) ? $product->id : '');
        toast('Produk Berhasil dibuat!', 'success');
        return redirect()->route('produksi.index');
    }

    public function setCurrentKey($key)
    {
        $this->currentKey = $key;
    }
    
}
