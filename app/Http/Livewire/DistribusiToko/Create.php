<?php

namespace App\Http\Livewire\DistribusiToko;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;

use function PHPUnit\Framework\isEmpty;

class Create extends Component
{

    public $categories;
    public $product_category;

    public $cabang;

    public $kategori;

    public $logam_mulia_id;

    public $distribusi_toko = [
        'no_distribusi_toko' =>'',
        'date' => '',
        'cabang_id' => ''
    ];

    public $dataKarat = [];

    public $distribusi_toko_details = [
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

    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
        'setAdditionalAttribute'
    ];

    public function handleWebcamCaptured($key,$data_uri){
        $this->distribusi_toko_details[$key]['webcam_image'] = $data_uri;
    }

    public function handleWebcamReset($key){
        $this->distribusi_toko_details[$key]['webcam_image'] = '';
    }

    public function setAdditionalAttribute($key,$name,$selectedText){
        $this->distribusi_toko_details[$key][$name] = $selectedText;
    }



    public function add()
    {
        $this->validate();
        $this->distribusi_toko_details[] = [
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
        ];
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
        return view("livewire.distribusi-toko.create");
    }

    public function remove($key)
    {
        $this->resetErrorBag();
        unset($this->distribusi_toko_details[$key]);
        $this->distribusi_toko_details = array_values($this->distribusi_toko_details);
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

        foreach ($this->distribusi_toko_details as $key => $value) {

            $rules['distribusi_toko_details.'.$key.'.product_category'] = 'required';
            $rules['distribusi_toko_details.'.$key.'.group'] = 'required';
            $rules['distribusi_toko_details.'.$key.'.code'] = 'required|max:255|unique:products,product_code';
            // $rules['distribusi_toko_details.'.$key.'.gold_category'] = 'required_unless:distribusi_toko_details.'.$key.'.product_category,4';
            $rules['distribusi_toko_details.'.$key.'.karat'] = 'required_unless:distribusi_toko_details.'.$key.'.product_category,' . $this->logam_mulia_id;
            $rules['distribusi_toko_details.'.$key.'.accessoris_weight'] = 'required_unless:distribusi_toko_details.'.$key.'.product_category,'.$this->logam_mulia_id;
            $rules['distribusi_toko_details.'.$key.'.label_weight'] = 'required_unless:distribusi_toko_details.'.$key.'.product_category,'.$this->logam_mulia_id;
            $rules['distribusi_toko_details.'.$key.'.gold_weight'] = 'required|gt:0';
            $rules['distribusi_toko_details.'.$key.'.total_weight'] = 'required|gt:0';
            $rules['distribusi_toko_details.'.$key.'.certificate_id'] = 'required_if:distribusi_toko_details.'.$key.'.product_category,'.$this->logam_mulia_id;
            $rules['distribusi_toko_details.'.$key.'.no_certificate'] = 'required_if:distribusi_toko_details.'.$key.'.product_category,'.$this->logam_mulia_id;
            $rules['distribusi_toko_details.'.$key.'.webcam_image'] = 'required';

        }
        return $rules;
    }

