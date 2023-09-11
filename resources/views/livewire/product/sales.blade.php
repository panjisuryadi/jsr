  <div>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <form wire:submit.prevent="store">
        @csrf

   <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">

        </div>
  {{--       <div class="text-gray-700">
            <div class="font-bold text-xl mb-2">INVOICE</div>
            <div class="text-sm">Tanggal: 01/05/2023</div>
            <div class="text-sm">Kepada #: INV12345</div>
        </div>
 --}}


  <div class="w-2/4">
        <div class="mb-2 md:mb-1 md:flex items-center">
          <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Invoice No.</label>
          <span class="mr-4 inline-block hidden md:block">:</span>
          <div class="flex-1">
           <input wire:model="sales.invoice" type="text" name="invoice" id="first_name"   placeholder="eg. #INV-100001" class="form-control @error('sales.invoice') is-invalid @enderror">
                    @error('sales.invoice')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
          </div>

        </div>

        <div class="mb-2 md:mb-1 md:flex items-center">
          <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide"> Date</label>
          <span class="mr-4 inline-block hidden md:block">:</span>
          <div class="flex-1">
          <input wire:model="sales.date" type="date" name="invoice" id="date"  
             class="form-control @error('sales.date') is-invalid @enderror">
                    @error('sales.date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
          </div>
        </div>

        <div class="mb-2 md:mb-1 md:flex items-center">
          <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Kepada</label>
          <span class="mr-4 inline-block hidden md:block">:</span>
          <div class="flex-1">
         <select  class="form-control select2" 
              name="sales_id" wire:model="sales.sales_id">
                
                  @foreach(\Modules\DataSale\Models\DataSale::all() as $row)
                  <option value="{{$row->id}}" {{ old('sales_id') == $row->id ? 'selected' : '' }}>
                  {{$row->name}} </option>
                  @endforeach
              </select>
          </div>
        </div>
      </div>

    </div>





        <div class="flex justify-between mb-3">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">


<div class="form-group">
    <?php
         
            $field_name = 'karat_id.0';
            $field_lable = __('Parameter Karat');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'wire:model="'.$field_name.'"';
            ?>
       <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}<span class="text-danger">*</span></label>
    <select  class="form-control form-control-sm" 
    name="{{ $field_name }}"
    wire:change="pilihPo(0,$event.target.value)">
        <option value="" selected disabled>Select Karat</option>
        @foreach(\Modules\Karat\Models\Karat::all() as $row)
        <option value="{{$row->kode}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
        {{$row->name}} | {{$row->kode}} </option>
        @endforeach
    </select>
      @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
