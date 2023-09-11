           <div class="py-2">
            @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
           
        <div class="flex justify-between">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-4 gap-2">
       
            <div class="form-group">
                <?php
                        $field_name = 'inputs[0]karat_id';
                        $field_lable = __('Parameter Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                <select class="form-control" name="karat_id[]">
                    <option value="" selected disabled>Select Karat</option>
                    @foreach(\Modules\Karat\Models\Karat::all() as $row)
                    <option value="{{$row->id}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
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
                    $field_name = 'inputs[0]kategori_id';
                    $field_lable = __('Kategori');
                    $field_placeholder = Label_case($field_lable);
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
            <select class="form-control" name="kategori_id[]">
                <option value="" selected disabled>Select Category</option>
                @foreach(\Modules\KategoriProduk\Models\KategoriProduk::all() as $row)
                <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
                {{$row->name}} </option>
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
                    $field_name = 'inputs[0]berat_real';
                    $field_lable = label_case('Berat_real');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                 <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
               <input class="form-control"
               type="number"
                name="berat_real[]"
                id="{{ $field_name }}"
                min="0" step="0.001"
                placeholder="{{$field_lable}}">
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>


            <div class="form-group">
                    <?php
                    $field_name = 'inputs[0]berat_kotor';
                    $field_lable = label_case('Berat_kotor');
                    $field_placeholder = $field_lable;
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = 'wire:model="'.$field_name.'"';
                    ?>
                 <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
               <input class="form-control"
                type="number"
                name="berat_kotor[]"
                id="{{ $field_name }}"
                min="0" step="0.001"
                placeholder="{{$field_lable}}">
                    @if ($errors->has($field_name))
                    <span class="invalid feedback"role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small
                        class="text-danger">
                    </span>
                    @endif
                </div>


            </div>
            <div class="px-1 mt-4">
                <button class="btn text-white text-xl btn-info btn-md" wire:click.prevent="add({{$i}})" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i></span>
                <span wire:loading wire:target="add" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                </button>
            </div>
        </div>
        @foreach($inputs as $key => $value)
        <div class="flex justify-between mt-0">
            <div class="add-input w-full mx-auto flex flex-row grid grid-cols-4 gap-2">
       
             <div class="form-group">
                    <?php
                        $field_name = 'inputs['.$value.']karat_id';
                        $field_lable = __('Parameter Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                    <select class="form-control" name="karat_id[]">
                    <option value="" selected disabled>Select Karat</option>
                    @foreach(\Modules\Karat\Models\Karat::all() as $row)
                    <option value="{{$row->id}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
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
            $field_name = 'inputs['.$value.']kategori_id';
            $field_lable = __('Kategori');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'wire:model="'.$field_name.'"';
            ?>
   
    <select class="form-control" name="kategori_id[]">
        <option value="" selected disabled>Select Category</option>
        @foreach(\Modules\KategoriProduk\Models\KategoriProduk::all() as $row)
        <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
        {{$row->name}} </option>
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
                $field_name = 'inputs['.$value.']berat_real';
                $field_name = 'berat_real.'.$value.'';
                $field_lable = label_case('Berat_real');
                $field_placeholder = $field_lable;
                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                $required = '';
                ?>
               <input class="form-control" type="number"
                name="berat_real[]"
                id="{{ $field_name }}"
                min="0" step="0.001"
                wire:model={{ $field_name }}
                placeholder="{{$field_lable}}">
                 @if ($errors->has($field_name))
                <span class="invalid feedback"role="alert">
                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                    class="text-danger">
                </span>
                @endif
            </div>


      <div class="form-group">
                <?php
                //$field_name = 'inputs['.$value.']berat_kotor';
                $field_name = 'berat_kotor.'.$value.'';
                $field_lable = label_case('berat_kotor');
                $field_placeholder = $field_lable;
                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                $required = '';
                ?>
               <input class="form-control" type="number"
                name="berat_kotor[]"
                id="{{ $field_name }}"
                min="0" step="0.001"
                wire:model={{ $field_name }}
                placeholder="{{$field_lable}}">
                 @if ($errors->has($field_name))
                <span class="invalid feedback"role="alert">
                    <small class="text-danger">{{ $errors->first($field_name) }}.</small
                    class="text-danger">
                </span>
                @endif
            </div>

            </div>
              <div class="px-1">
                <button class="btn text-white text-xl btn-danger btn-xs" 
                wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                <span wire:loading wire:target="remove({{$key}})" class="text-center">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
                </button>
            </div>
        </div>


        @endforeach


{{-- <span class="text-xl text-blue-500">{{$total_qty}} </span> --}}

</div>

<div class="flex flex-row grid grid-cols-2 gap-2">

<div class="flex grid grid-cols-2 gap-2">


 <div class="form-group">
        <?php
        $field_name = 'total_emas';
        $field_lable = label_case('total_emas');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}
            <span class="text-danger small"> (yg harus dibayar)</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
         min="0" step="0.001"
       
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
           @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
    </div>
<div class="form-group">
    <label class="mb-0" for="tipe_pembayaran">Tipe Pembayaran <span class="text-danger">*</span></label>
    <select  class="form-control" name="tipe_pembayaran" id="tipe_pembayaran">
        <option value="cicil">Cicil</option>
        <option value="jatuh_tempo">Jatuh Tempo</option>
        <option value="lunas">Lunas</option>
    </select>
</div>   

</div>

 


<div id="cicilan" class="form-group">
    <label class="mb-0" for="status">Cicil <span class="text-danger">*</span></label>
    <select class="form-control select2" name="cicilan" id="cicilan">
        <option value="1">1 kali</option>
        <option value="2">2 kali </option>
    </select>
</div>



  <div id="tgl_jatuh_tempo" class="form-group d-none">
            <?php
            $field_name = 'tgl_jatuh_tempo';
            $field_lable = __('Tanggal');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
            <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
            <input type="date" name="{{ $field_name }}"
            class="form-control {{ $invalid }}"
            name="{{ $field_name }}"
            value="{{ old($field_name) }}"
            placeholder="{{ $field_placeholder }}" {{ $required }}>
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>



</div>


<div class="flex flex-row grid grid-cols-3 gap-2">
    
 <div class="form-group">
        <?php
        $field_name = 'total_berat_kotor';
        $field_lable = label_case('total_berat_kotor');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>


 <div class="form-group">
        <?php
        $field_name = 'berat_timbangan';
        $field_lable = label_case('berat_timbangan');
        $field_placeholder = 0;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>


 <div class="form-group">
        <?php
        $field_name = 'selisih';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger small">(Gram)</span></label>
        <input class="form-control numeric"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="0">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>






</div>
@push('page_scripts')


@endpush