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
    public $berat_total = 0;
    public $harga_emas = 0;
    public $totalPrice = 0;
    public $totalRupiah = 0;

    protected $listeners = ['optionSelected' => 'handleOptionSelected'];


     public function calculateHargaEmas()
    {
       // dd('dsdss');
        $total = $this->berat_total * $this->harga_emas;
        $this->totalRupiah = 'Rp ' . number_format($total, 0, ',', '.');
    }

   public function mount() {
        $this->berat_total = 0;
      
       
    }


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
    


       public function updatedBeratTotal() {
         $this->berat_total +1;
            }




}
