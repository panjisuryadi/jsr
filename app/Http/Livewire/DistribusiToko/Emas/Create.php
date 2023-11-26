<?php

namespace App\Http\Livewire\DistribusiToko\Emas;

use App\Models\LookUp;
use DateTime;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;
use Modules\DistribusiToko\Models\DistribusiTokoItem;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\Produksi\Models\Produksi;
use Modules\Stok\Models\StockOffice;

use function PHPSTORM_META\type;
use function PHPUnit\Framework\isEmpty;

class Create extends Component
{

    public $categories;
    public $product_category;

    public $cabangs;

    public $kategori;

    public $logam_mulia_id;

    public $karat_logam_mulia;

    public $distribusi_toko = [
        'no_distribusi_toko' =>'',
        'date' => '',
        'cabang_id' => ''
    ];

    public $dataKarat = [];

    public $distribusi_toko_details = [];

    public $used_stock = [];

    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
        'setAdditionalAttribute'
    ];

    public $exceptProductId = [];

    public $produksis_id;

    public $search;

    public $kode_produk;

    public $product_categories;
    public $groups;
    public $models;

    public $isLogamMulia;

    public $new_product = [
        'product_category_id' => '',
        'group_id' => '',
        'model_id' => '',
        'code' => '',
        'karat_id' => '',
        'certificate_id' => '',
        'no_certificate' => '',
        'gold_weight' => 0,
        'total_weight' => 0,
        'accessories_weight' => 0,
        'tag_weight' => 0,
        'webcam_image' => ''
    ];

    public function handleWebcamCaptured($data_uri){
        $this->new_product['webcam_image'] = $data_uri;
    }

    public function handleWebcamReset(){
        $this->new_product['webcam_image'] = '';
    }

    public function setAdditionalAttribute($key,$name,$selectedText){
        $this->distribusi_toko_details[$key][$name] = $selectedText;
    }

    private function resetDistribusiToko()
    {
        $this->distribusi_toko = [
            'date' => '',
            'cabang_id' => ''
        ];
    }
    private function resetDistribusiTokoDetails()
    {
        $this->distribusi_toko_details = [
            [
                'product_category' => '',
                'group' => '',
                'model' => '',
                'gold_category' => '',
                'karat' => '',
                'accessoris_weight' => 0,
                'label_weight' => 0,
                'gold_weight' => 0,
                'total_weight' => 0,
                'code' => '',
                'file' => '',
                'certificate_id' => '',
                'no_certificate' => '',
                'webcam_image' => '',
                'product_category_name' => '',
                'group_name' => '',
                'model_name' => '',
            ]
        ];
    }

    public function render(){
        $data = Product::with('product_item')->whereIn('status_id',[ProductStatus::PENDING_OFFICE,ProductStatus::NEW]);
        if (!empty($this->exceptProductId)) {
            $data = $data->whereNotIn('id', $this->exceptProductId);
        }
        if (!empty($this->search)) {
            $search = $this->search;
            $data->where(function($query) use ($search) {
                $query->where('product_code','like', '%'. $search . '%');
                $query->orWhere('product_name','like', '%'. $search . '%');
            });
        }
        $data = $data->paginate(5);
        return view("livewire.distribusi-toko.emas.create",[
            'products' => $data
        ]);
    }

    private function resetInputFields()
    {
        $this->resetDistribusiToko();
        $this->resetDistribusiTokoDetails();
    }


    public function rules()
    {
        $rules = [
            'distribusi_toko.cabang_id' => 'required',
            'distribusi_toko.date' => 'required',
            'distribusi_toko.no_distribusi_toko' => 'required|string|max:70'
        ];
        return $rules;
    }

    public function updated($propertyName)
    {
        $this->resetErrorBag();
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->cabangs = Cabang::all();
        $kategori = KategoriProduk::where('slug','gold')->orWhere('slug','emas')->firstOrFail();
        $this->product_categories = Category::where('kategori_produk_id',$kategori->id)->get();
        $this->groups = Group::all();
        $this->models = ProdukModel::all();

        $this->dataKarat = Karat::where(function ($query) {
            $query
                ->where('parent_id', null)
                ->whereHas('stockOffice', function ($query) {
                    $query->where('berat_real', '>', 0);
                });
        })->get();
        $this->distribusi_toko['no_distribusi_toko'] = $this->generateInvoice();
        $this->distribusi_toko['date'] = (new DateTime())->format('Y-m-d');

        $this->logam_mulia_id = Category::where('category_name','LIKE','%logam mulia%')->firstOrFail()->id;
        $this->karat_logam_mulia = Karat::logam_mulia()->id;
    }

    private function generateInvoice(){
        $lastString = DistribusiToko::orderBy('id', 'desc')->value('no_invoice');

        $numericPart = (int) substr($lastString, 10);
        $incrementedNumericPart = $numericPart + 1;
        $nextNumericPart = str_pad($incrementedNumericPart, 5, "0", STR_PAD_LEFT);
        $nextString = "DIST-TOKO-" . $nextNumericPart;
        return $nextString;
    }

    public function store()
    {
        if(!count($this->distribusi_toko_details)){
            $this->dispatchBrowserEvent('not:selected');
        }else{
            $this->validate();
            $kategoriproduk_id = LookUp::where('kode', 'id_kategori_produk_emas')->value('value');
            DB::beginTransaction();
            try{
                $distribusi_toko = DistribusiToko::create([
                    'cabang_id'                   => $this->distribusi_toko['cabang_id'],
                    'date'                        => $this->distribusi_toko['date'],
                    'no_invoice'                  => $this->distribusi_toko['no_distribusi_toko'],
                    'kategori_produk_id'        => $kategoriproduk_id,
                    'pic_id'                  => auth()->id(),
                ]);
    
                foreach($this->distribusi_toko_details as $key => $value) {
                    $additional_data = [
                        "product_information" => [
                            "product_category" => [
                                "id" => $this->distribusi_toko_details[$key]['category_id'],
                                "name" => $this->product_categories->find($this->distribusi_toko_details[$key]['category_id'])->category_name
                            ],
                            "group" => [
                                'id' => $this->distribusi_toko_details[$key]['group_id'],
                                'name' => $this->groups->find($this->distribusi_toko_details[$key]['group_id'])->name
                            ],
                            "model" => [
                                'id' => $this->distribusi_toko_details[$key]['model_id'],
                                'name' => $this->models->find($this->distribusi_toko_details[$key]['model_id'])?->name
                            ],
                            "code" => $this->distribusi_toko_details[$key]['product_code'],
                            'certificate_id' => $this->distribusi_toko_details[$key]['product_item']['certificate_id'],
                            'no_certificate' => $this->distribusi_toko_details[$key]['product_item']['no_series'],
                            'accessories_weight' => $this->distribusi_toko_details[$key]['product_item']['berat_accessories'],
                            'tag_weight' => $this->distribusi_toko_details[$key]['product_item']['berat_label'],
                            'image' => $this->distribusi_toko_details[$key]['images'],
                            'total_weight' => $this->distribusi_toko_details[$key]['product_item']['berat_total']
                        ]
                    ];
                    $dist_item = $distribusi_toko->items()->create([
                        'karat_id' => $this->distribusi_toko_details[$key]['karat_id'],
                        'gold_weight' => $this->distribusi_toko_details[$key]['berat_emas'],
                        'product_id' => $this->distribusi_toko_details[$key]['id'],
                        'additional_data' => json_encode($additional_data),
                    ]);
                    $dist_item->product->updateTracking(ProductStatus::DRAFT);
                }
                
                $distribusi_toko->setAsDraft();
    
                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack(); 
                throw $e;
            }
    
            $this->resetInputFields();
            toast('Saved to Draft Successfully','success');
            return redirect(route('distribusitoko.detail', $distribusi_toko));
        }
    }

    public function messages(){
        return [];
    }

    public function selectProduct($product) {
        $this->exceptProductId[] = $product['id'];
        $this->distribusi_toko_details[] = $product;
    }

    public function remove($index)
    {
        $data = $this->distribusi_toko_details[$index];
        unset($this->distribusi_toko_details[$index]);
        $product_id = !empty($data['id']) ? $data['id'] : '';
        if (!empty($product_id)) {
            $key = array_search($product_id, $this->exceptProductId);
            if(!is_bool($key)){
                unset($this->exceptProductId[$key]);
            }
        }
    }

    public function submitBarcode()
    {
        if(!empty($this->kode_produk)){
            $data = Product::where('product_code',$this->kode_produk)->whereIn('status_id',[ProductStatus::PENDING_OFFICE,ProductStatus::NEW]);
            if (!empty($this->exceptProductId)) {
                $data = $data->whereNotIn('id', $this->exceptProductId);
            }
            $data = $data->first();
            if ($data) {
                $this->selectProduct($data);
                $this->kode_produk = '';
            }

        }

    }



    private function isLogamMulia(){
        $this->isLogamMulia = $this->new_product['product_category_id'] == $this->logam_mulia_id;
    }
    
    public function productCategoryChanged(){
        $this->clearKaratAndTotal();
        $this->isLogamMulia();
        if($this->new_product['product_category_id'] == $this->logam_mulia_id){
            $this->new_product['karat_id'] = $this->karat_logam_mulia;
        }
    }

    public function clearKaratAndTotal(){
        $this->new_product['karat_id'] = '';
        $this->new_product['accessories_weight'] = 0;
        $this->new_product['tag_weight'] = 0;
        $this->new_product['gold_weight'] = 0;
        $this->new_product['total_weight'] = 0;
        $this->new_product['certificate_id'] = '';
        $this->new_product['no_certificate'] = '';
    }

    public function generateCode(){
        if(!empty($this->new_product['group_id'])){
            $namagroup = Group::where('id', $this->new_product['group_id'])->first()->code;
            $existingCode = true;
            $codeNumber = '';
            $cabang = 'JSR';
            while ($existingCode) {
                $date = now()->format('dmY');
                $randomNumber = mt_rand(100, 999);
                $codeNumber = $cabang .'-'. $namagroup .'-'. $randomNumber .'-'. $date;
                $existingCode = Product::where('product_code', $codeNumber)->exists();
            }
            $this->new_product["code"] = $codeNumber;
        }else{
            $this->dispatchBrowserEvent('group:not-selected');
        }
    }

    public function calculateTotalWeight(){
        $this->new_product['total_weight'] = 0;
        $this->new_product['total_weight'] += doubleval($this->new_product['gold_weight']);
        $this->new_product['total_weight'] += doubleval($this->new_product['accessories_weight']);
        $this->new_product['total_weight'] += doubleval($this->new_product['tag_weight']);
        $this->new_product['total_weight'] = round($this->new_product['total_weight'], 3);
    }

    private function product_rules(){
        return [
            'new_product.product_category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if($value == $this->logam_mulia_id){
                        $stock = StockOffice::where('karat_id',$this->karat_logam_mulia)->first();
                        if(is_null($stock) or $stock->berat_real <= 0){
                            $fail('Stok tidak tersedia');
                        }
                    }
                }
            ],
            'new_product.group_id' => 'required',
            'new_product.code' => 'required|max:255|unique:products,product_code',
            'new_product.karat_id' => 'required',
            'new_product.accessories_weight' => 'required_unless:new_product.product_category_id,'.$this->logam_mulia_id,
            'new_product.tag_weight' => 'required_unless:new_product.product_category_id,'.$this->logam_mulia_id,
            'new_product.gold_weight' => [
                'required',
                'gt:0',
                function ($attribute, $value, $fail) {
                    $maxWeight = DB::table('stock_office')
                        ->where('karat_id', $this->new_product['karat_id'])
                        ->max('berat_real');
                    if ($value > $maxWeight) {
                        $fail("Berat melebihi stok yang tersedia. Sisa Stok ($maxWeight gr)");
                    }
                },
            ],
            'new_product.total_weight' => 'required|gt:0',
            'new_product.certificate_id' => 'required_if:new_product.product_category_id,'.$this->logam_mulia_id,
            'new_product.no_certificate' => 'required_if:new_product.product_category_id,'.$this->logam_mulia_id,
            'new_product.webcam_image' => 'required',
        ];
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

    public function add_new_product(){
        $this->validate($this->product_rules());


        DB::beginTransaction();
        try{
            // Create product first
            $product_data = [
                'category_id' => $this->new_product['product_category_id'],
                'product_stock_alert'        => 5,
                'group_id' => $this->new_product['group_id'],
                'model_id' => empty($this->new_product['model_id'])?null:$this->new_product['model_id'],
                'karat_id' => $this->new_product['karat_id'],
                'berat_emas' => $this->new_product['gold_weight'],
                'status_id' => ProductStatus::NEW,
                'product_code'               => $this->new_product['code'],
                'product_barcode_symbology'  => 'C128',
                'product_unit'               => 'Gram',
                'images' => $this->uploadImage($this->new_product['webcam_image']),
            ];
            $product = Product::create($product_data);

            $product_item = $product->product_item()->create([
                'certificate_id'              => empty($this->new_product['certificate_id'])?null:$this->new_product['certificate_id'],
                'berat_label'                 => $this->new_product['tag_weight'],
                'berat_accessories'           => $this->new_product['accessories_weight'],
                'berat_total'                 => $this->new_product['total_weight'],
            ]);
            $product->statuses()->attach($product->status_id,['cabang_id' => $product->cabang_id, 'properties' => json_encode([
                'product' => $product,
                'product_additional_information' =>  $product_item
            ])]);

            $this->reset('new_product');
            $this->dispatchBrowserEvent('create-modal:close');

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }


    }
}
