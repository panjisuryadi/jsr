<?php

namespace App\Http\Livewire\GoodsReceiptBerlian;

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
use Modules\GoodsReceiptBerlian\Http\Controllers\GoodsReceiptBerliansController;
use Modules\Karat\Models\Karat;
use Modules\KaratBerlian\Models\KaratBerlian;
use Modules\KaratBerlian\Models\ShapeBerlian;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\People\Entities\Supplier;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

use function PHPUnit\Framework\isEmpty;

class PenerimaanQc extends Component
{
    use WithFileUploads;
    public $code,
        $no_invoice,
        $pengirim,
        $supplier_id = '',
        $tipe_pembayaran = '',
        $tanggal,
        $cicil = '',
        $detail_cicilan = [],
        $tgl_jatuh_tempo,
        $berat_timbangan,
        $selisih,
        $catatan,
        $pic_id = '',
        $nama_produk = '',
        $karat_id,
        $image,
        $kategoriproduk_id = 2, //kategori berlian
        $document = [];

    public $updateMode = false;
    public $total_berat = 0;
    public $inputs = [
        [
            'karatberlians_id' => '',
            'shapeberlian_id' => '',
            'qty' => 0,
            'keterangan' => ''
        ]
    ];

    public $total_berat_real = 0;
    public $total_berat_kotor = 0;
    public $dataSupplier = [];
    public $dataKarat = [];
    public $dataKaratBerlian = [];
    public $dataShapes = [];
    public $dataKategoriProduk = [];
    public $kasir = [];

    public $hari_ini;

    public $type;
    public $total_karat;


    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset'
    ];

    public function handleWebcamCaptured($data_uri){
        $this->image= $data_uri;
    }

    public function mount()
    {
        $this->dataSupplier = Supplier::all();
        $this->dataKarat = Karat::whereNull('parent_id')->get();
        $this->dataKaratBerlian = KaratBerlian::all();
        $this->dataShapes = ShapeBerlian::all();
        $this->dataKategoriProduk = KategoriProduk::all();
        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
        $this->type = 1;
    }

    public function addInput()
    {
        $this->inputs[] = [
            'karatberlians_id' => '',
            'shapeberlian_id' => '',
            'qty' => 0,
            'keterangan' => ''
        ];
    }


    public function remove($i)
    {
        $this->resetErrorBag();
        unset($this->inputs[$i]);
        $this->inputs = array_values($this->inputs);
    }

    public function render()
    {
        $this->kasir = User::role('Kasir')->orderBy('name')->get();
        $this->tanggal = $this->hari_ini;
        return view('livewire.goods-receipt-berlian.penerimaanqc');
    }

    private function resetInputFields()
    {
        $this->inputs = [
            [
                'karatberlians_id' => '',
                'shapeberlian_id' => '',
                'qty' => 0,
                'keterangan' => ''
            ]
        ];
    }


    public function rules()
    {
        $rules = [
            'code' => 'required',
            'supplier_id' => 'required',
            'nama_produk' => 'required',
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
        ];

        if($this->type == 2) {
            $rules['karat_id'] = 'required';
        }

        if(!empty($this->karat_id)) {
            foreach ($this->inputs as $key => $value) {
                $rules['inputs.' . $key . '.karatberlians_id'] = 'required';
                $rules['inputs.' . $key . '.qty'] = 'required|gt:0';
            }
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
            'nama_produk' => $this->nama_produk,
            'no_invoice' => !empty($this->no_invoice) ? $this->no_invoice : '-',
            'pengirim' => $this->pengirim,
            'supplier_id' => $this->supplier_id,
            'karat_id' => $this->karat_id,
            'tipe_pembayaran'=>$this->tipe_pembayaran,
            'tanggal' => $this->tanggal,
            'cicil' => $this->tipe_pembayaran == 'cicil'? $this->cicil : 0,
            'tgl_jatuh_tempo' => $this->tipe_pembayaran == 'jatuh_tempo'? $this->tgl_jatuh_tempo : null,
            'berat_timbangan' => $this->berat_timbangan,
            'selisih' => $this->selisih,
            'catatan' => $this->catatan,
            'pic_id' => auth()->user()->id,
            'image' => $this->image,
            'document' => $this->document,
            'total_berat_real' => $this->total_berat_real,
            'total_berat_kotor' => $this->total_berat_kotor,
            'total_karat' => $this->total_karat,
            'items' => $this->inputs,
            'kategoriproduk_id' => $this->kategoriproduk_id,
            'detail_cicilan' => $this->detail_cicilan
        ];
        
        $request = new Request($data);
        $controller = new GoodsReceiptBerliansController();
        $store = $controller->store_qc($request);
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

    public function setImageFromWebcam($image) {
        $this->image = $image;
    }
    
}
