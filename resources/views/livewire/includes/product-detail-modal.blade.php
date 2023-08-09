<!-- Button trigger Modal -->
<span role="button" class="badge badge-warning pointer-event" data-toggle="modal" data-target="#detailProduk{{ $cart_item->id }}">
    <i class="bi bi-search text-white"></i>
</span>
<!--  Modal -->
<div wire:ignore.self class="modal fade" id="detailProduk{{ $cart_item->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="discountModalLabel">
                    {{ $cart_item->name }}
                    
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <div class="modal-body px-3 py-2" id="ModalContentDetail">
               
              {{ $cart_item->name }}
                <span class="badge badge-success">
                        {{ $cart_item->options->rfid }}
                    </span>

           </div>
           <div class="modal-footer" id="ModalFooterDetail">
               
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="submit" class="btn btn-primary">Save changes</button> --}}


           </div>
        </div>
    </div>
</div>
