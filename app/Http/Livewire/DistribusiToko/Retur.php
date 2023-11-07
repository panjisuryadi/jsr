<?php

namespace App\Http\Livewire\DistribusiToko;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Modules\Stok\Models\StockOffice;

class Retur extends Component
{
    public $dist_toko;

    public $total_weight_per_karat = [];

    public function render(){
        return view("livewire.distribusi-toko.retur");
    }

    protected $listeners = [
        'is_approved' => 'handleIsApproved'
    ];

    public function mount(){
        
    }
   
    public function rules()
    {
        $rules = [];

        
        return $rules;
    }

    public function submit(){
        
    }

    public function handleIsApproved($is_approved){
        if($is_approved){
            foreach($this->dist_toko->items()->returned()->get() as $item){
                $stock_office = StockOffice::where('karat_id', $item->karat_id)->first();
                if(is_null($stock_office)){
                    $stock_office = StockOffice::create(['karat_id'=> $item->karat_id]);
                }
                $item->stock_office()->attach($stock_office->id,[
                    'karat_id'=>$item->karat_id,
                    'in' => true,
                    'berat_real' =>$item->gold_weight,
                    'berat_kotor' => $item->gold_weight
                ]);
                $berat_real = $stock_office->history->sum('berat_real');
                $berat_kotor = $stock_office->history->sum('berat_kotor');
                $stock_office->update(['berat_real'=> $berat_real, 'berat_kotor'=>$berat_kotor]);
            }
            $this->dist_toko->setAsCompleted();
            toast('Berhasil Menambah Stok Gudang','success');
            return redirect(route('distribusitoko.index'));
        }
    }

}
