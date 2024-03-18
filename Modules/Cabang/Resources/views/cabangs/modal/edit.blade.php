  <div class="px-3">
  <x-library.alert />
  <form id="FormEdit" action="{{ route(''.$module_name.'.update', $detail) }}" method="POST">
                            @csrf
                            @method('patch')
             <div class="flex flex-row grid grid-cols-2 gap-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'code';
                                $field_lable = label_case('Code');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input class="form-control" type="text"
                        name="{{ $field_name }}"
                        id="{{ $field_name }}"
                        value="{{$detail->code }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>

                       <div class="form-group">
                                <?php
                                $field_name = 'name';
                                $field_lable = label_case('Nama Cabang');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input class="form-control" type="text"
                        name="{{ $field_name }}"
                        id="{{ $field_name }}"
                        value="{{$detail->name }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>



                       <div class="form-group">
                                <?php
                                $field_name = 'tlp';
                                $field_lable = label_case('Telepon');
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                        <input class="form-control" type="text"
                        name="{{ $field_name }}"
                        id="{{ $field_name }}"
                        value="{{$detail->tlp }}">
                                <span class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </span>

                            </div>





                   <div class="form-group">
                                <?php
                                $field_name = 'alamat';
                                $field_lable = label_case($field_name);
                                $field_placeholder = $field_lable;
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                          <textarea 
                            name="{{ $field_name }}"
                            id="{{ $field_name }}" 
                            rows="3"
                            class="form-control leading-6">
                              {{$detail->alamat }}

                          </textarea>

                                <div class="invalid feedback" role="alert">
                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                </div>
                               



                            </div>



                    </div>

            </form>


</div>

<style type="text/css">
    .tox-tinymce-aux {
    z-index: 999999!important;
}
</style>

<script src="https://cdn.tiny.cloud/1/n0943rljxkk8c3osevfgp51frcuh0pctgt6ehui823nuip4o/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#alamat',
    skin: 'bootstrap',
    plugins: 'lists, link',
    toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | removeformat help',
    menubar: false,
  });
</script>


{{-- <script src="{{ asset('js/jquery-mask-money.js') }}"></script> --}}
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
                     // setTimeout(function(){ autoRefresh(); }, 1000);

                      setTimeout(function () {
                              $('#ModalGue').modal('hide');
                            }, 3000);
                      setTimeout(() => window.location.reload(), 1000);

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
     // $('#potongan_harga').maskMoney({
     //            prefix: 'Rp ',
     //            thousands: '.',
     //            decimal: ',',
     //            precision: 0
     //          });

});

// $(document).on('focusin', function(e) {
//   if ($(e.target).closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
//     e.stopImmediatePropagation();
//   }
// });




})(jQuery);
</script>



