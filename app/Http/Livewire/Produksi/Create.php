<?php

namespace App\Http\Livewire\Produksi;

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
use Modules\Produksi\Http\Controllers\ProduksisController;
use Modules\Karat\Models\Karat;
use Modules\KaratBerlian\Models\KaratBerlian;
use Modules\KaratBerlian\Models\ShapeBerlian;
use Modules\KategoriProduk\Models\KategoriProduk;
use Modules\Group\Models\Group;
use Modules\Produksi\Models\Produksi;
use Modules\Stok\Models\StockKroom;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;
use App\Models\LookUp;
use Modules\Produksi\Models\DiamondCertificateAttributes;

use function PHPUnit\Framework\isEmpty;

class Create extends Component
{
    use WithFileUploads;
    public $source_kode = 'lantakan',
        $berat_asal,
        $karatasal_id,
        $karat_id,
        $kategoriproduk_id,
        $berat,
        $tanggal,
        $type = 1,
        $karat24k,
        $id_kategoriproduk_berlian,
        $code,
        $image,
        $model_id;

    public $inputs = [
        [
            'karatberlians_id' => '',
            'shapeberlian_id' => '',
            'qty' => 1,
            'keterangan' => ''
        ]
    ];

    public $dataKarat = [];
    public $dataKaratBerlian = [];
    public $dataShapes = [];
    public $dataKategoriProduk = [];
    public $dataGroup = [];
    public $arrayKaratBerlian = [];
    public $dataCertificateAttribute = [];
    public $sertifikat = [];

    public $currentKey;
    public $tmpCertificate = [];

    public $hari_ini;

    public function mount()
    {
        $this->dataKarat = Karat::whereNull('parent_id')->get();
        $this->dataKaratBerlian = KaratBerlian::all();
        $this->dataShapes = ShapeBerlian::all();
        $this->dataGroup = Group::all();
        $this->hari_ini = new DateTime();
        $this->hari_ini = $this->hari_ini->format('Y-m-d');
        $id_karat_24k = LookUp::select('value')->where('kode', 'id_karat_emas_24k')->first();
        $this->karat24k = !empty($id_karat_24k['value']) ? $id_karat_24k['value'] : 0;
        $id_kategoriproduk_berlian = LookUp::select('value')->where('kode', 'id_kategoriproduk_berlian')->first();
        $this->id_kategoriproduk_berlian = !empty($id_kategoriproduk_berlian['value']) ? $id_kategoriproduk_berlian['value'] : 0;
        $this->dataKategoriProduk = KategoriProduk::all();
        $this->dataCertificateAttribute = DiamondCertificateAttributes::all();
        $this->code = Produksi::generateCode();

        $arrayKaratBerlian = [];
        foreach($this->dataKaratBerlian as $k => $row){
            $arrayKaratBerlian[$row->id] = $row->karat;
        }

        $this->arrayKaratBerlian = $arrayKaratBerlian;

    }

    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset'
    ];

    public function handleWebcamCaptured($data_uri){
        $this->image= $data_uri;
    }

    public function addInput()
    {
        $this->inputs[] = [
            'karatberlians_id' => '',
            'shapeberlian_id' => '',
            'qty' => 1,
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
        $this->tanggal = $this->hari_ini;
        return view('livewire.produksi.create');
    }

    private function resetInputFields()
    {
        $this->inputs = [
            [
                'karatberlians_id' => '',
                'shapeberlian_id' => '',
                'qty' => 1,
                'keterangan' => ''
            ]
        ];
    }


    public function rules()
    {
        $rules = [
            'source_kode' => 'required',
            'karatasal_id' => 'required',
            'berat_asal' => 'required',
            'karat_id' => 'required',
            'berat' => 'required',
        ];

        /** rules cek stok lantakan */
        if($this->source_kode == "lantakan") {
            $rules['berat_asal'] = [
                'required',
                function ($attribute, $value, $fail) {
                    $stok_lantakan = StockKroom::sum('weight');
                    $stok_lantakan_terpakai = Produksi::where('source_kode', $this->source_kode)->sum('berat_asal');
                    $sisa_stok_lantakan = $stok_lantakan - $stok_lantakan_terpakai;
                    if ($value > $sisa_stok_lantakan) {
                        $fail('Sisa stok tidak mencukupi, berat asal harus kurang dari sama dengan '. $sisa_stok_lantakan);
                    }
                }

            ];

            /** validasi stok berlian
             * cek dulu apakah ini produksi berlian
             * collect data stok per jenis karat
             * bandingkan stok
             */
            if($this->kategoriproduk_id == $this->id_kategoriproduk_berlian && !empty($this->inputs[0]['karatberlians_id'])) {
                $sisa_stok_berlian = GoodsReceipt::where('kategoriproduk_id', $this->id_kategoriproduk_berlian)->sum('total_karat');
                $total_karat_dipinta = 0;
                foreach ($this->inputs as $key => $value) {
                    $rules['inputs.' . $key . '.karatberlians_id'] = 'required';
                    $rules['inputs.' . $key . '.qty'] = 'required|gt:0';

                    $karatberlians_id = !empty($value['karatberlians_id']) ? $value['karatberlians_id'] : 0;
                    $qty = !empty($value['qty']) ? $value['qty'] : 0;
                    $karat = !empty($this->arrayKaratBerlian[$karatberlians_id]) ? $this->arrayKaratBerlian[$karatberlians_id] : 0;
                    $stok_berlian_terpakai = $karat * $qty;
                    $total_karat_dipinta += $stok_berlian_terpakai;

                    if($sisa_stok_berlian < $total_karat_dipinta) {
                        $rules['inputs.' . $key . '.karatberlians_id'] = [
                            function ($attribute, $value, $fail) use ($sisa_stok_berlian) {
                                $fail('Sisa stok tidak mencukupi, sisa stok berlian saat ini ' . $sisa_stok_berlian . ' ct');
                            }
                            
                        ];

                    }
                    
                }

            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'karatasal_id.required' => 'Karat asal harus diisi!',
            'karat_id.required' => 'Karat jadi harus diisi!',
            'berat.required' => 'Berat jadi harus diisi!',
        ];
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit(Request $request)
    {
        /** Blok untuk ngeset sertifikat ke item diamond */
        if(!empty($this->inputs)) {
            foreach($this->inputs as $k => $item) {
                $this->inputs[$k]['sertifikat'] = !empty($this->sertifikat[$k]) ? $this->sertifikat[$k] : [];
            }
        }

        $this->validate();

        $data = [
            'code' => $this->code,
            'image' => $this->image,
            'karatasal_id' => $this->karatasal_id,
            'karat_id' => $this->karat_id,
            'model_id' => !empty($this->model_id) ? $this->model_id : null,
            'source_kode' => $this->source_kode,
            'berat_asal' => $this->berat_asal,
            'berat' => $this->berat,
            'tanggal' => $this->tanggal,
            'created_by' => auth()->user()->id,
            'items' => $this->inputs,
            'kategoriproduk_id' => $this->kategoriproduk_id,
        ];
        $request = new Request($data);
        $controller = new ProduksisController();
        $store = $controller->store($request);
        dd($store);
    }

    public function setCurrentKey($key)
    {
        $this->currentKey = $key;
    }
    
}
