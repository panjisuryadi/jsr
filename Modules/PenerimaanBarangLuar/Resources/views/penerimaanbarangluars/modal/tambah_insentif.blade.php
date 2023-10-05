  <div class="px-3">
  <x-library.alert />
  <form id="FormTambah" action="{{ route("$module_name.store") }}" method="POST" enctype="multipart/form-data">
                @csrf

<div class="px-2 py-2">
    
<table style="width:100%;" class="table table-borderlees">
  <tbody>
    <tr>
     
      <td class="w-50">
       <label class="px-1 font-semibold text-lg uppercase text-gray-600">Bulan </label>
      </td>
      <td class="w-50">
            <div class="form-group">
                                <?php
                                $field_name = 'code';
                                $field_lable = label_case('Code');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                             
                        <input class="form-control"
                         type="text"
                         name="{{ $field_name }}"
                         id="{{ $field_name }}"
                         placeholder="{{ $field_placeholder }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>
      </td>
     
    </tr>

<tr>
    <td class="w-50">
        <label class="px-1 font-semibold text-lg uppercase text-gray-600">
        Angkatan </label>
    </td>
    <td class="w-50">
        <div class="form-group">
            Angkatan
        </div>
    </td>
</tr>


<tr>
    <td class="w-50">
        <label class="px-1 font-semibold text-lg uppercase text-gray-600">
        Hitungan Office </label>
    </td>
    <td class="w-50">
        <div class="form-group">
             Hitungan Office
        </div>
    </td>
</tr>



<tr>
    <td class="w-50">
        <label class="px-1 font-semibold text-lg uppercase text-gray-600">
       Selisih </label>
    </td>
    <td class="w-50">
        <div class="form-group">
            Selisih
        </div>
    </td>
</tr>

<tr>
    <td class="w-50">
        <label class="px-1 font-semibold text-lg uppercase text-gray-600">
       Persentase </label>
    </td>
    <td class="w-50">
        <div class="form-group">
            Persentase
        </div>
    </td>
</tr>



<tr>
    <td class="w-50">
        <label class="px-1 font-semibold text-lg uppercase text-gray-600">
       Nilai insentif </label>
    </td>
    <td class="w-50">
        <div class="form-group">
            Nilai insentif
        </div>
    </td>
</tr>









 
  </tbody>
</table>




</div>


            </form>


</div>

{{-- <script src="{{ asset('js/jquery-mask-money.js') }}"></script> --}}
<script>
jQuery.noConflict();
(function( $ ) {

 function autoRefresh(){
      var table = $('#datatable').DataTable();
        table.ajax.reload();

}
    function Tambah()
    {
        $.ajax({
            url: $('#FormTambah').attr('action'),
            type: "POST",
            cache: false,
            data: $('#FormTambah').serialize(),
            dataType:'json',

            success: function(data) {
                  console.log(data.error)
                    if($.isEmptyObject(data.error)){
                      $('#ResponseInput').html(data.success);
                      $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                      $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                      setTimeout(function(){ autoRefresh(); }, 1000);
                      $('#FormTambah').each(function(){
                        this.reset();

                    });

                 }else{
                        printErrorMsg(data.error);
                    }
                }
        });
    }

 function printErrorMsg (msg) {
            $.each( msg, function( key, value ) {
            console.log(key);
             $('#'+key+'').addClass("");
             $('#'+key+'').addClass("is-invalid");
              $('.'+key+'_err').text(value);

            });
        }

$(document).ready(function(){
    var Tombol = "<button type='button' class='btn btn-danger px-5' data-dismiss='modal'>{{ __('Close') }}</button>";
    Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanTambah'>{{ __('Create') }}</button>";
    $('#ModalFooter').html(Tombol);

    $("#FormTambah").find('input[type=text],textarea,select').filter(':visible:first').focus();

    $('#SimpanTambah').click(function(e){
        e.preventDefault();
        Tambah();
    });

    $('#FormTambah').submit(function(e){
        e.preventDefault();
        Tambah();
    });

 // $('#potongan_harga').maskMoney({
 //            prefix: 'Rp ',
 //            thousands: '.',
 //            decimal: ',',
 //            precision: 0
 //          });




});
})(jQuery);
</script>