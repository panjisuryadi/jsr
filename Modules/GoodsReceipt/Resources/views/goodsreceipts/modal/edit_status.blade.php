@php
    $dibayar = 0;
    $isCicil = ($data->tipe_pembayaran == 'cicil') ? true : false;
    if($data->tipe_pembayaran == 'cicil') {
        foreach ($data->detailCicilan as $key => $value) {
            $dibayar += $value->jumlah_cicilan;
        }
    }
    $total_harus_bayar = number_format($data->goodreceipt->total_emas, 2) - $dibayar;
@endphp
<div class="px-3">
    <x-library.alert />
    @if(!empty($total_harus_bayar) && $isCicil )
        <span class="text-dark"> Total emas yang harus dibayarkan </span> <span class="ml-1 text-danger"> {{  $total_harus_bayar }} </span>
    @endif


    <form id="FormEdit" action="{{ route(''.$module_name.'.update_status_pembelian' )}}" method="POST">
        @csrf
        @method('post')
        
        <div class="form-group">
            <input class="form-control" type="hidden" name="pembelian_id" id="" value="{{ $data->id }}">
        </div>
        @if($isCicil)
            <div class="flex flex-row grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="cicilan_id">@lang('Pilih Cicilan') <span class="text-danger">*</span></label>
                    <select class="form-control" name="cicilan_id" id="cicilan_id" required>
                        <option value="" selected disabled >Pilih Cicilan</option>
                        @foreach($data->detailCicilan as $item)
                            @if ( empty($item->jumlah_cicilan))
                                <option value="{{ $item->id }}">Cicilan ke - {{ $item->nomor_cicilan }} {{ date('d/m/y', strtotime($item->tanggal_cicilan)) }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <?php
                        $field_name = 'jumlah_cicilan';
                        $field_lable = label_case('Jumlah Cicilan');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = "required";
                    ?>
                    <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                    <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" value="" >
                    <span class="invalid feedback" role="alert">
                        <span class="text-danger error-text {{ $field_name }}_err"></span>
                    </span>
                </div>
                <div class="form-group">
                    <input class="form-control" type="hidden" name="is_cicilan" id="" value="1">
                    <input class="form-control" type="hidden" name="total_harus_bayar" id="" value="{{ $total_harus_bayar }}">
                </div>
            </div>
        @else
        <span class="text-dark"> Tanggal jatuh tempo {{ $data->jatuh_tempo }} <span class="ml-1 text-warning">23:59 .</span> <span class="text-danger"> Klik update untuk memproses. </span>

        <div class="flex flex-row grid grid-cols-2 gap-4">
            <div class="form-group">
                <input class="form-control" type="hidden" name="is_cicilan" id="" value="0">
                <input class="form-control" type="hidden" name="total_harus_bayar" id="" value="{{ $total_harus_bayar }}">
            </div>
        </div>
            
        @endif
    </form>


</div>
{{-- <script src="{{ asset('js/jquery-mask-money.js') }}"></script> --}}
<script>
jQuery.noConflict();
(function( $ ) {

function autoRefresh(){
    table.ajax.reload();
}

function Update()
{
    $.ajax({
        url: $('#FormEdit').attr('action'),
        type: "POST",
        cache: false,
        data: $('#FormEdit').serialize(),
        dataType:'json',
        success: function(data) {
                if($.isEmptyObject(data.error)){
                    $('#ResponseInput').html(data.success);
                    $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                    $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                    setTimeout(function(){ autoRefresh(); }, 1000);
                    setTimeout(function () {
                            $('#tombol_close').trigger('click');
                        }, 3000);

                }else{
                    printErrorMsg(data.error);
                }
            }
    });
}

function printErrorMsg (msg) {
    $.each( msg, function( key, value ) {
        $('#'+key+'').addClass("");
        $('#'+key+'').addClass("is-invalid");
        $('.'+key+'_err').text(value);

    });
}

$(document).ready(function(){

    var Tombol = "<button type='button' id='tombol_close' class='btn btn-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
    Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanUpdate'>{{ __('Update') }}</button>";
    $('#ModalFooter').html(Tombol);

    $("#FormEdit").find('input[type=text],textarea,select').filter(':visible:first').focus();

    $('#SimpanUpdate').click(function(e){
        e.preventDefault();
        Update();
    });

    $('#FormEdit').submit(function(e){
        e.preventDefault();
        Update();
    });

});
})(jQuery);
</script>