<?php

namespace App\Http\Livewire\Pos;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'selectedCategory' => 'categoryChanged',
        'showCount'        => 'showCountChanged'
    ];


    public $products;
    public $categories;
    public $category_id;

    public $limit = 5;
    public $perPage = 10;

    public function mount($categories) {
        $this->categories = $categories;
        $this->category_id = '';
        $this->products = Product::akses()->latest()->with('karat.penentuanHarga')
            ->when($this->category_id, function ($query) {
                return $query->where('category_id', $this->category_id);
            })->where('status_id', ProductStatus::READY)
            ->take($this->perPage)->get();
    }

    public function render() {
             $products = Product::akses()->with('karat.penentuanHarga')
            ->when($this->category_id, function ($query) {
                return $query->where('category_id', $this->category_id);
            })->where('status_id', ProductStatus::READY)
            ->take($this->perPage)->get();



        return view('livewire.pos.product-list', [

            'products' => $products
        ]);
    }


    public function loadMore()
    {
        $this->perPage += 5;
       // $newPosts = Post::latest()->skip($this->perPage)->take(5)->get();

         $products = Product::akses()->latest()->with('karat.penentuanHarga')
            ->when($this->category_id, function ($query) {
                return $query->where('category_id', $this->category_id);
            })->where('status_id', ProductStatus::READY)
            ->skip($this->perPage)->take(5)->get();

        $this->products = $this->products->concat($products);
    }

    public function categoryChanged($category_id) {
        $this->category_id = $category_id;
        $this->resetPage();
    }

    public function showCountChanged($value) {
        $this->limit = $value;
        $this->resetPage();
    }

    public function selectProduct($product) {
       // dd($product);
        $this->emit('productSelected', $product);
    }
}
