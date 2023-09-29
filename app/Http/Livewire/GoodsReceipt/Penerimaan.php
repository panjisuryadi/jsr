<?php

namespace App\Http\Livewire\GoodsReceipt;

use Livewire\Component;
use App\Http\Livewire\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\GoodsReceipt\Models\GoodsReceipt;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Http;
use Livewire\WithFileUploads;
use Modules\GoodsReceipt\Http\Controllers\GoodsReceiptsController;
use Modules\Karat\Models\Karat;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\People\Entities\Supplier;

class Penerimaan extends Component
{
    use WithFileUploads;
    public $code,
        $no_invoice,
        $pengirim,
        $supplier_id = '',
        $tipe_pembayaran = '',
        $tanggal,
        $cicil = '',
        $tgl_jatuh_tempo,
        $berat_timbangan,
        $selisih,
        $catatan,
        $pic_id = '',
        $document = [];

    public $updateMode = false;
    public $total_berat = 0;
    public $inputs = [
        [
            'karat_id' => '',
            'kategori_id' => '',
            'berat_real' => 0,
            'berat_kotor' => 0
        ]
    ];

    public $total_berat_real = 0;
    public $total_berat_kotor = 0;
    public $dataSupplier = [];
    public $dataKarat = [];
    public $dataKategoriProduk = [];
    public $kasir = [];

    public $hari_ini;

    protected $listeners = ['imageUploaded','imageRemoved'];

    public function mount()
    {
        $this->dataSupplier = Supplier::all();
        $this->dataKarat = Karat::all();
        $this->dataKategoriProduk = KategoriProduk::all();

        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
    }

    public function addInput()
    {
        $this->inputs[] = [
            'karat_id' => '',
            'kategori_id' => '',
            'berat_real' => 0,
            'berat_kotor' => 0
        ];
    }


    public function remove($i)
    {
        $this->resetErrorBag();
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
        $this->calculateTotalBeratReal();
        $this->calculateTotalBeratKotor();
    }

    public function render()

    {
        $this->kasir = User::role('Kasir')->orderBy('name')->get();
        return view('livewire.goods-receipt.penerimaan');
    }

    private function resetInputFields()
    {
        $this->inputs = [
            [
                'karat_id' => '',
                'kategori_id' => '',
                'berat_real' => 0,
                'berat_kotor' => 0
            ]
        ];
    }


    public function rules()
    {
        $rules = [
            'code' => 'required',
            'no_invoice' => 'required|string|max:50',
            'supplier_id' => 'required',
            'tanggal' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $today = Carbon::today();
                    $inputDate = Carbon::parse($value);

                    if ($inputDate > $today) {
                        $fail($attribute . ' harus tanggal hari ini atau sebelumnya.');
                    }
                }
            ],
            'total_berat_real' => 'required|numeric',
            'total_berat_kotor' => 'required|numeric',
            'tipe_pembayaran' => 'required',
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
            'berat_timbangan' => 'required|numeric|gt:0',
            'selisih' => 'numeric',
            'pengirim' => 'required',
            'pic_id' => 'required'
        ];

        foreach ($this->inputs as $key => $value) {
            $rules['inputs.' . $key . '.karat_id'] = 'required';
            $rules['inputs.' . $key . '.kategori_id'] = 'required';
            $rules['inputs.' . $key . '.berat_real'] = 'required|gt:0';
            $rules['inputs.' . $key . '.berat_kotor'] = 'required|gt:0';
        }
        return $rules;
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }



    public function submit(Request $request)
    {
        $this->validate();

        $data = [
            'code' => $this->code,
            'no_invoice' => $this->no_invoice,
            'pengirim'=>$this->pengirim,
            'supplier_id' => $this->supplier_id,
            'tipe_pembayaran'=>$this->tipe_pembayaran,
            'tanggal' => $this->tanggal,
            'cicil' => $this->tipe_pembayaran == 'cicil'?$this->cicil:0,
            'tgl_jatuh_tempo' => $this->tipe_pembayaran == 'jatuh_tempo'? $this->tgl_jatuh_tempo : null,
            'berat_timbangan' => $this->berat_timbangan,
            'selisih' => $this->selisih,
            'catatan' => $this->catatan,
            'pic_id' => $this->pic_id,
            'document' => $this->document,
            'total_berat_real' => $this->total_berat_real,
            'total_berat_kotor' => $this->total_berat_kotor,
            'items' => $this->inputs,
        ];

        $request = new Request($data);
        $controller = new GoodsReceiptsController();
        $controller->store($request);
        $this->resetInputFields();

        session()->flash('message', 'Created Successfully.');
    }


    public function calculateTotalBeratReal()
    {
        $this->total_berat_real = 0;
        foreach ($this->inputs as $key => $value) {
            $this->total_berat_real += floatval($this->inputs[$key]['berat_real']);
            $this->total_berat_real = number_format(round($this->total_berat_real, 3), 3, '.', '');
            $this->total_berat_real = rtrim($this->total_berat_real, '0');
            $this->total_berat_real = formatWeight($this->total_berat_real);
        }
    }

    public function calculateTotalBeratKotor()
    {
        $this->total_berat_kotor = 0;
        foreach ($this->inputs as $key => $value) {
            $this->total_berat_kotor += floatval($this->inputs[$key]['berat_kotor']);
            $this->total_berat_kotor = number_format(round($this->total_berat_kotor, 3), 3, '.', '');
            $this->total_berat_kotor = rtrim($this->total_berat_kotor, '0');
            $this->total_berat_kotor = formatWeight($this->total_berat_kotor);
        }
    }

    public function imageUploaded($fileName){
        $this->document[] = $fileName;
    }

    public function imageRemoved($fileName){
        $this->document = array_filter($this->document, function($file) use ($fileName){
            return $file != $fileName;
        });
    }
}
