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


    public $penentuan_harga;
    public $pharga = [];
    public $updateMode = false;



    public function selectOption($value)
    {
        $harga_emas = preg_replace("/[^0-9]/", "", $this->harga_emas);
        $this->selectedOption = $value;
        $this->emit('optionSelected', $value);
    }


    public function pilihKarat($value) {
        if(!empty($value)) {
            $krt = Karat::where('id', $value)->first();
            $ph = PenentuanHarga::where('karat_id', $value)->first();
            $this->karat = $krt->name;
            $this->karat_id = $krt->id;
            $this->kode_karat = $krt->kode;
            $this->resetInput();
    
            if ($ph) {
             $this->updateMode = true;
             $this->penentuan_harga = PenentuanHarga::with('karat')->where('karat_id', $value)->first();
                //dd($ph);
            } else {
                 $this->updateMode = false;
               // dd('xxx');
              // code...
            }
        }else{
            
            $this->karat = '';
            $this->karat_id = '';
            $this->kode_karat = '';
        }
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
                'margin'                            => $this->getNumberVal($this->harga_margin),
                'tgl_update'                        => date('Y-m-d'),
                'harga_modal'                       => $this->getNumberVal($this->harga_modal),
                'harga_emas'                        => $this->getNumberVal($this->harga_emas),
                'harga_jual'                        => $this->getNumberVal($this->harga_jual),
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
    
    /** Penentuan Harga Modal
     * Harga emas diinput manual
     * Ketika harga emas diinput maka harga jual akan otomatis terisi
     * Harga jual = harga emas * kode karat
     */
    public function setHargaModal($value) 
    {
        if(!empty($this->kode_karat)){
            $number_harga_emas = $this->getNumberVal($value);
            $number_kode_karat = $this->getNumberVal($this->kode_karat);
            $result = $number_harga_emas * $number_kode_karat;
            $this->harga_emas = $this->setFormatRupiah($number_harga_emas);
            $this->harga_modal = $this->setFormatRupiah($result);
        }
    }
    
    /** Penentuan harga Jual
     * Harga margin diinput manual
     * ketika margin diinput maka harga jual akan otomatis diisi
     * harga jual = harga modal + margin
     */
    public function setHargaJual($value) 
    {
        $number_harga_margin = $this->getNumberVal($value);
        $number_harga_modal = $this->getNumberVal($this->harga_modal);
        if(!empty($number_harga_modal)) {
            $result = $number_harga_margin + $number_harga_modal;
            $this->harga_margin = $this->setFormatRupiah($number_harga_margin);
            $this->harga_jual = $this->setFormatRupiah($result);
        }
    }
    
    /** set number ke format rupiah untuk ditampilkan dihalaman depan */
    public function setFormatRupiah($val) {
        return 'Rp ' . number_format($val, 0, ',', '.');
    }

    /** untuk mengambil number dari string
     * ex : Rp. 2.000 => 2000
     */
    public function getNumberVal($value) {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }


}
