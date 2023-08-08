


<div id="emas_form" class="grid grid-cols-2 gap-2">
    <div class="form-group">
        <label for="product_note">Kategori Emas</label>
        <select class="form-control select2" name="gold_kategori_id" id="gold_kategori_id" required>
            <option value="" selected disabled>Select Kategori Emas</option>
            @foreach(\Modules\GoldCategory\Models\GoldCategory::all() as $sup)
            <option value="{{$sup->id}}" {{ old('gold_kategori_id') == $sup->id ? 'selected' : '' }}>
            {{$sup->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="karat_id">@lang('Karat Emas') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="karat_id" id="karat_id" required>
            <option value="" selected disabled>Karat</option>
            @foreach(\Modules\Karat\Models\Karat::all() as $jp)
            <option value="{{ $jp->id }}">{{ $jp->name }}</option>
            @endforeach
        </select>
    </div>
</div>


<div id="lm_form" class="grid grid-cols-2 gap-2 d-none">
 
<div class="form-group">
    <label for="certificate_id">@lang('Certificate') <span class="text-danger">*</span></label>
    <select class="form-control select2" name="certificate_id" id="certificate_id" required>
        <option value="" selected disabled>Select Certificate</option>
        @foreach(\Modules\DiamondCertificate\Models\DiamondCertificate::all() as $certificate)
        <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="no_certificate">@lang('No .Certificate') <span class="text-danger">*</span></label>
    <input id="no_certificate" type="text" class="form-control" name="no_certificate" required value="{{ old('no_certificate') }}">
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
        min="0" step="0.01"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text {{ $field_name }}_err"></span>
        </span>
    </div>
    
</div>



