<?php

namespace App\Http\Livewire\Rfid;

use Livewire\Component;
use Illuminate\Support\Collection;
use Modules\Product\Entities\Product;


class Create extends Component
{

    public $query;
    public $search;
    public $type;
    public $search_results;
    public $list_product;
    public $how_many;
    protected $listeners = ['produkTemp'];
    protected $queryString = ['search'];

    public function produkTemp()
    {
          $this->refreshData();
    }
    public function mount() {
        $this->search = '';
        $this->query = '';
        $this->type = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
        $this->list_product = Product::temp()->take($this->how_many)->get();
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->list_product = Product::temp()->take($this->how_many)->latest()->get();
    }

    public function render() {
        $this->refreshData();
        return view('livewire.rfid.create');
    }

    public function updatedQuery() {
        $this->search_results = Product::where('product_code',$this->query)->first();

    }

    public function loadMore() {
        $this->how_many += 5;
        $this->updatedQuery();
    }

    public function resetQuery() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function resetForm() {
        $this->search = '';
        $this->search_results = Collection::empty();
    }

    public function clickQuery() {
        //dd($this->search);
        $product = Product::where('product_code',$this->search)->first();
         $this->emit('productSelected', $product);
         $this->resetForm();


    }

    public function selectProduct($product) {
        $this->emit('productSelected', $product);
         $this->resetQuery();
    }


    public function hapusItem($itemId)
    {
        $item = Product::find($itemId);
        if ($item) {
             $item->delete();
             $this->refreshData();
            // $this->emit('resetInput');
             $this->resetQuery();
        }
    }





}
