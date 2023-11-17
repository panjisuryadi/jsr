<?php

namespace App\Http\Livewire\Karat;


use Livewire\Component;
use App\Models\User;
use Modules\Karat\Models\Karat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Karat\Http\Controllers\KaratsController;

class Create extends Component
{
    public $dataKarat = [];

    public $parent_karat_id = '';

    public $name = '';

    public $model = '';

    public $kode = '';

    public $type = '';
    public $coef = '';
    public $isParentSelected = false;

    public function mount(){
        $this->dataKarat = Karat::where(function ($query) {
            $query->where('parent_id', null);
        })->get();
    }

    
    public function render(){
        return view('livewire.karat.create');
    }
    public function parentSelected(){
        if($this->parent_karat_id != ''){
            $karat = Karat::find($this->parent_karat_id);
            $this->kode = $karat->kode;
            $this->type = $karat->type;
            $this->isParentSelected = true;
            $this->name = '';
        }else{
            $this->isParentSelected = false;
            $this->kode = '';
            $this->type = '';
            $this->model = '';
        }
        $this->dispatchBrowserEvent('parentChange', ['isParentSelected' => $this->isParentSelected]);
    }

    public function rules()
    {
        $rules = [
            'kode' => 'required',
            'type' => 'required',
            'model' => [
                Rule::requiredIf(function () {
                    return $this->parent_karat_id !== '';
                }),
                function ($attribute, $value, $fail) {
                    if($this->parent_karat_id != ''){
                        $exist = Karat::where('parent_id',$this->parent_karat_id)->where(DB::raw('lower(name)'), strtolower($value))->exists();
                        if ($exist) {
                            $fail('Model sudah ada untuk karat yang sama');
                        }
                    }else{
                        $exist = Karat::where(DB::raw('lower(name)'), strtolower($value))->exists();
                        if ($exist) {
                            $fail('Nama Karat sudah digunakan');
                        }
                    }
                },
            ],
            'name' => [
                "requiredIf:parent_karat_id,",
                function ($attribute, $value, $fail) {
                    $exist = Karat::where(DB::raw('lower(name)'), strtolower($value))->exists();
                    if ($exist) {
                        $fail('Nama Karat sudah digunakan');
                    }
                },
            ]
        ];
        return $rules;
    }

    public function store(){
        $this->validate();

        $data = [
            'parent_id' => $this->parent_karat_id?$this->parent_karat_id:null,
            'name' => $this->parent_karat_id?$this->model:$this->name,
            'type' => $this->type,
            'kode' => $this->kode,
            'coef' => $this->coef,
        ];


        $request = new Request($data);

        $controller = new KaratsController();

        $controller->store($request);

        session()->flash('message', 'Created Successfully.');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
