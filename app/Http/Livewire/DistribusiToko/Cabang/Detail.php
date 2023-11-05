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
        $rules = [];


        return $rules;
    }

    public function proses()
    {
        if (count($this->selectedItems) == 0) {
            $this->dispatchBrowserEvent('items:not-selected', [
                'message' => 'Barang belum dipilih'
            ]);
        } else {
            $this->dispatchBrowserEvent('summary:modal');
        }
    }

    public function showTracking(){
        $this->dispatchBrowserEvent('tracking:modal');
    }

    public function confirm(){
        if($this->selectAll){
            DB::beginTransaction();
            try{
                $this->dist_toko->setAsCompleted();
                $this->createProducts();
                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack(); 
                throw $e;
            }
        }
    }

    private function createProducts(){
        foreach($this->dist_toko_items as $item){
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
                  'product_price' => 0
            ]);
        }
    }
}
