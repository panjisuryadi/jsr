<?php

namespace App\Http\Livewire\DistribusiToko;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Summary extends Component
{
    public $dist_toko;

    public $total_weight_per_karat = [];

    public function render(){
        return view("livewire.distribusi-toko.summary");
    }

    public function mount(){
        foreach($this->dist_toko->items->groupBy('karat_id') as $karat_id => $items){
            $this->total_weight_per_karat[$karat_id] = $items->sum('gold_weight');
        }
    }
   
    public function rules()
    {
        $rules = [];

        foreach ($this->total_weight_per_karat as $karat_id => $value) {
            $rules['total_weight_per_karat.'.$karat_id] = [
                function ($attribute, $value, $fail) use ($karat_id) {
                    // Cek apakah nilai weight lebih besar dari kolom weight di tabel stock_office berdasarkan nilai parent id nya
                    $maxWeight = DB::table('stock_office')
                        ->where('karat_id', $karat_id)
                        ->max('berat_real');
                    if ($value > $maxWeight) {
                        $fail("Jumlah emas melebihi stok yang tersedia. Sisa Stok ($maxWeight gr)");
                    }
                },
            ];
        }
        return $rules;
    }

    public function send(){
        $this->validate();
    }
}
