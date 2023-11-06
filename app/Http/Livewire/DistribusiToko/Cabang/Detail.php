<?php

namespace App\Http\Livewire\DistribusiToko\Cabang;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Product;

class Detail extends Component
{
    public $dist_toko;

    public $dist_toko_items;

    public $selectedItems = [];

    public $selectAll = false;

    public $note = '';

    protected $listeners = [
        'selectAllItem' => 'handleSelectAllItem',
        'isSelectAll' => 'handleIsSelectAll'
    ];

    public function handleSelectAllItem($selectedItems){
        $this->selectedItems = $selectedItems;
    }

    public function handleIsSelectAll($value){
        $this->selectAll = $value;
    }

    public function updatedSelectedItems(){
        if(count($this->selectedItems) == count($this->dist_toko_items)){
            $this->selectAll = true;
        }else{
            $this->selectAll = false;
        }
    }


    public function render()
    {
        return view("livewire.distribusi-toko.cabang.detail");
    }

    public function mount()
    {
        $this->dist_toko_items = $this->dist_toko->items;
    }

    public function rules()
    {
        $rules = [
            'note' => 'required_if:selectAll,false'
        ];
        return $rules;
    }

    public function messages(){
        return [
            'note.required_if' => 'Wajib di isi',
        ];
    }

    public function proses()
    {
        $this->dispatchBrowserEvent('summary:modal');
    }

    public function showTracking(){
        $this->dispatchBrowserEvent('tracking:modal');
    }

    public function confirm(){
        $this->validate();
        if($this->selectAll){
            DB::beginTransaction();
            try{
                $this->dist_toko->setAsCompleted();
                $this->createProducts($this->selectedItems);
                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack(); 
                throw $e;
            }
        }else{
            DB::beginTransaction();
            try{
                $this->dist_toko->setAsReturned($this->note);
                $this->createProducts($this->selectedItems);
                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack(); 
                throw $e;
            }
        }
        toast('Penerimaan Distribusi Berhasil dilakukan','success');
        return redirect(route('home'));
    }

    private function createProducts($selected_items){
        foreach($this->dist_toko_items as $item){
            if(in_array($item->id, $selected_items)){
                $item->approved();
                $additional_data = json_decode($item['additional_data'],true)['product_information'];
                $product = $item->product()->create([
                    'category_id'                => $additional_data['product_category']['id'],
                      'cabang_id'                  => $this->dist_toko->cabang_id,
                      'product_stock_alert'        => 5,
                        'product_name'              => $additional_data['group']['name'] .' '. $additional_data['model']['name'] ?? 'unknown',
                      'product_code'               => $additional_data['code'],
                      'product_barcode_symbology'  => 'C128',
                      'product_unit'               => 'Gram',
                      'product_cost' => 0,
                      'product_price' => 0,
                      'images' => $additional_data['image']
                ]);
    
                $product->product_item()->create([
                    'karat_id'                    => $item->karat_id,
                    'certificate_id'              => empty($additional_data['certificate_id'])?null:$additional_data['certificate_id'],
                    'berat_emas'                  => $item->gold_weight,
                    'berat_label'                 => $additional_data['tag_weight'],
                    'berat_accessories'           => $additional_data['accessories_weight'],
                    'produk_model_id'             => $additional_data['model']['id'],
                    'berat_total'                 => $additional_data['total_weight'],
                    'product_cost'                => 0,
                    'product_price'               => 0
                ]);
            }else{
                $item->returned();
            }
        }
    }
}
