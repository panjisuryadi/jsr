<div class="grid grid-cols-2 gap-2">
    <div class="form-group">
        <label for="product_note">Kategori Emas</label>
        <select class="form-control select2" name="gold_kategori_id" id="gold_kategori_id" required>
            <option value="" selected disabled>Select Kategori</option>
            @foreach(\Modules\GoldCategory\Models\GoldCategory::all() as $sup)
            <option value="{{$sup->id}}" {{ old('gold_kategori_id') == $sup->id ? 'selected' : '' }}>
            {{$sup->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="karat_id">@lang('Karat') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="karat_id" id="karat_id" required>
            <option value="" selected disabled>Karat</option>
            @foreach(\Modules\Karat\Models\Karat::all() as $jp)
            <option value="{{ $jp->id }}">{{ $jp->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="flex relative py-1">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Berat <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Detail Berat Barang."></i>
        </span>
    </div>
</div>
<div class="flex flex-row grid grid-cols-2 gap-2">
    
    <div class="form-group">
        <?php
        $field_name = 'berat_emas';
        $field_lable = label_case('Berat');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.01"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
    <div class="form-group">
        <?php
        $field_name = 'berat_total';
        $field_lable = label_case('berat_total');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        min="0" value="0"
        required step="0.01"
        id="{{ $field_name }}"
        wire:model="inputBeratTotal"
        value="{{$berat_total}}"
        placeholder="{{ $field_placeholder }}">

        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
</div>



                      {{-- HARGA --}}

                            <div class="flex relative py-1">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">
                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">Harga</span>
                                    </div>
                                </div>


                             <div class="flex flex-row grid grid-cols-2 gap-2">
                                   
                                         <div class="form-group">
                                                <?php
                                                $field_name = 'harga_emas';
                                                $field_lable = label_case($field_name);
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="small text-danger">&nbsp;(Harga Emas Hari ini)</span></label>
                                                <input class="form-control"
                                                type="text"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                wire:model="inputHargaEmas"

                                                placeholder="{{ $field_placeholder }}"
                                                >
                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                            </div>



                                         <div class="form-group">
                                                <?php
                                                $field_name = 'product_cost';
                                                $field_lable = label_case('Biaya Produk');
                                                $field_placeholder =label_case('Harga Emas x Berat');
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}

                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control pc"
                                                type="text"
                                                name="product_cost_rp"
                                                id="{{ $field_name }}"
                                                value="{{ $productCost }}"
                                                placeholder="{{ $field_placeholder }}"
                                                >

                               <input type="hidden" name="{{ $field_name }}" value="{{ $price }}">

                                                <div class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </div>
                                            </div>
                            


                                    
                                   </div>





                           <div class="flex flex-row grid grid-cols-2 gap-2">
                                   
        

                                     <div class="form-group">
                                                <?php
                                                $field_name = 'margin';
                                                $field_lable = label_case($field_name);
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                             <div class="flex justify-between py-0 px-0">
                                               
                                                <div>
                                                     <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                </div>
                                 
                                <div class="py-0">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input margin" type="radio" name="margin" id="nominal" checked>
                                            <label class="form-check-label" for="nominal">Nominal</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input margin" type="radio" name="margin"
                                            id="persentase">
                                            <label class="form-check-label" for="persentase">Persentase</label>
                                        </div>
                                    </div>
                                 </div>

                                             <div id="m2" >
                                                <input class="form-control margin"
                                                type="number"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="Margin Nominal"
                                                >
                                                </div>

                                               <div id="m1" style="display: none !important;" >
                                                <input class="form-control margin"
                                                type="number"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="Persentase (%)"
                                                >
                                                </div>




                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                            </div>

                                        <div class="form-group">
                                                <?php
                                                $field_name = 'product_price';
                                                $field_lable = label_case('Harga Jual');
                                                $field_placeholder = $field_lable;
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = "required";
                                                ?>
                                                <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}
                                                    <span class="small text-danger">Product cost + margin</span>
                                                </label>
                                                <input class="form-control"
                                                type="text"
                                                name="{{ $field_name }}"
                                                id="{{ $field_name }}"
                                                value="{{old($field_name)}}"
                                                placeholder="{{ $field_placeholder }}"
                                                >

                                            <span id="grand_total" class="text-lg text-danger"></span>


                                                <span class="invalid feedback" role="alert">
                                                    <span class="text-danger error-text {{ $field_name }}_err"></span>
                                                </span>
                                            </div>
                                        
                                    
                                   </div>  
<div class="flex flex-row grid grid-cols-1 gap-2">

<div class="flex justify-end px-2 py-4">
  <div></div>

  <div>
  <div class="font-semibold text-gray-500 text-danger leading-5 text-xs">
    Total Biaya Produk: {{ $productCost }}
  </div>
  <div class="font-semibold text-gray-500 leading-5 text-danger text-xs">Grand Total: {{ $productCost }}</div>
  </div>
</div>


</div>

                           {{-- HARGA --}}
