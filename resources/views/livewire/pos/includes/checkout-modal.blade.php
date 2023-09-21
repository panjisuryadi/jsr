<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-semibold text-lg" id="checkoutModalLabel">
                    <i class="bi bi-cart-check text-primary"></i>
                    Konfirmasi Pembayaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="checkout-form" action="{{ route('app.pos.store') }}" method="POST">
                @csrf
                <div class="modal-body py-0 px-4">


 <div class="tab-content" id="myTabContent">
 <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">

 <ul class="flex flex-col bg-white p-1">


  @foreach(\Modules\DataBank\Models\DataBank::get() as $row)
         <li class="border-gray-200 flex flex-row mb-2">
          <div class="select-none cursor-pointer bg-gray-10 flex flex-1 items-center p-2  transition duration-500 ease-in-out transform hover:-translate-y-1 hover:shadow-lg border-top">
            <div class="flex flex-col rounded-md w-14 h-14 bg-white justify-center items-center mr-2">
                @if($row->kode_bank == '002')
                  <img src="{{asset('images/icon/bri.png')}}">
                @elseif($row->kode_bank == '003')
                  <img src="{{asset('images/icon/mandiri.png')}}">
                @else
                 <img src="{{asset('images/icon/bri.png')}}">
                @endif
                </div>
            <div class="flex-1 pl-1 mr-16">
         <div class="text-gray-600 font-medium text-lg font-semibold">
            {{$row->nama_bank}}</div>
              <div class="text-gray-400 text-sm">
                {{$row->kode_bank}}</div>
            </div>
            <div class="text-gray-600 text-xs">{{$row->no_akun}}</div>
          </div>
        </li>
       @endforeach
  
    </ul>
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
