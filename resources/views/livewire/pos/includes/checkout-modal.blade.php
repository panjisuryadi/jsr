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

             <?php
                $result = array (
                'total_with_shipping' => $total_with_shipping,
                'qty' => $jumlah ?? 0,
                'total_amount' => $total_amount ?? 0,
                );
               ?>
{{-- <livewire:pos.payment> --}}
              
 <form id="checkout-form" action="{{ route('app.pos.store') }}" method="POST">
          
                @csrf
                <div class="modal-body py-0 px-3 ">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                           
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
                                    <label for="grand_total">Kembali <span class="text-danger">*</span></label>
                                    <span class="text-red-800" id="hasil"></span>
                                    <input id="grand_total" type="text" class="form-control" name="grand_total" value="{{ $total_amount }}" readonly>
                                </div>




                                <div class="form-group">
                                    <label for="note">Catatan (Jika diperlukan)</label>
                                    <textarea name="note" id="note" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
     
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            {{-- batas --}}
                            <div class="px-3 py-3 sm:p-6 border border-2 mt-3 mb-3 shadow rounded rounde-xl ">
                                <div class="flex flex-col items-start justify-between mb-6">
                                    <span class="text-sm font-medium text-gray-600">Nama</span>
                                    <span class="text-lg font-medium text-gray-800">
                                    {!! settings()->company_name !!}</span>
                                </div>
                                <div class="flex flex-col items-start justify-between mb-6">
                                    <span class="text-sm font-medium text-gray-600">No Rekening</span>
                                    <span class="text-lg font-medium text-gray-800">003003999333</span>
                                </div>
                                
                                <div class="flex flex-row items-center justify-between">
                                    <div class="flex flex-col items-start">
                                        <span class="text-sm font-medium text-gray-600">Qty</span>
                                        <span class="text-lg font-medium text-gray-800">{{ Cart::instance($cart_instance)->count() }}</span>
                                    </div>
                                    <div class="flex flex-col items-start">
                                        <span class="text-sm font-medium text-gray-600">Total</span>
                                        @php
                                        $total_with_shipping = Cart::instance($cart_instance)->total() + (float) $shipping
                                        @endphp
                                        <span class="text-lg font-medium text-gray-800">{{ format_currency($total_with_shipping) }}</span>
                                    </div>
                                </div>
                            </div>
                            {{-- batas --}}
                        </div>
                        <div class="tab-pane fade" id="qr" role="tabpanel" aria-labelledby="qr-tab">
                            <div class="flex  flex-row justify-center">
                                <div class="justify-center items-center px-2 py-3 rounded-lg">
                                    <div class="justify-center text-center items-center">
                                        {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG('tess','QRCODE', 12, 12) !!}
                                    </div>
                                    <div class="py-2 justify-center text-center items-center font-semibold uppercase text-gray-600 no-underline text-lg hover:text-red-600 leading-tight">
                                        {{ $customer_id }}
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tunai" role="tabpanel" aria-labelledby="tunai-tab">
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
                    </div>
                    <ul class="nav nav-tabs text-md py-0 justify-center" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="bi bi-wallet"></i>&nbsp;TUNAI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="bi bi-cash-coin"></i>&nbsp;Transfer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="qr-tab" data-toggle="tab" href="#qr" role="tab" aria-controls="qr" aria-selected="false">
                            <i class="bi bi-upc-scan"></i>&nbsp;QR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tunai-tab" data-toggle="tab" href="#tunai" role="tab" aria-controls="tunai" aria-selected="false"><i class="bi bi bi-credit-card"></i>&nbsp;EDC</a>
                        </li>
                        
                    </ul>
                </div>
                <div id="ModalFooter" class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="px-5 btn bg-red-400 text-white">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('page_scripts')

<script>
        $(document).ready(function () {
           $('#paid_amount').keyup(function() {
               var bayar = $('#paid_amount').maskMoney('unmasked')[0];
               var harga = $("#total_amount").maskMoney('unmasked')[0];

                if (isNaN(harga) || isNaN(bayar)) {
                    alert("Harga dan Jumlah harus diisi dengan angka.");
                    return;
                }

                var total = bayar - harga;
                 if(bayar>=harga){
                      $("#grand_total").val(total.toFixed(2));
                      $("#kembalian").val(kembalian.toFixed(2));
                    }else{
                        $("#grand_total").val(total.toFixed(2));

                    }

                
            });
        });
    </script>



@endpush