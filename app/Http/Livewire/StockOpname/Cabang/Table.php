<?php

namespace App\Http\Livewire\StockOpname\Cabang;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\ProductLocation;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\Locations\Entities\Locations;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;

class Table extends Component
{
    use WithPagination;

     protected $paginationTheme = 'bootstrap';
     public $orderColumn = "karat_id";
     public $sortOrder = "asc";
     public $sortLink = '<i class="sorticon fa fa-caret-up"></i>';

     public $destination = 0;
     public $searchTerm = "";
     public $mainlokasi = "";
     public $sub_location = 0;
     public $pilih = "";
     public $cabang_id;

     public $active_location;


     public function updated(){
          $this->resetPage();
     }


    public function mount(){
        if(auth()->user()->isUserCabang()) {
            $this->cabang_id = auth()->user()->namacabang()->id;
        }
        $setting = AdjustmentSetting::first();
        $ids = Product::all()->pluck('id')->toArray();
    }


     public function render(){
        // dd($this->cabang_id);
        $data = Product::where('status_id', ProductStatus::READY)->where('cabang_id', $this->cabang_id);
        $data = $data->paginate(5);
        $this->emit('userStore');
        return view('livewire.stock-opname.cabang.table', [
            'products' => $data,
        ]);

     }

        public function showCountChanged($value) {
            // $this->limit = $value;
            $this->resetPage();
        }

        public function selectProduct($key) {
            // $this->emit('showModal', ['modalId' => $key]);

            $data = [
                'id' => $this->data->id,
                'product_name'=>$this->data->karat->name . ' | ' . $this->data->karat->kode,
                'current_stock' => $this->data->berat_real,
                'new_stock'=>$this->stock_rill
            ];
            $this->emit('save', $data);
        }

         public function getDestination($value) {
            $this->emit('destinationSelected', $value);

        } public function hapus($value) {
           $this->pilih = '';

        }

}
