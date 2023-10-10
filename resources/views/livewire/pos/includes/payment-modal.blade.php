<!-- Insert Modal -->
<div wire:ignore.self class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Create </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                wire:click="closeModal"></button>
            </div>
            <div class="px-0 py-1 grid grid-cols-3 gap-4 m-2 mt-0 mb-2 text-center no-underline">
                <button class="btn btn-outline-primary"
                wire:click="togglePanel"
                wire:loading.attr="disabled">Tunai
                
                </button>
                <button class="btn btn-outline-success"
                wire:click="btnTransfer"
                wire:loading.attr="disabled">Transfer
                
                </button>
                <button class="btn btn-outline-warning"
                wire:click="btnEdc"
                wire:loading.attr="disabled">EDC
                
                </button>
            </div>
            <div class="text-center justify-center" wire:loading.delay wire:target="togglePanel">
                <div class="spinner-border load-spinner text-tertiary p-0 me-2"></div>
            </div>
            <div class="text-center justify-center" wire:loading.delay wire:target="btnTransfer">
                <div class="spinner-border load-spinner text-tertiary p-0 me-2"></div>
            </div>
            @if($showPanel)
            <div class="px-0 py-0 grid grid-cols-2 gap-4 m-2">
                
                <input type="hidden" value="{{ $customer_id }}" name="customer_id">
                <input type="hidden" value="{{ $global_tax }}" name="tax_percentage">
                <input type="hidden" value="{{ $global_discount }}" name="discount_percentage">
                <input type="hidden" value="{{ $shipping }}" name="shipping_amount">
                <input type="hidden" value="Other" name="payment_method">
                <div class="px-1">
                    <div class="form-group mt-0">
                        <label for="total_amount">Total <span class="text-danger">*</span></label>
                        <input 
                        id="total_amount" 
                        type="text" 
                        wire:model="total_amount"
                        class="form-control" name="total_amount" value="{{ $total_amount }}" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="paid_amount">Bayar <span class="text-danger">*</span></label>
                        <input id="paid_amount" 
                        type="text" 
                        class="form-control" 
                        name="paid_amount"
                        wire:model="paid_amount"
                        value="{{ $total_amount }}" required>
                    </div>
                    <div class="form-group">
                        <label for="discount">Discount  <span class="small text-danger">(Nominal)</span></label>
                        <input id="discount" type="text" class="form-control" name="discount" required>
                    </div>
                </div>
                <div class="px-1">
                    <div class="form-group">
                        <label for="grand_total">Kembali <span class="text-danger">*</span></label>
                        <span class="text-red-800 text-2xl" id="kembalian"></span>
                        <input id="grand_total" type="text" class="form-control" name="grand_total" readonly>
                    </div>
                    <div class="form-group">
                        <label for="note">Grand Total</label>
                        {{-- <span id="final" class="text-black text-4xl"></span> --}}
                        <input id="final" type="text" class="form-control text-black text-2xl" name="final" readonly>
                        <input id="final_unmask" type="hidden" class="form-control" name="final_unmask" readonly>
                    </div>
                    <div class="form-group">
                        <label for="note">Catatan (Jika diperlukan)</label>
                        <textarea name="note" id="note" rows="2" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            @endif
            @if($showTransfer)
                <div>fdfdfdfd</div>
            @endif
            @if($showEdc)
                <div>ini edc</div>
            @endif
            <div id="ModalFooter" class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="px-5 btn bg-red-400 text-white">Submit</button>
            </div>
        </div>
    </div>
</div>
@push('page_scripts')
@endpush