    public function updated($propertyName)
    {
        $this->resetErrorBag();
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
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
        $this->validate();
        
        DB::beginTransaction();
        try{
            $distribusi_toko = DistribusiToko::create([
                'cabang_id'                   => $this->distribusi_toko['cabang_id'],
                'date'                        => $this->distribusi_toko['date'],
                'no_invoice'                  => $this->distribusi_toko['no_distribusi_toko'],
                'created_by'                  => auth()->user()->name,
                'is_draft'                    => true
            ]);

            foreach($this->distribusi_toko_details as $key => $value) {
                $additional_data = [
                    "product_information" => [
                        "product_category" => [
                            "id" => $this->distribusi_toko_details[$key]['product_category'],
                            "name" => $this->distribusi_toko_details[$key]['product_category_name']
                        ],
                        "group" => [
                            'id' => $this->distribusi_toko_details[$key]['group'],
                            'name' => $this->distribusi_toko_details[$key]['group_name']
                        ],
                        "model" => [
                            'id' => $this->distribusi_toko_details[$key]["model"],
                            'name' => $this->distribusi_toko_details[$key]["model_name"]
                        ],
                        "code" => $this->distribusi_toko_details[$key]["code"],
                        'certificate_id' => $this->distribusi_toko_details[$key]['certificate_id'],
                        'no_certificate' => $this->distribusi_toko_details[$key]['no_certificate'],
                        'accessories_weight' => $this->distribusi_toko_details[$key]['accessoris_weight']??null,
                        'tag_weight' => $this->distribusi_toko_details[$key]['label_weight']??null,
                    ]
                ];
                $detail = $distribusi_toko->items()->create([
                    'karat_id' => empty($this->distribusi_toko_details[$key]['karat'])?Karat::logam_mulia()->id:$this->distribusi_toko_details[$key]['karat'],
                    'gold_weight' => $this->distribusi_toko_details[$key]['gold_weight'],
                    'additional_data' => json_encode($additional_data),
                ]);
                $this->uploadImage($detail, $this->distribusi_toko_details[$key]['webcam_image']);
            }


            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->resetInputFields();
        // $this->resetTotal();
        toast('Saved to Draft Successfully','success');
        return redirect(route('distribusitoko.detail', $distribusi_toko));
    }

    private function uploadImage($detail,$img){
        $folderPath = "uploads/";
        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName ='webcam_'. uniqid() . '.jpg';
        $file = $folderPath . $fileName;
        Storage::disk('local')->put($file,$image_base64);
        $detail->addMedia(Storage::path('uploads/' . $fileName))->toMediaCollection('distribusi_toko');
    }

    public function messages(){
        return [
            'distribusi_toko.*.required' => 'Wajib diisi',
            'distribusi_toko_details.*.*.required' => 'Wajib di isi',
            'distribusi_toko_details.*.*.required_if' => 'Wajib di isi',
            'distribusi_toko_details.*.*.required_unless' => 'Wajib di isi',
        ];
    }

    public function clearKaratAndTotal($key){
        $this->distribusi_toko_details[$key]['karat'] = '';
        $this->distribusi_toko_details[$key]['accessoris_weight'] = 0;
        $this->distribusi_toko_details[$key]['label_weight'] = 0;
        $this->distribusi_toko_details[$key]['gold_weight'] = 0;
        $this->distribusi_toko_details[$key]['total_weight'] = 0;
        $this->distribusi_toko_details[$key]['certificate_id'] = '';
        $this->distribusi_toko_details[$key]['no_certificate'] = '';
    }


    public function calculateTotalWeight($key){
        $this->distribusi_toko_details[$key]['total_weight'] = 0;
        $this->distribusi_toko_details[$key]['total_weight'] += doubleval($this->distribusi_toko_details[$key]['gold_weight']);
        $this->distribusi_toko_details[$key]['total_weight'] = round($this->distribusi_toko_details[$key]['total_weight'], 3);
        if($this->distribusi_toko_details[$key]['product_category'] != '4'){
            $this->distribusi_toko_details[$key]['total_weight'] += doubleval($this->distribusi_toko_details[$key]['accessoris_weight']);
            $this->distribusi_toko_details[$key]['total_weight'] += doubleval($this->distribusi_toko_details[$key]['label_weight']);
            $this->distribusi_toko_details[$key]['total_weight'] = round($this->distribusi_toko_details[$key]['total_weight'], 3);
        }
    }

    public function generateCode($key){
        $this->checkGroup($key);
        $namagroup = Group::where('id', $this->distribusi_toko_details[$key]['group'])->first()->code;
        $existingCode = true;
        $codeNumber = '';
        $cabang = 'CBR';
        while ($existingCode) {
               $date = now()->format('dmY');
               $randomNumber = mt_rand(100, 999);
               $codeNumber = $cabang .'-'. $namagroup .'-'. $randomNumber .'-'. $date;
               $existingCode = Product::where('product_code', $codeNumber)->exists();
        }
        $this->distribusi_toko_details[$key]['code'] = $codeNumber;
    }

    private function checkGroup($key){
        $this->validateOnly('distribusi_toko_details.'.$key.'.group');
    }
}
