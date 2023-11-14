<?php

namespace App\Http\Livewire\GoodsReceipt\Toko\BarangLuar\Item\Modal;

use App\Models\LookUp;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\DistribusiToko\Models\DistribusiTokoItem;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Stok\Models\StockOffice;
use Modules\GoodsReceipt\Models\Toko;

use function PHPUnit\Framework\isEmpty;

class Create extends Component
{
    public $date;
    public $today;
    public $customer;
    public $nominal = 0;
    public $nominal_text = '';
    public $dist_toko;
    public $data = [
        'additional_data' => [
            'product_category' => [
                'id' => '',
                'name' => ''
            ],
            'group' => [
                'id' => '',
                'name' => ''
            ],
            'model' => [
                'id' => '',
                'name' => ''
            ],
            'code' => '',
            'certificate_id' => '',
            'no_certificate' => '',
            'accessories_weight' => 0,
            'tag_weight' => 0,
            'image' => ''
        ],
        'gold_weight' => 0,
        'total_weight' => 0,
        'karat_id' => ''
    ];

    public $isLogamMulia;
    public $logam_mulia_id;

    public $karat_logam_mulia;

    public $dataLabel;

    public $categories;

    public $dataKarat;

    public $cabang;

    public $total_weight_per_karat = [];

    protected $listeners = [
        'setAdditionalAttribute',
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
    ];
    public function render(){
        return view("livewire.goods-receipt.toko.barangluar.item.modal.create");
    }

    public function handleWebcamCaptured($data_uri){
        $this->data['additional_data']['image'] = $data_uri;
    }

    public function handleWebcamReset(){
        $this->data['additional_data']['image'] = '';
    }

    


    public function mount(){
        $kategori = LookUp::where('kode','id_kategori_produk_emas')->value('value');
        $this->categories = Category::where('kategori_produk_id',$kategori)->get();
        $this->dataKarat = Karat::where(function ($query) {
            $query
                ->where('parent_id', null);
        })->get();
        
        $this->logam_mulia_id = Category::where('category_name','LIKE','%logam mulia%')->value('id');
        $this->karat_logam_mulia = Karat::logam_mulia()->id;

        $this->today = (new DateTime())->format('Y-m-d');
        $this->date = $this->today;
        $this->cabang = auth()->user()->namacabang->cabang;
    }

    public function setAdditionalAttribute($name,$selectedText){
        $this->data['additional_data'][$name]['name'] = $selectedText;
    }

    public function productCategoryChanged(){
        $this->clearKaratAndTotal();
        $this->isLogamMulia();
        if($this->data['additional_data']['product_category']['id'] == $this->logam_mulia_id){
            $this->data['karat_id'] = $this->karat_logam_mulia;
        }
    }

    public function clearKaratAndTotal(){
        $this->data['karat_id'] = '';
        $this->data['additional_data']['accessories_weight'] = 0;
        $this->data['additional_data']['tag_weight'] = 0;
        $this->data['gold_weight'] = 0;
        $this->data['total_weight'] = 0;
        $this->data['additional_data']['certificate_id'] = '';
        $this->data['additional_data']['no_certificate'] = '';
    }

    public function calculateTotalWeight(){
        $this->data['total_weight'] = 0;
        $this->data['total_weight'] += doubleval($this->data['gold_weight']);
        $this->data['total_weight'] += doubleval($this->data['additional_data']['accessories_weight']);
        $this->data['total_weight'] += doubleval($this->data['additional_data']['tag_weight']);
        $this->data['total_weight'] = round($this->data['total_weight'], 3);
    }


    private function isLogamMulia(){
        $this->isLogamMulia = $this->data['additional_data']['product_category']['id'] == $this->logam_mulia_id;
    }

    public function generateCode(){
        $this->checkGroup();
        $namagroup = Group::where('id', $this->data["additional_data"]["group"]["id"])->first()->code;
        $existingCode = true;
        $codeNumber = '';
        $cabang_code = $this->cabang->code;
        while ($existingCode) {
               $date = now()->format('dmY');
               $randomNumber = mt_rand(100, 999);
               $codeNumber = $cabang_code .'-'. $namagroup .'-'. $randomNumber .'-'. $date;
               $existingCode = Product::where('product_code', $codeNumber)->exists();
        }
        $this->data["additional_data"]["code"] = $codeNumber;
    }

    private function checkGroup(){
        $this->validateOnly("data.additional_data.group.id");
    }


