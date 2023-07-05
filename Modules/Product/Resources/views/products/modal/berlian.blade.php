
<style type="text/css">
    .form-group {
    margin-bottom: 0.3rem !important;
}
</style>

<div class="flex py-0 flex-row grid grid-cols-3 gap-2">

    <div class="form-group">
        <label for="karat_id">@lang('Jenis Perhiasan') <span class="text-danger">*</span></label>
         <select class="form-control select2" name="jenis_perhiasan_id" id="jenis_perhiasan_id" required>
            <option value="" selected disabled>Jenis Perhiasan</option>
            @foreach(\Modules\JenisPerhiasan\Models\JenisPerhiasan::all() as $jp)
            <option value="{{ $jp->id }}">{{ $jp->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="round_id">@lang('Clarity') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="round_id" id="round_id" required>
            <option value="" selected disabled>Select Clarity</option>
            @foreach(\Modules\ItemClarity\Models\ItemClarity::all() as $cl)
            <option value="{{ $cl->id }}">{{ $cl->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        <label for="shape_id">@lang('Cut / Shape') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="shape_id" id="shape_id" required>
            <option value="" selected disabled>Select Cut /  Shape</option>
            @foreach(\Modules\ItemShape\Models\ItemShape::all() as $shape)
            <option value="{{ $shape->id }}">{{ $shape->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="colour_id">@lang('Colour') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="colour_id" id="colour_id" required>
            <option value="" selected disabled>Select Colour</option>
            @foreach(\Modules\ItemColour\Models\ItemColour::all() as $color)
            <option value="{{ $color->id }}">{{ $color->name }}</option>
            @endforeach
        </select>
    </div>
  <div class="form-group">
        <label for="baki_id">@lang('Baki') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="baki_id" id="baki_id" required>
            <option value="" selected disabled>Select Baki</option>
            @foreach(\Modules\Baki\Models\Baki::all() as $baki)
            <option value="{{ $baki->id }}">{{ $baki->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        <label for="certificate_id">@lang('Certificate') <span class="text-danger">*</span></label>
        <select class="form-control select2" name="certificate_id" id="certificate_id" required>
            <option value="" selected disabled>Select Certificate</option>
            @foreach(\Modules\DiamondCertificate\Models\DiamondCertificate::all() as $certificate)
            <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
            @endforeach
        </select>
    </div>



</div>


<div class="flex py-0 flex-row grid grid-cols-2 gap-2">
    <div class="form-group">
        <label for="no_certificate">@lang('No .Certificate') <span class="text-danger">*</span></label>
        <input id="no_certificate" type="text" class="form-control" name="no_certificate" required value="{{ old('no_certificate') }}">
    </div>

     <div class="form-group">
        <label for="no_certificate">@lang('Karat Berlian') <span class="text-danger">*</span></label>
          <select class="form-control select2" name="karat_berlian_id" id="karat_berlian_id" required>
            <option value="" selected disabled>Pilih Karat</option>
            @foreach(\Modules\KaratBerlian\Models\KaratBerlian::all() as $karat)
            <option value="{{ $karat->id }}">{{ $karat->name }}</option>
            @endforeach
        </select>
    </div>
    </div>