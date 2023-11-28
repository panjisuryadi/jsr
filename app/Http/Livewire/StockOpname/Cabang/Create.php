<?php

namespace App\Http\Livewire\StockOpname\Cabang;

use App\Models\LookUp;
use DateTime;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Adjustment\Entities\AdjustedProduct;
use Modules\Adjustment\Entities\Adjustment;
use Modules\Adjustment\Entities\AdjustmentSetting;
use Modules\DistribusiToko\Models\DistribusiToko;
use Modules\Group\Models\Group;
use Modules\Karat\Models\Karat;
use Modules\Cabang\Models\Cabang;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;

class Create extends Component
{

    public $cabang;

    public $kategori;

    public $dataKarat = [];

    public $so_details = [];


    protected $listeners = [
        'webcamCaptured' => 'handleWebcamCaptured',
        'webcamReset' => 'handleWebcamReset',
        'setAdditionalAttribute'
    ];

    public $exceptProductId = [];

    public $product_id = [];

    public $adjustment_items = [];

    public $search;

    public $kode_produk;

    public $cabang_id;

    public $active_location;

    public $note;
    public $date;
    public $reference;
    public $countProduct;
    public $dynamic_note;


    private function resetDistribusiToko()
    {
        
    }
    private function resetDistribusiTokoDetails()
    {
        $this->so_details = [];
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
        $this->exceptProductId = array_merge($this->exceptProductId, $this->product_id);
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
        $this->countProduct = $data->count();
        $this->dynamic_note .= "\r\n tersisa " . $this->countProduct . "pcs"; 
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
            'date' => 'required',
        ];

        return $rules;
    }

    public function store()
    {
        $this->validate();

        DB::beginTransaction();
        try{
            
            $adjustment = Adjustment::create([
                'date' => $this->date,
                'reference' =>  Adjustment::generateCode(),
                'note' => $this->note .' | Additional Note : ' . $this->dynamic_note,
                'cabang_id' => $this->cabang_id,
                'created_by' => auth()->user()->id,
            ]);

            $arr_adjusted_product = [];
            foreach($this->so_details as $key => $value) {
                $product_id = !empty($value['id']) ? $value['id'] : null;
                $arr_adjusted_product[] = [
                    'adjustment_id' => $adjustment->id,
                    'product_id' => $product_id,
                    'quantity' => 1,
                    'status' => 1,
                ];
            }
            $product_list = Product::whereNotIn('id', $this->exceptProductId)->where('cabang_id', $this->cabang_id)->get();
            if(!empty($product_list)) {
                foreach($product_list as $row){
                    Product::find($row->id)->updateTracking(ProductStatus::HILANG, $this->cabang_id);
                    $arr_adjusted_product[] = [
                        'adjustment_id' => $adjustment->id,
                        'product_id' => $row->id,
                        'quantity' => 1,
                        'status' => 2, // set as failed
                    ];
                }
            }
            AdjustedProduct::insert($arr_adjusted_product);

        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
        DB::commit();

        AdjustmentSetting::stop();
        session()->flash('Stock Opname berhasil');
        return redirect()->route('adjustments.index');
    }

    public function messages(){
        return [];
    }

    public function selectProduct($val) {
        $val = json_decode($val);
        $this->exceptProductId[] = $val->id;
        $strnote = count($this->exceptProductId) ." produk sudah diidentifikasi.";
        $this->dynamic_note = $strnote;
        $val = (array)$val;
        $val['group'] = (array)$val['group'];
        $val['karat'] = (array)$val['karat'];
        $this->so_details[] = $val;
        
    }

    public function remove($index)
    {
        $data = $this->so_details[$index];
        unset($this->so_details[$index]);
        $product_id = !empty($data['id']) ? $data['id'] : '';
        if (!empty($product_id)) {
            $key = array_search($product_id, $this->exceptProductId);
            if(isset($this->exceptProductId[$key])) {
                unset($this->exceptProductId[$key]);
                if(!empty($this->exceptProductId)) {
                    $strnote = count($this->exceptProductId) ." produk sudah diidentifikasi.";
                }else{
                    $strnote = "Belum ada produk yang diidentifikasi";
                }
                $this->dynamic_note = $strnote;
            }
        }
    }

    public function submitBarcode()
    {
        $this->kode_produk;
        if(!empty($this->kode_produk)){
            $data = Product::with('karat', 'group')->where('product_code',$this->kode_produk)
                            ->where('status_id', ProductStatus::READY)->where('cabang_id', $this->cabang_id);
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
