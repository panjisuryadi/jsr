<form wire:submit.prevent="store">
    @csrf

    <div class="flex flex-row grid grid-cols-4 mb-0 gap-4">

        <div class="form-group">
            <?php
            $field_name = 'parent_karat_id';
            $field_lable = __('Karat Induk');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                {{ $field_lable }}</label>
            <select class="form-control" name="{{ $field_name }}" wire:change="setCode" wire:model="{{ $field_name }}">
                <option value="" selected>Select Karat</option>
                @foreach($dataKarat as $karat)
                <option value="{{$karat->id}}">
                    {{$karat->name}} | {{$karat->kode}}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <?php
            $field_name = 'kode';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = "required";
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}" wire:ignore>
            <span class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </span>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>

        <div class="form-group">
            <?php
            $field_name = 'kategori_karat';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = "required";
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}" readonly wire:ignore>
            <span class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </span>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>


        <div class="form-group">
            <?php
            $field_name = 'kadar';
            $field_lable = label_case('Kadar');
            $field_placeholder = $field_lable;
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = "required";
            ?>
            <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" placeholder="{{ $field_placeholder }}" wire:model="{{ $field_name }}">
            <span class="invalid feedback" role="alert">
                <span class="text-danger error-text {{ $field_name }}_err"></span>
            </span>
            @if ($errors->has($field_name))
            <span class="invalid feedback" role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
            </span>
            @endif
        </div>




    </div>
    <div class="pt-2 border-t flex justify-between">
        <div></div>
        <div class="form-group">
            <a class="px-5 btn btn-outline-danger" href="{{ route("karat.index") }}">
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
@push('page_scripts')
<script type="text/javascript">
    let kode = document.getElementById('kode');
    let kategori_karat = document.getElementById('kategori_karat');
    window.addEventListener('parentChange', (e) => {
        if (e.detail.isParentSelected) {
            kode.setAttribute('readonly', true);
            kategori_karat.removeAttribute('readonly');
        } else {
            kode.removeAttribute('readonly');
            kategori_karat.setAttribute('readonly',true);
        }
    });
</script>



@endpush