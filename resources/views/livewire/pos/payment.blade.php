<div>
 
<?php
    $result = array (
    'total_with_shipping' => $total_with_shipping,
    'qty' => $jumlah ?? 0,
    'total_amount' => $total_amount ?? 0,
    );
?>

 <button class="hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center justify-items-center" 
    role="button" 
    data-toggle="modal" 
    data-target="#simpanModal{{$result['total_with_shipping']}}">
        <i class="hover:text-red-400 text-4xl text-gray-500 bi bi-box-arrow-down"></i>
         <div class="py-0 font-semibold">Simpan</div>
        
        </button>

<!-- Discount Modal -->
<div wire:ignore.self class="modal fade" id="simpanModal{{$result['total_with_shipping']}}" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="relative modal-title" id="discountModalLabel">
                    Save 
                   
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  method="POST">
     <div style="text-align:left !important;" class="modal-body items-baseline">
                   
            <div class="form-group">
                <label class="mb-0" style="text-align:left !important;" for="total_amount">Total <span class="text-danger">*</span></label>
                <input  wire:model="total_amount"  type="number" class="form-control" name="total_amount" value="{{$total_with_shipping}}" required>
            </div> 
                  
               <div class="form-group mt-4">
                    <label class="mb-0" style="text-align:left !important;"  for="total_amount">Bayar <span class="items-left text-danger">*</span></label>
                    <input  wire:model="bayar" id="bayar" type="number" class="form-control" name="bayar" value="{{$result['total_amount']}}" required>
                </div>


               <div class="form-group mt-4">
                    <label class="mb-0" style="text-align:left !important;"  
                    for="total_amount">Grand Total <span class="items-left text-danger">*</span></label>
                    <input id="total_amount" type="number" class="form-control" name="total_amount" value="{{$grandtotal ?? 0}}" readonly required>
                </div>

 

    <div class="form-group">
        <label for="note">Catatan (Jika diperlukan)</label>
        <textarea name="note" id="note" rows="3" class="form-control"></textarea>
    </div>





                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="px-5 btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
