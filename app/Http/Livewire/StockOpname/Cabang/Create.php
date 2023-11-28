<?php

namespace App\Http\Livewire\StockOpname\Cabang;

use App\Models\LookUp;
use DateTime;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Adjustment\Entities\Adjustment;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;

class Create extends Component
{

    public $categories;

    public $product_category;

    public $cabang;

    public $kategori;

    public $logam_mulia_id;

    public $karat_logam_mulia;

    public $distribusi_toko = [
        'no_distribusi_toko' =>'',
        'date' => '',
        'cabang_id' => ''
    ];

    public $dataKarat = [];

    public $so_details = [];

    public $used_stock = [];

    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
        'setAdditionalAttribute'
    ];

    public $exceptProductId = [];

    public $produksis_id = [];

    public $adjustment_items = [];

    public $search;

    public $kode_produk;

    public $cabang_id;

    public $active_location;



    private function resetDistribusiToko()
    {
        $this->distribusi_toko = [
            'date' => '',
            'cabang_id' => ''
        ];
    }
    private function resetDistribusiTokoDetails()
    {
        $this->so_details = [
            [
                'product_category' => '',
                'group' => '',
                'model' => '',
                'gold_category' => '',
                'karat' => '',
                'accessoris_weight' => 0,
                'label_weight' => 0,
                'gold_weight' => 0,
                'total_weight' => 0,
                'code' => '',
                'file' => '',
                'certificate_id' => '',
                'no_certificate' => '',
                'webcam_image' => '',
                'product_category_name' => '',
                'group_name' => '',
                'model_name' => '',
            ]
        ];
    }

    public function mount()
    {
        if(auth()->user()->isUserCabang()) {
            $this->cabang_id = auth()->user()->namacabang()->id;
        }

        $this->date = new DateTime();
        $this->date = $this->date->format('Y-m-d');
        $this->reference = Adjustment::generateCode();

    }

    public function render(){
        $this->exceptProductId = array_merge($this->exceptProductId, $this->produksis_id);
        $data = Product::where('status_id', ProductStatus::READY)->where('cabang_id', $this->cabang_id);
        if (!empty($this->exceptProductId)) {
                $data = $data->whereNotIn('id', $this->exceptProductId);
            }
            if (!empty($this->search)) {
                $search = $this->search;
                $data->where(function($query) use ($search) {
                        $query->where('code','like', '%'. $search . '%');
                        $query->orWhere('berat','like', '%'. $search . '%');
                    });
            }
        $data = $data->paginate(5);
        return view("livewire.stock-opname.cabang.create",[
            'products' => $data
        ]);
    }

    private function resetInputFields()
    {
        $this->resetDistribusiToko();
        $this->resetDistribusiTokoDetails();
    }


    public function rules()
    {
        $rules = [
            // 'distribusi_toko.cabang_id' => 'required',
            // 'distribusi_toko.date' => 'required',
            // 'distribusi_toko.no_distribusi_toko' => 'required|string|max:70'
        ];

        return $rules;
    }

    public function store()
    {
        $this->validate();
        $kategoriproduk_id = LookUp::where('kode', 'id_kategoriproduk_berlian')->value('value');

        DB::beginTransaction();
        try{
            $distribusi_toko = DistribusiToko::create([
                'cabang_id'                   => $this->distribusi_toko['cabang_id'],
                'date'                        => $this->distribusi_toko['date'],
                'no_invoice'                  => $this->distribusi_toko['no_distribusi_toko'],
                'kategori_produk_id'          => $kategoriproduk_id,
                'created_by'                  => auth()->user()->name,
            ]);

            $ids = [];
            foreach($this->so_details as $key => $value) {
                $additional_data = [
                    "product_information" => $value
                ];
                $distribusi_toko->items()->create([
                    'karat_id' => !empty($value['karat_id']) ? $value['karat_id'] : 0,
                    'gold_weight' => !empty($value['berat_emas']) ? $value['berat_emas'] : 0,
                    'product_id' => !empty($value['id']) ? $value['id'] : null,
                    'additional_data' => json_encode($additional_data),
                ]);

                if (!empty($value['id'])) {
                    $ids[] = $value['id'];
                }
            }
            if(!empty($ids)) {
                $product_insert = Product::whereIn('id', $ids)->update(['status_id' => 12, 'cabang_id' => $distribusi_toko->cabang_id]);
            }
            $distribusi_toko->setAsDraft();

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        $this->resetInputFields();
        toast('Saved to Draft Successfully','success');
        return redirect(route('distribusitoko.detail', $distribusi_toko));
    }

    public function messages(){
        return [];
    }

    public function selectProduct($val) {
        $val = json_decode($val);
        $this->exceptProductId[] = $val->id;
        $val = (array)$val;
        $this->so_details[] = $val;
        
    }

    public function remove($index)
    {
        $data = $this->so_details[$index];
        unset($this->so_details[$index]);
        $produksis_id = !empty($data['id']) ? $data['id'] : '';
        if (!empty($produksis_id)) {
            $key = array_search($produksis_id, $this->exceptProductId);
            if(isset($this->exceptProductId[$key])) {
                unset($this->exceptProductId[$key]);
            }
        }
    }

    public function submitBarcode()
    {
        $this->kode_produk;
        if(!empty($this->kode_produk)){
            $data = Product::with('karat', 'group')->where('product_code',$this->kode_produk);
            if (!empty($this->exceptProductId)) {
                $data = $data->whereNotIn('id', $this->exceptProductId);
            }
            $data = $data->first();
            if ($data) {
                $this->selectProduct($data);
                $this->kode_produk = '';
            }

        }

    }
}
