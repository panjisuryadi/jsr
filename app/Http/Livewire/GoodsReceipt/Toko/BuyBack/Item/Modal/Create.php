<?php

namespace App\Http\Livewire\GoodsReceipt\Toko\BuyBack\Item\Modal;

use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\BuysBack\Models\BuyBackItem;
use Modules\GoodsReceipt\Models\Toko;
use Modules\People\Entities\Customer;
use Modules\Product\Entities\Product;
use Modules\Product\Models\ProductStatus;
use Modules\Status\Models\ProsesStatus;
use Modules\Stok\Models\StockPending;

class Create extends Component
{
    public $code;
    public $date;
    public $product;
    public $nominal_text = '';

    public $customer_id = '';
    public $customers;
    public $nominal = 0;

    public $note = '';
    public function mount() {
        $this->date = (new DateTime())->format('Y-m-d');
        $this->customers = Customer::all();
    }

    public function rules()
    {
        return [
            'code' => [
                'required',
                function ($attribute, $value, $fail) {
                    $product = Product::where(['product_code' => $value])->first();
                    if(is_null($product)){
                        $fail('Produk tidak ditemukan');
                    }else{
                        $is_exist = Toko\GoodsReceiptItem::where('product_id',$product->id)->exists();
                        if($is_exist){
                            $fail('Produk yang sama telah ditambahkan');
                        }else{
                            if($product->status_id != ProductStatus::SOLD){
                                $fail('Produk belum terjual');
                            }
                        }
                    }
                }
            ],
            'customer_id' => 'required',
            'date' => 'required',
            'nominal' => 'required|gt:0'
        ];
    }

    public function render() {
        return view('livewire.goods-receipt.toko.buyback.item.modal.create', [
            'product' => $this->product
        ]);
    }

    public function findProduct(){
        $this->reset('product');
        $this->validateOnly('code');
        $this->setProduct();
    }

    private function setProduct(){
        $this->product = Product::with('karat')->where(['product_code' => $this->code])->first();
    }

    public function store(){
        $this->validate();

        DB::beginTransaction();
        try{
            $data = [
                'product_id' => $this->product->id,
                'cabang_id' => auth()->user()->namacabang->cabang_id,
                'customer_id' => $this->customer_id,
                'pic_id' => auth()->id(),
                'nominal' => $this->nominal,
                'note' => empty($this->note)?null:$this->note,
                'date' => $this->date,
                'type' => 1
            ];

            $item = Toko\GoodsReceiptItem::create($data);
            $product = $item->product;
            $product->update([
                'cabang_id' => $item->cabang_id,
                'status_id' => ProductStatus::PENDING_CABANG
            ]);
            $product->statuses()->attach($product->status_id,['cabang_id' => $product->cabang_id, 'properties' => $item]);

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack(); 
            throw $e;
        }

        toast('Berhasil Menyimpan Barang Buy Back','success');
        return redirect(route('goodsreceipt.toko.index'));
        
    }

    public function updatedNominal($value){
        $this->nominal_text = 'Rp. ' . number_format(intval($value), 0, ',', '.');
    }

}
