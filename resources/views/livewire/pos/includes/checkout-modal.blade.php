<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">
                    <i class="bi bi-cart-check text-primary"></i> Confirm Sale
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="checkout-form" action="{{ route('app.pos.store') }}" method="POST">
                @csrf
                <div class="modal-body py-0 px-4">
{{--     
<table class="table table-striped">
    <tr>
        <th>Total Products</th>
        <td>
            <span class="badge badge-success">
                {{ Cart::instance($cart_instance)->count() }}
            </span>
        </td>
    </tr>
    
    
    <tr class="text-primary">
        <th>Grand Total</th>
        @php
        $total_with_shipping = Cart::instance($cart_instance)->total() + (float) $shipping
        @endphp
        <th>
            (=) {{ format_currency($total_with_shipping) }}
        </th>
    </tr>
</table> --}}

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                aaaaa
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                xxxxx
            </div>

             <div class="tab-pane fade" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                Qr code
            </div>
             <div class="tab-pane fade" id="tunai" role="tabpanel" aria-labelledby="tunai-tab">
                      <input type="hidden" value="{{ $customer_id }}" name="customer_id">
                            <input type="hidden" value="{{ $global_tax }}" name="tax_percentage">
                            <input type="hidden" value="{{ $global_discount }}" name="discount_percentage">
                            <input type="hidden" value="{{ $shipping }}" name="shipping_amount">

                    <input type="hidden" value="Other" name="payment_method">

                                  <div class="form-group mt-4">
                                        <label for="total_amount">Total <span class="text-danger">*</span></label>
                                        <input id="total_amount" type="text" class="form-control" name="total_amount" value="{{ $total_amount }}" readonly required>
                                    </div>

                                <div class="form-group">
                                        <label for="paid_amount">Bayar <span class="text-danger">*</span></label>
                                        <input id="paid_amount" type="text" class="form-control" name="paid_amount" value="{{ $total_amount }}" required>
                                    </div> 
                  

                            <div class="form-group">
                                <label for="note">Catatan (Jika diperlukan)</label>
                                <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                            </div>


            </div>
        </div>



        <ul class="nav nav-tabs text-md py-0 justify-center" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="bi bi-credit-card"></i>&nbsp;EDC</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="bi bi-cash-coin"></i>&nbsp;Transfer</a>
            </li> 

            <li class="nav-item">
                <a class="nav-link" id="qr-tab" data-toggle="tab" href="#qr" role="tab" aria-controls="qr" aria-selected="false">
                  <i class="bi bi-upc-scan"></i>&nbsp;QR</a>
            </li> 

            <li class="nav-item">
                <a class="nav-link" id="tunai-tab" data-toggle="tab" href="#tunai" role="tab" aria-controls="tunai" aria-selected="false"><i class="bi bi-currency-exchange"></i>&nbsp;TUNAI</a>
            </li>
           
        </ul>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="px-5 btn bg-red-400 text-white">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
