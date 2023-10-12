<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-md" role="document">
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
                           
<div class="px-0 py-2 grid grid-cols-2 gap-4 m-2">
 

<input type="hidden" value="{{ $customer_id }}" name="customer_id">
    <input type="hidden" value="{{ $global_tax }}" name="tax_percentage">
    <input type="hidden" value="{{ $global_discount }}" name="discount_percentage">
    <input type="hidden" value="{{ $shipping }}" name="shipping_amount">
    <input type="hidden" value="Other" name="payment_method"> 

<div class="px-1">
<div class="form-group mt-0">
    <label for="total_amount">Total <span class="text-danger">*</span></label>
    <input id="total_amount" type="text" class="form-control" name="total_amount" value="{{ $total_amount }}" disabled required>
    <input type="hidden" id="harga" value="{{ $total_amount }}">


</div>


<div class="form-group">
    <label for="note">Catatan (Jika diperlukan)</label>
    <textarea name="note" id="note" rows="2" class="form-control"></textarea>
</div>



<div class="form-group">
    <label for="discount">Discount  <span class="small text-danger">(Nominal)</span></label>
    <input  id="discount" type="text" class="form-control" name="discount">
    <input type="hidden" id="diskon2">
</div>




</div>


<div class="px-1">

<label for="tunaiRadio">Tunai</label>
<input type="radio" name="tipebayar" id="tunaiRadio" value="tunai" checked required>

<label for="cicilRadio">Cicilan</label>
<input type="radio" name="tipebayar" id="cicilRadio" value="cicil">

<div id="Tunai" class="px-0">
   <div class="form-group">
    <label for="tunai">Bayar Tunai<span class="text-danger">*</span></label>
    <input id="input_tunai" type="text" class="form-control" name="tunai">
    <div style="display: none;" id="kembalian-info">Kembali: <span class="text-blue-500 text-xl" id="kembalian">0</span></div>
</div>
</div>

<div id="cicilan" style="display: none;">
   <div class="form-group">
    <label for="ciclan">Bayar Cicilan<span class="text-danger">*</span></label>
    <input id="input_cicilan" type="text" class="form-control" name="cicilan">
     <div style="display: none;" id="kembalian-cicil">Kembali: <span class="text-green-500 text-xl" id="kembalian2">0</span></div>
</div>

 <div class="form-group">
    <label for="ciclan">Jatuh Tempo<span class="text-danger">*</span></label>
    <input id="tgl_jatuh_tempo" type="date" class="form-control" name="tgl_jatuh_tempo">

</div>

</div>

<div class="form-group">
    <label for="note">Grand Total</label> <span class="text-danger small" id="message"></span>
    {{-- <span id="final" class="text-black text-4xl"></span> --}}
    <input id="final" type="text" class="form-control text-black text-2xl" name="final" value="{{ $total_amount }}" disabled>  


    <input value="{{ $total_amount }}" id="final_unmask" type="hidden" class="form-control" name="final_unmask">
</div>




</div>



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


@push('page_css')
<style type="text/css">
    label {
    display: inline-block;
    margin-bottom: 0.2rem;
}
</style>
@endpush
@push('page_scripts')

<script>

$(document).ready(function() {
      $("input[type='radio'][name='tipebayar']").change(function () {
        if ($("input[name='tipebayar']:checked").val() === "cicil") {
            //alert('cicilan');
           $("#Tunai").hide();
            $("#cicilan").show();
        } else {
            //alert('tunai');
             $("#cicilan").hide();
             $("#Tunai").show();

        }
    });
 });
$(document).ready(function() {
    $("#input_tunai").on('keyup', function() {
        let input_tunai = $(this).val();
        let harga = $("#final_unmask").val();
        var bayar = input_tunai.replace(/[^\d]/g, '');
        if (bayar > harga) {
          var kembalian = bayar - harga;
          var kembaliRp = formatRupiah(kembalian);
          $('#kembalian').text(kembaliRp);
          $('#kembalian-info').show();
        }

            console.log(kembaliRp);
         });

      });


$(document).ready(function() {
    $("#input_cicilan").on('keyup', function() {
        let input_tunai = $(this).val();
        let harga = $("#harga").val();
        var bayar = input_tunai.replace(/[^\d]/g, '');
        $("#final_unmask").append().val(bayar);
        if (bayar > harga) {
          var kembalian = bayar - harga;
          var kembaliRp = formatRupiah(kembalian);
          $('#kembalian2').text(kembaliRp);
          $('#kembalian-cicil').show();
        }

            console.log(kembaliRp);
         });

      });


   $(document).ready(function() {

    $("#discount").on('keyup', function() {
        var discount = $(this).val();
        var harga_awal = $("#harga").val();
         var diskon_value = discount.replace(/[^\d]/g, '');
         var result = harga_awal - diskon_value;
         var final = formatRupiah(result);
        $("#final").append().val(final);
         $("#final_unmask").append().val(result);
        console.log(diskon_value);
         // if (diskon_value >= harga_awal) {
         //           $("#message").text("Diskon tidak boleh melebihi Harga");
         //            $("#discount").val("0");
         //              } else {
         //           $("#message").text("");
         //            $("#final").append().val(result);
         //            $("#final_unmask").append().val(result);
         //            console.log(diskon_value);
         //        }


         });

      });




      function formatRupiah(number) {
        var rupiah = Number(number).toString();
        var parts = rupiah.split(".");
        var integerPart = parts[0];
        var decimalPart = parts.length > 1 ? parts[1] : "";
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        rupiah = "Rp " + integerPart + "." + decimalPart;
        return rupiah;
      }


    </script>


@endpush