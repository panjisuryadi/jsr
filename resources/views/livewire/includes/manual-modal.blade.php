<!-- Button trigger Discount Modal -->
  <button 
    role="button" 
    data-toggle="modal" 
    data-target="#manualModal"
    class="flex flex-row hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center">
   <i class="hover:text-red-400 text-2xl text-gray-500 bi bi-pencil-square"></i>
  <div class="mb-1 ml-1 lg:text-sm md:text-sm text-xl py-0 font-semibold">Manual</div>
</button>


<!-- manual Modal -->
<div wire:ignore.self class="modal fade" id="manualModal" tabindex="-1" role="dialog" aria-labelledby="manualModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-lg modal-title" id="manualModalLabel">
                    <strong>Manual </strong>
                    
                </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
            <div class="modal-body justify-start">
                      
        <div class="form-group text-left">
            <label class="text-left" for="nominal">Nominal <span class="text-danger">*</span>
            </label>
            <input id="nominal" type="text" class="form-control" name="nominal" value="{{ $total_amount }}" required>
        </div>





                 <table class="table table-striped table-sm">
                                    <tr>
                                        <th>Total Products</th>
                                        <td>
                                                <span class="inline-flex items-center justify-center w-6 h-6 ml-2 text-xs font-semibold text-white bg-green-500 rounded-full">
                                                    {{ Cart::instance($cart_instance)->count() }}
                                                </span>
                                        </td>
                                    </tr>
                          
                                    <tr class="text-blue-700">
                                        <th>Grand Total</th>
                                        @php
                                            $total_with_shipping = Cart::instance($cart_instance)->total() + (float) $shipping
                                        @endphp
                                        <th>
                                            (=) {{ format_currency($total_with_shipping) }}
                                        </th>
                                    </tr>
                                </table>
             </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn text-white bg-red-400">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
