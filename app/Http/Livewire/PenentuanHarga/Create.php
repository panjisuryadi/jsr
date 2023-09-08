<?php

namespace App\Http\Livewire\PenentuanHarga;

use Livewire\Component;

use Modules\Karat\Models\Karat;
use Modules\PenentuanHarga\Models\PenentuanHarga;


class Create extends Component
{

    public $selected = '';
    public $harga_emas = '';
    public $harga_modal;
    public $harga_margin = '';
    public $harga_jual = '';
    public $showCount;
    public $karat = '';
    public $karat_id = '';
    public $kode_karat = '';
  
    public $selectedOption = '';
    public $pilihKarat = '';
  
    public $HargaFinal = 0;
    public $HargaFinalRp = 0;
    public $hargaModal = 0;
    public $HargaFinalEmasRp = 0;
    public $HargaFinalEmas = 0;
    public $HargaEmasRp = 0;
    public $rHarga_emas = 0;




    public function selectOption($value)
    {
        $harga_emas = preg_replace("/[^0-9]/", "", $this->harga_emas);
        $this->selectedOption = $value;
        $this->emit('optionSelected', $value);
    }


    public function pilihKarat($value) {
        $krt = Karat::where('id', $value)->first();
        $this->karat = $krt->name;
        $this->karat_id = $krt->id;
        $this->kode_karat = $krt->kode;
       // dd($karat->name);
        //$this->emit('selected', $value);
     }

    public function render()
    {
        return view('livewire.penentuan-harga.create');
    }


      public function calculatePriceTotal()
       {
           dd($this->harga_modal);
       }

      public function bagiHarga()
       {
            if ($this->harga_emas == null 
                && $this->harga_modal == null 
                && $this->harga_margin == null) {
                $this->berat_modal = 0;
                $this->harga_emas = 0;
                $this->harga_margin = 0;
            }
          if ($this->kode_karat == null) {
                //dd('sdsdsdsd');

            // $this->dispatchBrowserEvent('alert',[
            //     'type'=>'error',
            //     'message'=>"Harga Karat diisi dulu"
            // ]);


            }
     

        $this->charga_emas = preg_replace("/[^0-9]/", "", $this->harga_emas);
        $this->rHarga_emas = ((int)$this->kode_karat / 100) * (int)$this->charga_emas;
        $this->HargaEmasRp = 'Rp ' . number_format($this->rHarga_emas, 0, ',', '.');

       }




               public function store()
                 {
            
                    $validatedDate = $this->validate([
                        'karat_id'      => 'required',
                        'harga_emas'    => 'required',
                        'harga_margin'  => 'required',
                    ]);
              
                // dd($input);
                 $create = PenentuanHarga::create([
                'karat_id'                          => $this->karat_id,
                'user_id'                           =>  auth()->user()->id,
                'margin'                            => $this->charga_margin,
                'tgl_update'                        => date('Y-m-d'),
                'harga_modal'                       => $this->rHarga_emas,
                'harga_emas'                        => $this->HargaFinalEmas,
                'harga_jual'                        => $this->HargaFinal,
                'lock'                              =>  1,
                      ]);
        
             $this->resetInput();
                    session()->flash('message', 'Created Successfully.');
                    return redirect(route('penentuanharga.index'));
       }




      public function recalculateTotal()
       {
        //$this->resetInput();
       
        if ($this->harga_emas == null 
            && $this->rHarga_emas == null 
            && $this->harga_margin == null) {
            $this->berat_modal = 0;
            $this->harga_emas = 0;
            $this->harga_margin = 0;
            $this->rHarga_emas = 0;
        }

        $this->charga_emas = preg_replace("/[^0-9]/", "", $this->harga_emas);
        $this->charga_margin = preg_replace("/[^0-9]/", "", $this->harga_margin);
        $this->HargaFinalEmas = (int)$this->charga_emas * (int)$this->kode_karat;
        $this->HargaFinalEmasRp = 'Rp ' . number_format($this->HargaFinalEmas, 0, ',', '.');
        $this->HargaFinal = (int)$this->rHarga_emas + (int)$this->charga_margin;
        $this->HargaFinalRp = 'Rp ' . number_format($this->HargaFinal, 0, ',', '.');
    }


  public function resetInput()
    {
        $this->HargaEmasRp = '';
        $this->HargaFinal = '';
        $this->harga_emas = '';
        $this->harga_margin = '';
        $this->harga_jual = '';
        $this->harga_modal = '';
  
      
    }


}
