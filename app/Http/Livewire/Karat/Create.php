<?php

namespace App\Http\Livewire\Karat;


use Livewire\Component;
use App\Models\User;
use Modules\Karat\Models\Karat;
use Illuminate\Http\Request;
use Modules\Karat\Http\Controllers\KaratsController;

class Create extends Component
{
    public $dataKarat = [];

    public $parent_karat_id = '';

    public $kategori_karat = '';

    public $kode = '';
    public $kadar = '';

    public $isParentSelected = false;

    public function mount(){
        $this->dataKarat = Karat::where(function ($query) {
            $query->where('parent_id', null);
        })->get();
    }

    
    public function render(){
        return view('livewire.karat.create');
    }
    public function setCode(){
        if($this->parent_karat_id != ''){
            $this->kode = Karat::find($this->parent_karat_id)->kode;
            $this->isParentSelected = true;
        }else{
            $this->isParentSelected = false;
            $this->kode = '';
        }
        $this->dispatchBrowserEvent('parentChange', ['isParentSelected' => $this->isParentSelected]);
    }

    public function rules()
    {
        $rules = [
            'kode' => 'required',
            'kadar' => 'required',
            'type' => 'required',
            'kategori_karat' => 'requiredIf:isParentSelected,true'
        ];
        return $rules;
    }

    public function store(){
        $this->validate();

        $data = [
            'parent_id' => $this->parent_karat_id?$this->parent_karat_id:null,
            'name' => $this->kadar,
            'type' => $this->type,
            'kode' => $this->isParentSelected?$this->kategori_karat:$this->kode,
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
