<div class="px-3">
  <x-library.alert />
<form id="FormEdit" action="#" method="POST">
    @csrf
    @method('patch')

<div class="grid grid-cols-2 gap-2 m-2">
    
    <div class="px-2">
        
        <table class="table tabel-bordelles mb-0">
             <tr>
                <th>Cabang</th>
                <td>{{ $product->cabang->code }} | {{ $product->cabang->name }}</td>
            </tr>
            <tr>
                <th>Product Code</th>
                <td>{{ $product->product_code }}</td>
            </tr>
            <tr>
                <th>Barcode Symbology</th>
                <td>{{ $product->product_barcode_symbology }}</td>
            </tr> 

            
            <tr>
                <th>Name</th>
                <td>{{ $product->product_name }}</td>
            </tr>
            <tr>
                <th>Category</th>
                <td>{{ $product->category->category_name }}</td>
            </tr>

              <tr>
                <th>Karat / Harga (Gram)</th>
                <td>{{ number_format(@$product->product_item[0]->karat->PenentuanHarga->harga_emas) }}</td>
            </tr>
            
      
            
            
            <tr>
                <th>Note</th>
                <td>{{ $product->product_note ?? 'N/A' }}</td>
            </tr>
        </table>

    </div>
    <div class="px-2">
        
        <div class="justify-center text-center items-center">
            {{-- {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG($product->product_code,'QRCODE', 12, 12) !!} --}}



<!-- component -->
<div class="w-full  mx-auto relative py-0">
 
      <div class="border-l-2 mt-2">
        <!-- Card 1 -->
        <div class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-2 bg-gray-600 text-white rounded mb-3 flex-col md:flex-row space-y-4 md:space-y-0">
          <!-- Dot Follwing the Left Vertical Line -->
          <div class="w-5 h-5 bg-gray-600 absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>
          <div class="w-10 h-1 bg-gray-300 absolute -left-10 z-0"></div>
           <div class="flex justify-between gap-3">
            <div class="justify-start">Keterangan</div>
            <div class="justify-end">Tanggal</div>
          </div>
         
        </div>

  <div class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-2 bg-yellow-600 text-white rounded mb-3 flex-col md:flex-row space-y-4 md:space-y-0">
          <!-- Dot Follwing the Left Vertical Line -->
          <div class="w-5 h-5 bg-yellow-600 absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>
          <div class="w-10 h-1 bg-yellow-300 absolute -left-10 z-0"></div>
           <div class="flex justify-between gap-3">
            <div class="justify-start">Keterangan</div>
            <div class="justify-end">Tanggal</div>
          </div>
         
        </div>



      </div>
   
    </div>



        </div>

   <div class="form-group mt-5">
            <?php
            $field_name = 'status';
            $field_lable = label_case('Status');
            $field_placeholder = $field_lable;
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = "required";
            ?>
            <label class="mb-0" for="{{ $field_name }}">@lang('Status') <span class="text-danger">*</span></label>
            <select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" required>
                <option value="" selected disabled>@lang('Status')</option>
                <option value="3">Approved</option>
                <option value="4">Reject</option>
            </select>
            <div class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </div>
        </div>
    
    <div class="form-group mb-2">
            <label class="mb-0" for="status">@lang('Note') <span class="text-danger">(Optional)</span></label>
            <textarea name="note" id="note" rows="2" class="form-control"></textarea>
        </div>










    </div>
</div>



</form>
</div>
<script>
jQuery.noConflict();
(function( $ ) {

 function autoRefresh(){
      // var table = $('#datatable').DataTable();
      //   table.ajax.reload();
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
    Tombol += "<button type='button' class='px-5 btn btn-success' id='SimpanUpdate'>{{ __('Approve') }}</button>";
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