<div>
    <div class="flex justify-between py-1 border-bottom">
        
        <div class="form-group mb-0 w-1/4">
            <label class="mb-0" for="karat_id">@lang('Karat') <span class="text-danger">*</span></label>
            <select class="form-control select2" 
            wire.model="karat_id" 
            wire:change="pilihKarat($event.target.value)" 
            name="karat_id" id="karat_id" required>
                @foreach(\Modules\Karat\Models\Karat::all() as $jp)
                <option value="{{ $jp->id }}">{{ $jp->name }} | {{ $jp->kode }}</option>
                @endforeach
            </select>
        </div>
        
        <div id="buttons">
        </div>
    </div>
   

<table class="table table-striped">
    <thead>
        <tr>
         
            <th style="width: 10%;" class="text-left">Karat</th>
            <th class="text-left">Harga Emas</th>
            <th class="text-left">Harga Modal</th>
            <th class="text-left">Margin</th>
            <th class="text-left">Harga Jual</th>
        </tr>
    </thead>
    <tbody>
        <tr>

            <td style="width: 15%;" class="text-center">
                 <input type="hidden" 
                       name="karat_id" 
                       value="{{$karat_id}}" 
                       wire.model="karat_id" 
                       >
                <input type="text" class="form-control text-center" 
                name="karat" value="{{$kode_karat}}">
            </td>
            <td style="width: 24%;" class="text-left">
               
       <div class="form-group">
        <?php
        $field_name = 'harga_emas';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <input class="form-control"
        type="number"
        wire:model="harga_emas"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        

        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    



            </td>
            <td  style="width: 20%;" class="text-left">
           
  <div class="form-group">
        <?php
        $field_name = 'harga_modal';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        wire:model="harga_modal"
        wire:change="recalculateTotal"
        wire:keyup="recalculateTotal"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>


            </td>


          <td  style="width: 20%;" class="text-left">
       <div class="form-group">
        <?php
        $field_name = 'harga_margin';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        wire:model="harga_margin"
        wire:change="recalculateTotal"
        wire:keyup="recalculateTotal"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>


            </td>



           <td  style="width: 23%;" class="text-left">
                <input 
                type="text" 
                value="{{$HargaFinalRp}}" 
                class="form-control" 
                 readonly>  

                 <input 
                type="hidden" 
                wire.model="harga_jual" 
                value="{{$HargaFinal}}" 
                class="form-control" 
                name="harga_jual">


            </td>
       
        </tr>
      
    </tbody>
</table>









@push('page_scripts')
<script type="text/javascript">

document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
  element.addEventListener('keyup', function(e) {
    let cursorPostion = this.selectionStart;
    let value = parseInt(this.value.replace(/[^,\d]/g, ''));
    let originalLenght = this.value.length;
    if (isNaN(value)) {
      this.value = "";
    } else {
      this.value = value.toLocaleString('id-ID', {
        currency: 'IDR',
        style: 'currency',
        minimumFractionDigits: 0
      });
      cursorPostion = this.value.length - originalLenght + cursorPostion;
      this.setSelectionRange(cursorPostion, cursorPostion);
    }
  });
});

</script>

@endpush
















</div>