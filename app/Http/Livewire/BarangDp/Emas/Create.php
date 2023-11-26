<?php

namespace App\Http\Livewire\BarangDp\Emas;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Modules\Karat\Models\Karat;
use Modules\PenerimaanBarangDP\Models\PenerimaanBarangDP;
use Modules\Product\Entities\Product;

class Create extends Component
{
    public PenerimaanBarangDP $barang_dp;
    public Product $product;
    public $nominal = 0;
    public $karats;
    public $tipe_pembayaran = '';
    public $hari_ini;
    public $pic_id;
    public $cicil = '';
    public $detail_cicilan = [];
    public $tgl_jatuh_tempo;
    public $uploaded_image = '';
    public $webcam_image = '';
    public function render()
    {
        return view('livewire.barang-dp.emas.create');
    }

    public function mount(){
        $this->barang_dp = new PenerimaanBarangDP();
        $this->product = new Product();
        $this->karats = Karat::karat()->get();
        $this->hari_ini = (new DateTime())->format('Y-m-d');
        $this->pic_id = auth()->user()->id;
        if(auth()->user()->isUserCabang()){
            $this->cabang_id = auth()->user()->namacabang()->id;
        }
    }

    public function rules(){
        return [
            'barang_dp.cabang_id' => ['required'],
            'barang_dp.date' => ['required', 'date',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);

                    if ($inputDate > $today) {
                        $fail($attribute . ' harus tanggal hari ini atau sebelumnya.');
                    }
                }
            ],
            'barang_dp.owner_name' => ['required'],
            'barang_dp.contact_number' => ['required'],
            'barang_dp.address' => ['required'],
            'product.karat_id' => ['required'],
            'product.berat_emas' => ['required'],
            'nominal' => ['required','gt:0'],
            'tipe_pembayaran' => ['required'],
            'cicil' => 'required_if:tipe_pembayaran,cicil',
            'tgl_jatuh_tempo' => [
                'required_if:tipe_pembayaran,jatuh_tempo',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);
                    if ($inputDate < $today) {
                        $fail($attribute . ' harus tanggal hari ini atau setelahnya.');
                    }
                }
            ],
            'webcam_image' => ['required_if:uploaded_image,']
        ];
    }

    public function getNominalTextProperty()
    {
        return 'Rp. ' . number_format(intval($this->nominal), 0, ',', '.');
    }

    public function getMinCicilDate($key){
        if(in_array($key-1,array_keys($this->detail_cicilan))){
            $minCicilDate = new DateTime($this->detail_cicilan[$key-1]);
            return $minCicilDate->modify("+1 day")->format("Y-m-d");
        }else{
            return $this->hari_ini;
        }
    }

    public function resetDetailCicilanAfterwards($key){
        for ($i=$key+1; $i <= count($this->detail_cicilan) ; $i++) { 
            $this->detail_cicilan[$i] = "";
        }
    }

    public function updatedTipePembayaran(){
        $this->reset('cicil');
        $this->reset('detail_cicilan');
        $this->reset('tgl_jatuh_tempo');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->validate();

        $data = [
            
        ];

        
        $this->resetInputFields();

        session()->flash('message', 'Created Successfully.');
    }

     protected $listeners = [
        'imageUploaded',
        'imageRemoved',
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset'

    ];

    public function handleWebcamCaptured($data_uri){
        $this->webcam_image = $data_uri;
    }

    public function handleWebcamReset(){
        $this->webcam_image = '';
    }

    public function imageUploaded($fileName){
        $this->uploaded_image = $fileName;
    }

    public function imageRemoved($fileName){
        $this->uploaded_image = '';
    }
}
