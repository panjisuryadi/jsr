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
    public $margin;
    public $harga_emas = 0;
    public $totalPrice = 0;
    public $totalRupiah = 0;
    public $total_amount = 0;
   

    public $hargaEmas = 0;
    public $formattedHargaEmas = 0;
    public $inputHargaEmas = 0;
    public $inputBeratTotal = 0.00;
    public $discount = 0;
    public $price = 0;
    public $hargaEmasBeratTotal = 0;
    public $productCost = 0;

    protected $listeners = ['optionSelected' => 'handleOptionSelected'];




    public function updatedinputHargaEmas()
    {
        $this->calculatePrice();
    }



    public function updatedinputBeratTotal()
    {
        $this->calculatePrice();
    }



    public function updatedDiscount()
    {
        $this->calculatePrice();
       
    }



   public function updatedhargaEmas()
    {
    
       $this->konversihargaEmas();
    }



    public function konversihargaEmas()
    {
    
        $this->formattedHargaEmas = 'Rp ' . number_format($this->hargaEmas, 0, ',', '.');
    }




    private function calculatePrice()
    {
        // Perform the price calculation based on input values and discount
        //$totalValue = $this->inputHargaEmas + $this->inputBeratTotal;

       //input harga emas di x berat total
        $totalValue = $this->inputHargaEmas * $this->inputBeratTotal;
        ////
        $discountAmount = $totalValue * ($this->discount / 100);
        $this->price = $totalValue - $discountAmount;

        $this->hargaEmasBeratTotal = $totalValue;
        $this->productCost = 'Rp ' . number_format($this->hargaEmasBeratTotal, 0, ',', '.');
             

    }


    public function hydrate() {
        $this->total_amount = $this->hitungMargin();
        
    }

    public function calculateHargaEmas()
    {
       // dd('dsdss');
        $total = $this->berat_total * $this->harga_emas;
        $this->totalRupiah = 'Rp ' . number_format($total, 0, ',', '.');
    }


     public function hitungMargin() {
       // return $harga + $this->margin;
    }

   public function mount() {
       
        $this->hargaEmas = 0;
        $this->berat_total = 0;
        $this->margin = 0.00;
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