</div>



             <div class="form-group">
                    <?php
                    $field_name = 'code.0';
                    $field_lable = label_case('code');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                     <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}<span class="text-danger">*</span></label>

           {{-- <span class="text-blue-400 text-4xl">{{$pilih_po[0] ?? null}}</span> --}}
                    {{ html()->text($field_name)->value($pilih_po[0] ?? null)
                    ->class('form-control form-control-sm '.$invalid.'')->placeholder($field_lable) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>  


                


           <div class="form-group">
                    <?php
                    $field_name = 'berat_kotor.0';
                    $field_lable = label_case('berat_kotor');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                     <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}<span class="text-danger">*</span></label>

                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["$required"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>


             <div class="form-group">
                    <?php
                    $field_name = 'berat_bersih.0';
                    $field_lable = label_case('berat_bersih');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                     <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}<span class="text-danger">*</span></label>

                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["$required"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>

 <div class="form-group">
                    <?php
                    $field_name = 'harga.0';
                    $field_lable = label_case('harga (%)');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                     <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}</label>

                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["step=0.01", "onkeyup" => "shouldBeNumeric(this)"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>



 <div class="form-group">
                    <?php
                    $field_name = 'jumlah.0';
                    $field_lable = label_case('jumlah');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                     <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                      {{ $field_lable }}<span class="text-danger">*</span></label>

                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["$required"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>


           


            </div>
            <div class="px-1 pt-4">
                <button class="btn text-white text-3xl btn-info btn-sm" wire:click.prevent="add({{$i}})" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i></span>
                <span wire:loading wire:target="add" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                </button>
            </div>
        </div>




{{-- /////loppppp --}}


        @foreach($inputs as $key => $value)
        <div class="flex justify-between mb-3">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">


          <div class="form-group">
            <?php
            
            $field_name = 'karat_id.'.$value.'';
            $field_lable = __('Parameter Karat');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'wire:model="'.$field_name.'"';
            ?>
              <select class="form-control form-control-sm" 
                 wire:change="pilihPo('{{ $value }}',$event.target.value)">
                 name="{{ $field_name }}">
                <option value="" selected disabled>Select Karat</option>
                @foreach(\Modules\Karat\Models\Karat::all() as $row)
                <option value="{{$row->kode}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
                {{$row->name}} | {{$row->kode}} </option>
                @endforeach
              </select>
              @if ($errors->has($field_name))
              <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
              </span>
              @endif
            </div>


     <div class="form-group">
                    <?php
                   
                    $field_name = 'code.'.$value.'';
                    $field_lable = label_case('code');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                   
               {{ html()->text($field_name)->value($pilih_po[$value] ?? null)
                    ->class('form-control form-control-sm '.$invalid.'')->placeholder($field_lable) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>  



                     

                <div class="form-group">
                    <?php
                 
                    $field_name = 'berat_kotor.'.$value.'';
                    $field_lable = label_case('berat_kotor');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'step="0.001" wire:model="'.$field_name.'"';
                    ?>
                 
                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["$required"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>  


                <div class="form-group">
                    <?php
                 
                    $field_name = 'berat_bersih.'.$value.'';
                    $field_lable = label_case('berat_bersih');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'step="0.001" wire:model="'.$field_name.'"';
                    ?>
                  
                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["$required"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>  

                <div class="form-group">
                    <?php
                 
                    $field_name = 'harga.'.$value.'';
                    $field_lable = label_case('harga (%)');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                   
                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["step=0.01", "onkeyup" => "shouldBeNumeric(this)"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>  

                <div class="form-group">
                    <?php
                 
                    $field_name = 'jumlah.'.$value.'';
                    $field_lable = label_case('jumlah');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'step="0.001" wire:model="'.$field_name.'"';
                    ?>
                   
                    {{ html()->number($field_name)->placeholder($field_placeholder)
                        ->value(old($field_name))
                    ->class('form-control form-control-sm '.$invalid.'')->attributes(["$required"]) }}
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>  



            </div>
            <div class="px-1 pt-1">
                <button class="btn text-white text-xl btn-danger btn-sm" wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                <span wire:loading wire:target="remove({{$key}})" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                </button>
            </div>
        </div>
        @endforeach





 <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">

        </div>
  <div class="w-2/7">
        <div class="mb-2 md:mb-1 md:flex items-center">
          <label class="w-16 text-gray-700 block text-sm tracking-wide">Jumlah.</label>
          <span class="mr-4 inline-block hidden md:block">:</span>
          <div class="flex-1">
          <input class="form-control form-control-sm"  type="text" placeholder="0">
          </div>
        </div>
   <div class="mb-2 md:mb-1 md:flex items-center">
          <label class="w-16 text-gray-700 block text-sm tracking-wide">Diskon.</label>
          <span class="mr-4 inline-block hidden md:block">:</span>
          <div class="flex-1">
          <input class="form-control form-control-sm"  type="text" placeholder="0">
          </div>
        </div>
   <div class="mb-2 md:mb-1 md:flex items-center">
          <label class="w-16 text-gray-700 block text-sm tracking-wide">Total.</label>
          <span class="mr-4 inline-block hidden md:block">:</span>
          <div class="flex-1">
          <input class="form-control form-control-sm"  type="text" placeholder="0">
          </div>
        </div>


      </div>

    </div>




<div class="flex items-center justify-between mb-8">
        <div class="flex items-center">

        </div>
  <div class="w-2/6">

    <div class="flex flex-row gap-2">
       <div class="form-group">
            <label class="mb-0 text-gray-700">PIC</label>
              <select wire:model="sales.user_id" class="form-control" name="user_id" id="user_id" required>
           
                @foreach($kasir as $jp)
                <option value="{{ $jp->id }}">{{ $jp->name }}</option>
                @endforeach
              </select>
                @error('sales.user_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
            </div>
       <div class="mb-2 items-center text-gray-700">

            <div class="form-group">
            <label class="mb-0 text-gray-700">Sales</label>
            <input wire:model="sales.nama_sales" type="text" name="Nama_sales" id="nama_sales" placeholder="Ketik Nama Sales" class="form-control @error('sales.nama_sales') is-invalid @enderror">
                    @error('sales.nama_sales')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>





            </div>
        </div>
     </div>

      </div>

    </div>




        <div class="pt-2 border-t flex justify-between">
            <div></div>
            <div class="form-group">
                <a class="px-5 btn btn-outline-danger"
                    href="{{ route("goodsreceipt.index") }}">
                @lang('Cancel')</a>
 <button class="px-5 btn  btn-submit btn-outline-success" wire:click.prevent="store" wire:target="store" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="store">
                    >@lang('Save')
                </span>
                <span wire:loading wire:target="store" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </span>
                </button>
            </div>
        </div>



    </form>
</div>


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

document.querySelectorAll('input[type-currency="PERSEN"]').forEach((element) => {
  element.addEventListener('keyup', function(e) {
    let cursorPostion = this.selectionStart;
    let value = parseFloat(this.value.replace(/[^,\d]/g, ''));
    let originalLenght = this.value.length;
    if (isNaN(value)) {
      this.value = "";
    } else {
      this.value = (inputValue * 100).toFixed(2);
      cursorPostion = this.value.length - originalLenght + cursorPostion;
      this.setSelectionRange(cursorPostion, cursorPostion);
    }
  });
});


function shouldBeNumeric(e){
  if(isNaN(e.valueAsNumber)){
    e.value = ""
  }
}

</script>











@endpush