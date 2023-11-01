<?php

namespace App\Http\Livewire\DistribusiToko\Modal;

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

use function PHPUnit\Framework\isEmpty;

class Create extends Component
{
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

    public $dataLabel;

    public $categories;

    public $dataKarat;

    protected $listeners = [
        'setAdditionalAttribute',
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
    ];
    public function render(){
        return view("livewire.distribusi-toko.modal.create");
    }

    public function handleWebcamCaptured($data_uri){
        $this->data['additional_data']['image'] = $data_uri;
    }

    public function handleWebcamReset(){
        $this->data['additional_data']['image'] = '';
    }

    


    public function mount(){
        $kategori = KategoriProduk::where('slug','gold')->orWhere('slug','emas')->firstOrFail();
        $this->categories = Category::where('kategori_produk_id',$kategori->id)->get();
        $this->dataKarat = Karat::where(function ($query) {
            $query
                ->where('parent_id', null)
                ->whereHas('stockOffice', function ($query) {
                    $query->where('berat_real', '>', 0);
                });
        })->get();
        
        $this->logam_mulia_id = Category::where('category_name','LIKE','%logam mulia%')->value('id');
    }

    public function setAdditionalAttribute($name,$selectedText){
        $this->data['additional_data'][$name]['name'] = $selectedText;
    }

    public function productCategoryChanged(){
        $this->clearKaratAndTotal();
        $this->isLogamMulia();
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
        $cabang = 'CBR';
        while ($existingCode) {
               $date = now()->format('dmY');
               $randomNumber = mt_rand(100, 999);
               $codeNumber = $cabang .'-'. $namagroup .'-'. $randomNumber .'-'. $date;
               $existingCode = Product::where('product_code', $codeNumber)->exists();
        }
        $this->data["additional_data"]["code"] = $codeNumber;
    }

    private function checkGroup(){
        $this->validateOnly($this->data["additional_data"]["group"]["id"]);
    }


    public function rules()
    {
        $rules = [
            // 'distribusi_toko.cabang_id' => 'required',
            // 'distribusi_toko.date' => 'required',
            // 'distribusi_toko.no_distribusi_toko' => 'required|string|max:70'
        ];


        $rules['data.additional_data.product_category.id'] = 'required';
        $rules['data.additional_data.group.id'] = 'required';
        $rules['data.additional_data.code'] = 'required|max:255|unique:products,product_code';
        // $rules['distribusi_toko_details.'.$key.'.gold_category'] = 'required_unless:distribusi_toko_details.'.$key.'.product_category,4';
        $rules['data.karat_id'] = 'required_unless:data.additional_data.product_category.id,' . $this->logam_mulia_id;
        $rules['data.additional_data.accessories_weight'] = 'required_unless:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.additional_data.tag_weight'] = 'required_unless:data.additional_data.product_category.id,'.$this->logam_mulia_id;
        $rules['data.gold_weight'] = 'required|gt:0';
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
                    'image' => $this->data['additional_data']['image'],
                    'total_weight' => $this->data['total_weight']
                ]
            ];
            
            $this->dist_toko->items()->create([
                'karat_id' => empty($this->data['karat_id'])?Karat::logam_mulia()->id:$this->data['karat_id'],
                'gold_weight' => $this->data['gold_weight'],
                'additional_data' => json_encode($additional_data),
            ]);

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->emit('reload-page-create');
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
}