    public function rules()
    {
        $rules = [
            'date' => 'required',
            'customer' => 'required',
            'nominal' => 'required|gt:0'
        ];


        $rules['data.additional_data.product_category.id'] = [
            'required',
        ];
        $rules['data.additional_data.group.id'] = 'required';
        $rules['data.additional_data.code'] = 'required|max:255|unique:products,product_code';
        $rules['data.karat_id'] = 'required';
        $rules['data.additional_data.accessories_weight'] = 'required_unless:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.additional_data.tag_weight'] = 'required_unless:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.gold_weight'] = [
            'required',
            'gt:0',
        ];
        $rules['data.total_weight'] = 'required|gt:0';
        $rules['data.additional_data.certificate_id'] = 'required_if:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.additional_data.no_certificate'] = 'required_if:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.additional_data.image'] = 'required';

        return $rules;
    }

    public function store()
    {
        $this->validate();
        
        DB::beginTransaction();
        try{
            $additional_data = [
                "product_information" => [
                    "product_category" => [
                        "id" => $this->data['additional_data']['product_category']['id'],
                        "name" => $this->data['additional_data']['product_category']['name']
                    ],
                    "group" => [
                        'id' => $this->data['additional_data']['group']['id'],
                        'name' => $this->data['additional_data']['group']['name']
                    ],
                    "model" => [
                        'id' => $this->data['additional_data']['model']['id'],
                        'name' => $this->data['additional_data']['model']['name']
                    ],
                    "code" => $this->data['additional_data']['code'],
                    'certificate_id' => $this->data['additional_data']['certificate_id'],
                    'no_certificate' => $this->data['additional_data']['no_certificate'],
                    'accessories_weight' => $this->data['additional_data']['accessories_weight'],
                    'tag_weight' => $this->data['additional_data']['tag_weight'],
                    'image' => $this->uploadImage($this->data['additional_data']['image']),
                    'total_weight' => $this->data['total_weight']
                ]
            ];
            // Create product first
            $product_data = [
                'category_id' => $this->data['additional_data']['product_category']['id'],
                'cabang_id' => $this->cabang->id,
                'product_stock_alert'        => 5,
                'group_id' => $this->data['additional_data']['group']['id'],
                'model_id' => $this->data['additional_data']['model']['id'],
                'karat_id' => $this->data['karat_id'],
                'berat_emas' => $this->data['gold_weight'],
                'status_id' => ProductStatus::PENDING_CABANG,
                'product_code'               => $this->data['additional_data']['code'],
                'product_barcode_symbology'  => 'C128',
                'product_unit'               => 'Gram',
                'images' => $this->uploadImage($this->data['additional_data']['image']),
            ];
            $product = Product::create($product_data);

            $product_item = $product->product_item()->create([
                'certificate_id'              => empty($this->data['additional_data']['certificate_id'])?null:$this->data['additional_data']['certificate_id'],
                'berat_label'                 => $this->data['additional_data']['tag_weight'],
                'berat_accessories'           => $this->data['additional_data']['accessories_weight'],
                'berat_total'                 => $this->data['total_weight'],
            ]);
            $product->statuses()->attach($product->status_id,['cabang_id' => $product->cabang_id, 'properties' => json_encode([
                'product' => $product,
                'product_additional_information' =>  $product_item
            ])]);

            $data = [
                'product_id' => $product->id,
                'cabang_id' => $this->cabang->id,
                'customer' => $this->customer,
                'pic_id' => auth()->id(),
                'nominal' => $this->nominal,
                'date' => $this->date,
                'type' => 2,
            ];

            Toko\GoodsReceiptItem::create($data);

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        toast('Berhasil Menyimpan Barang Luar','success');
        return redirect(route('goodsreceipt.toko.index'));
    }

    private function uploadImage($img){
        $folderPath = "uploads/";
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName ='webcam_'. uniqid() . '.jpg';
        $file = $folderPath . $fileName;
        Storage::disk('public')->put($file,$image_base64);
        return $fileName;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function messages(){
        return [
            'data.*.required' => 'Wajib di isi',
            'data.*.required_unless' => 'Wajib di isi',
            'data.*.gt' => 'Nilai harus lebih besar dari 0',
            'data.*.required_if' => 'Wajib di isi',    
            'data.*.*.required' => 'Wajib di isi',
            'data.*.*.required_unless' => 'Wajib di isi',
            'data.*.*.required_if' => 'Wajib di isi', 
            'data.*.*.*.required' => 'Wajib di isi',
            'data.*.*.*.required_if' => 'Wajib di isi',
            'data.*.*.*.required_unless' => 'Wajib di isi',
        ];
    }

    public function updatedNominal($value){
        $this->nominal_text = 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }
}
