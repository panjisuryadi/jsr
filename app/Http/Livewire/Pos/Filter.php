<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;

class Filter extends Component
{
    public $categories;
    public $category;
    public $showCount;
    public $scan_product;

    public function mount($categories) {
        $this->categories = $categories;
    }

    public function render() {
        return view('livewire.pos.filter');
    }

    public function updatedCategory() {
        $this->emitUp('selectedCategory', $this->category);
    }

    public function updatedShowCount() {
        $this->emitUp('showCount', $this->showCount);
    }

    public function updatedScanProduct() {
        $this->emitUp('productScanned', $this->scan_product);
    }
}
