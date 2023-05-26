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

    public function mount() {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
        $this->list_product = Product::take($this->how_many)->get();
    }

    public function render() {
        return view('livewire.purchase-product');
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














}
