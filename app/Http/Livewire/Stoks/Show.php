<?php

namespace App\Http\Livewire\Stoks;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;

class Show extends Component
{
    public $details;
    public $selected_status_id;
    public $product_status;
    public $selectAll = false;
    public $selectedItems = [];
    public $showConfirmModal = false;



    protected $listeners = [
        'selectAllItem' => 'handleSelectAllItem',
        'isSelectAll' => 'handleIsSelectAll'
    ];

    public function handleSelectAllItem($value){
        $this->selectedItems = $value;
    }

    public function handleIsSelectAll($value){
        $this->selectAll = $value;
    }

    public function amount($details)
    {
        $this->$details = $details;
    }
    public function render()
    {
        $this->product_status = ProductStatus::find([
            ProductStatus::PENDING_OFFICE,
            ProductStatus::CUCI,
            ProductStatus::MASAK,
            ProductStatus::RONGSOK,
            ProductStatus::REPARASI,
            ProductStatus::SECOND,
        ]);
        return view('livewire.stoks.show');
    }

    public function proses()
    {
        $this->dispatchBrowserEvent('confirm:modal');
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            foreach ($this->selectedItems as $productId) {
                $product = Product::findOrFail($productId);

                $product->status_id = $this->selected_status_id;
                $product->save();

            }

            DB::commit();
            toast('Nota Pengiriman Berhasil dibuat','success');
            return redirect(route('stok.pending'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('updateError', $e->getMessage());
        }
    }
}
