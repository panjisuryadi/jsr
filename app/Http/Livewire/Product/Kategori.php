<?php

namespace App\Http\Livewire\Product;
//use Modules\Product\Entities\Category;
use Livewire\Component;
use Modules\ProdukModel\Models\ProdukModel;
use Modules\Product\Entities\Category;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Product\Entities\Product;
class Kategori extends Component
{

 
    public $selectedOption = '';

    protected $listeners = ['optionSelected' => 'handleOptionSelected'];




    public function handleOptionSelected($value)
    {

        if ($value) {
           $cat = Category::where('id', $value)->first();
           $slug = $cat->slug;
           $this->selectedOption = $slug;
        } else {
            $this->selectedOption = '0';
        }
        
        
       
    }




    public function render()
    {
        return view('livewire.product.kategori');
    }





}
