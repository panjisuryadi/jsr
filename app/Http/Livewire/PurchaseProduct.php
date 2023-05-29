<?php

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Product\Entities\Product;

class PurchaseProduct extends Component
{


    public $query;
    public $search_results;
    public $list_product;
    public $how_many;
    protected $listeners = ['produkTemp'];


    public function produkTemp()
    {
          $this->refreshData();
    }
    public function mount() {
        $this->query = '';
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
        return view('livewire.pembelian');
    }

    public function updatedQuery() {
        $this->search_results = Product::where('product_name', 'like', '%' . $this->query . '%')
            ->orWhere('product_code', 'like', '%' . $this->query . '%')
            ->take($this->how_many)->get();
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

    public function selectProduct($product) {
        $this->emit('productSelected', $product);
    }



    public function hapusItem($itemId)
    {
        $item = Product::find($itemId);
        if ($item) {
             $item->delete();
             $this->refreshData();
             $this->emit('resetInput');
        }
    }









}
