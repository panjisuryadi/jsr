<div class="flex flex-row grid grid-cols-3 gap-2">
<div class="form-group">
<?php
$field_name = 'jenis_mutiara_id';
$field_lable = label_case($field_name);
$field_placeholder = $field_lable;
$invalid = $errors->has($field_name) ? ' is-invalid' : '';
$required = "required";
?>
<label class="mt-1" for="jenis_mutiara_id">Jenis Mutiara </label>
<select class="form-control" data-placeholder="Pilih Mutiara" tabindex="1" name="{{ $field_name }}" id="{{ $field_name }}">
  
     @foreach(\Modules\JenisMutiara\Models\JenisMutiara::all() as $row)
        <option value="{{$row->id}}">
        {{$row->name}}</option>
        @endforeach
</select>
</div>

<div class="form-group">
   <label class="mt-1" for="kategori_mutiara_id">Kategori Mutiara </label>
    <select class="form-control" name="kategori_mutiara_id" id="kategori_mutiara_id" required>
        <option value="" selected disabled>Select Kategori Mutiara</option>
        
    </select>
</div>




    <div class="form-group">
        <label for="berat_emas">@lang('Berat') <span class="text-danger">*</span></label>
        <input min="0" step="0.01" id="berat_emas" type="number" class="form-control" name="berat_emas" required value="{{ old('berat_emas') }}">
    </div>



</div>




    <script type='text/javascript'>
    $(document).ready(function(){

      //  Change
        $('#jenis_mutiara_id').change(function(){
             var id = $(this).val();
             //alert(id);
             $('#kategori_mutiara_id').find('option').not(':first').remove();
             // AJAX request 
             $.ajax({
                 url: base_url + '/kategorimutiara/getid/'+id,
                 type: 'get',
                 dataType: 'json',
                 success: function(response){
                     var len = 0;
                     if(response['data'] != null){
                          len = response['data'].length;
                     }
                     if(len > 0){
                          for(var i=0; i<len; i++){
                               var id = response['data'][i].id;
                               var name = response['data'][i].name;
                               var option = "<option value='"+id+"'>"+name+"</option>";
                               $("#kategori_mutiara_id").append(option); 
                          }
                     }

                 }
             });
        });
    });
    </script>