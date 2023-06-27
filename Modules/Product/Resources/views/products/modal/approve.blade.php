  <div class="px-3">
  <x-library.alert />
  <form id="FormEdit" action="{{ route('products.transfer.approvebarang', $detail) }}" method="POST">
                @csrf
                @method('patch')
<div class="flex flex-row grid grid-cols-1 gap-4">

	<div class="flex px-3 items-center py-2 rounded rounded-lg border border-gray-500">
		<img class="w-10 h-10 rounded-full mr-2" src="{{ auth()->user()->getFirstMediaUrl('avatars') }}" alt="Avatar of Writer">
		<div class="text-sm">
			<p class="text-gray-900 leading-none">{{ auth()->user()->name }}</p>
			<p class="text-gray-600 font-semibold">{{ auth()->user()->roles->pluck("name")->first(); }}</p>
		</div>
	</div>

	<div class="form-group">
		<label for="status">@lang('Status') <span class="text-danger">*</span></label>
		<select class="form-control" name="status" id="status" required>
			<option value="" selected disabled>@lang('Status')</option>
			<option value="3">Approved</option>
			<option value="4">Tolak</option>
		</select>
	</div>
</div>
            </form>


</div>

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
    Tombol += "<button type='button' class='px-5 btn btn-primary' id='SimpanUpdate'>{{ __('Approve') }}</button>";
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