<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use Modules\ProdukModel\Models\ProdukModel;

class PilihKategori extends Component
{

    public $categories;
    public $category;
    public $showCount;
    public $produkModel;


    public function mount() {
        $this->how_many = 10;
        $this->produkModel = ProdukModel::take($this->how_many)->get();

    }

    public function render() {
        return view('livewire.product.pilih-kategori');
    }

    public function updatedCategory() {
        //dd('dsdsds');
        $this->emitUp('selectedCategory', $this->category);

    }

    public function updatedShowCount() {
        $this->emitUp('showCount', $this->category);
    }
}
