<?php

namespace App\Http\Livewire\DistribusiToko;

use App\Models\LookUp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Modules\Stok\Models\StockOffice;

class Summary extends Component
{
    public $dist_toko;

    public $total_weight_per_karat = [];
    
    public $id_kategoriproduk_berlian;

    public function render(){
        return view("livewire.distribusi-toko.summary");
    }

    public function mount(){
        $this->id_kategoriproduk_berlian = LookUp::where('kode', 'id_kategoriproduk_berlian')->value('value');
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
        abort_if(Gate::denies('edit_distribusitoko'), 403);
        DB::beginTransaction();
        try{
            $this->dist_toko->setInProgress();
            $this->reduceStockOffice($this->dist_toko->items);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        toast('Distribusi In Progress!', 'success');
        return redirect()->route('distribusitoko.index');
    }

    private function reduceStockOffice($items){
        foreach($items as $item){
            $stock_office = StockOffice::where('karat_id', $item->karat_id)->first();
            if(is_null($stock_office)){
                $stock_office = StockOffice::create(['karat_id'=> $item->karat_id]);
            }
            $item->stock_office()->attach($stock_office->id,[
                'karat_id'=>$item->karat_id,
                'in' => false,
                'berat_real' => -1 * $item->gold_weight,
                'berat_kotor' => -1 * $item->gold_weight
            ]);
            $berat_real = $stock_office->history->sum('berat_real');
            $berat_kotor = $stock_office->history->sum('berat_kotor');
            $stock_office->update(['berat_real'=> $berat_real, 'berat_kotor'=>$berat_kotor]);
        }
    }

}
