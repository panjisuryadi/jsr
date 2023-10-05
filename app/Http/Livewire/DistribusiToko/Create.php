<?php

namespace App\Http\Livewire\DistribusiToko;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Karat\Models\Karat;
use Modules\Product\Entities\Category;

class Create extends Component
{

    public $categories;
    public $product_category;

    public $cabang;

    public $kategori;

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
            'accessoris_weight' => '',
            'label_weight' => '',
            'gold_weight' => '',
            'total_weight' => '',
            'code' => '',
            'file' => '',
            'certificate_id' => '',
            'no_certificate' => ''
        ]
    ];


    public function add()
    {
        $this->distribusi_toko_details[] = [
            'product_category' => '',
            'group' => '',
            'model' => '',
            'gold_category' => '',
            'karat' => '',
            'accessoris_weight' => '',
            'label_weight' => '',
            'gold_weight' => '',
            'total_weight' => '',
            'code' => '',
            'file' => '',
            'certificate_id' => '',
            'no_certificate' => ''
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
                'accessoris_weight' => '',
                'label_weight' => '',
                'gold_weight' => '',
                'total_weight' => '',
                'code' => '',
                'file' => '',
                'certificate_id' => '',
                'no_certificate' => ''
            ]
        ];
    }

    public function render(){
        return view('livewire.distribusi-toko.create');
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
            $rules['distribusi_toko_details.'.$key.'.code'] = 'required';
            $rules['distribusi_toko_details.'.$key.'.gold_category'] = 'required_unless:distribusi_toko_details.'.$key.'.product_category,4';
            $rules['distribusi_toko_details.'.$key.'.karat'] = 'required_unless:distribusi_toko_details.'.$key.'.product_category,4';
            $rules['distribusi_toko_details.'.$key.'.accessoris_weight'] = 'required';
            $rules['distribusi_toko_details.'.$key.'.label_weight'] = 'required';
            $rules['distribusi_toko_details.'.$key.'.gold_weight'] = 'required';
            $rules['distribusi_toko_details.'.$key.'.total_weight'] = 'required';
            $rules['distribusi_toko_details.'.$key.'.certificate_id'] = 'required_if:distribusi_toko_details.'.$key.'.product_category,4';
            $rules['distribusi_toko_details.'.$key.'.no_certificate'] = 'required_if:distribusi_toko_details.'.$key.'.product_category,4';
            $rules['distribusi_toko_details.'.$key.'.model'] = [
                'required',
                'gt:0',
            ];

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
    }

    public function store()
    {
        $this->validate();
        // create distribusi sales
        DB::beginTransaction();
        try{
            
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->resetInputFields();
        // $this->resetTotal();
        toast('Created Successfully','success');
        return redirect(route('distribusitoko.index'));
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
        $this->distribusi_toko_details[$key]['accessoris_weight'] = '';
        $this->distribusi_toko_details[$key]['label_weight'] = '';
        $this->distribusi_toko_details[$key]['gold_weight'] = '';
        $this->distribusi_toko_details[$key]['total_weight'] = '';
    }
}
