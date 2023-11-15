<?php

namespace App\Http\Livewire\GoodsReceipt\Toko\Nota;

use App\Models\LookUp;
use App\Models\TrackingStatus;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\BuysBack\Models\BuyBackItem;
use Modules\BuysBack\Models\BuyBackNota;
use Modules\BuysBack\Models\BuyBackNotaStatus;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Produksi\Models\ProduksiItems;
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockCabang;

use Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar;
use Modules\Product\Models\ProductStatus;

class Confirm extends Component
{
    public $nota;

    public $nota_items;

    public function render()
    {
        return view("livewire.goods-receipt.toko.nota.confirm");
    }

    public function nominalText($value){
        return 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }

    public $selectedItems = [];

    public $selectAll = false;

    public $note = '';

    protected $listeners = [
        'selectAllItem' => 'handleSelectAllItem',
        'isSelectAll' => 'handleIsSelectAll'
    ];

    public function handleSelectAllItem($selectedItems){
        $this->selectedItems = $selectedItems;
    }

    public function handleIsSelectAll($value){
        $this->selectAll = $value;
    }

    public function updatedSelectedItems(){
        if(count($this->selectedItems) == count($this->nota_items)){
            $this->selectAll = true;
        }else{
            $this->selectAll = false;
        }
    }

    public function mount()
    {
        $this->nota_items = $this->nota->items;
    }

    public function rules()
    {
        $rules = [
            'note' => 'required_if:selectAll,false'
        ];
        return $rules;
    }

    public function messages(){
        return [
            'note.required_if' => 'Wajib di isi',
        ];
    }

    public function proses()
    {
        $this->dispatchBrowserEvent('approve:modal');
    }

    public function showTracking(){
        $this->dispatchBrowserEvent('tracking:modal');
    }

    public function submit(){
        $this->validate();
        DB::beginTransaction();
        try{
            $this->nota->updateTracking(TrackingStatus::APPROVED,null);
            $this->nota->updateTracking(TrackingStatus::COMPLETED,null);
            foreach($this->nota_items as $item){
                $product = $item->product;
                if(in_array($item->id, $this->selectedItems)){
                    $item->approve();
                    $product->updateTracking(ProductStatus::PENDING_OFFICE);
                }else{
                    $item->reject();
                    $product->updateTracking(ProductStatus::HILANG);
                }
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }
        toast('Penerimaan Barang Berhasil dilakukan','success');
        return redirect(route('goodsreceipt.toko.buyback-barangluar.index'));
    }

}
