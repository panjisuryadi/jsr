  <div class="px-3">
  <x-library.alert />
  <form id="FormEdit" action="{{ route(''.$module_name.'.update', $detail) }}" method="POST">
                            @csrf
                            @method('patch')
             <div class="flex flex-row grid grid-cols-3 gap-4">
                                    <div class="form-group">
                <label for="group_id">@lang('Jenis Group') <span class="text-danger">*</span></label>
                <select class="form-control" name="group_id" id="group_id" required>
                    <option value="" selected disabled>@lang('Select Kode Group')</option>
                    @foreach(\Modules\Group\Models\Group::all() as $jg)

                     <option {{ $jg->id == $detail->group_id ? 'selected' : '' }} value="{{ $jg->id }}">{{ $jg->code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <?php
                $field_name = 'harga';
                $field_lable = label_case('harga');
                $field_placeholder = $field_lable;
                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                $required = "required";
                ?>
                <label for="{{ $field_name }}">
                    {{ $field_lable }} &nbsp;<small class="text-danger">Gram</small>
                </label>
                <input class="form-control"
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                value="{{ $detail->harga }}"
                placeholder="{{ $field_placeholder }}">
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
            </div>
            <div class="form-group">
                <?php
                $field_name = 'harga_modal';
                $field_lable = label_case('harga_modal');
                $field_placeholder = $field_lable;
                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                $required = "required";
                ?>
                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                <input class="form-control"
                type="text"
                name="{{ $field_name }}"
                id="{{ $field_name }}"
                value="{{ $detail->harga_modal }}"
                placeholder="{{ $field_placeholder }}">
                <span class="invalid feedback" role="alert">
                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                </span>
            </div>




    {{--  <div class="form-group">
                                        <label for="kategori_produk_id">Main Category <span class="text-danger">*</span></label>
                                        <select class="form-control" name="kategori_produk_id" id="kategori_produk_id" required>
                                            @foreach(\Modules\KategoriProduk\Models\KategoriProduk::all() as $main)
                                                <option {{ $main->id == $category->kategori_produk_id ? 'selected' : '' }} value="{{ $main->id }}">{{ $main->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>--}}










                    </div>

            </form>


</div>
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>
<script>
jQuery.noConflict();
(function( $ ) {

 function autoRefresh(){
      var table = $('#datatable').DataTable();
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
                  console.log(data.error)
                    if($.isEmptyObject(data.error)){
                      $('#ResponseInput').html(data.success);
                      $("#sukses").removeClass('d-none').fadeIn('fast').show().delay(3000).fadeOut('slow');
                      $("#ResponseInput").fadeIn('fast').show().delay(3000).fadeOut('slow');
                      setTimeout(function(){ autoRefresh(); }, 1000);
                      setTimeout(function () {
                              $('#ModalGue').modal('hide');
                            }, 3000);

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
     $('#harga_modal').maskMoney({
                prefix: 'Rp ',
                thousands: '.',
                decimal: ',',
                precision: 0
              });
     $('#harga').maskMoney({
                prefix: 'Rp ',
                thousands: '.',
                decimal: ',',
                precision: 0
              });

});
})(jQuery);
</script>