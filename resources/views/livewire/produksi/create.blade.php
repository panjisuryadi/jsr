<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <form wire:submit.prevent="submit" enctype="multipart/form-data">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="addModalLabel">Create Produksi</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="flex flex-row grid grid-cols-2 gap-2">
                                    @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                    @endif
                                    <div class="col-span-3 px-2">
                                        Form Sumber
                                        <hr>
                                        <div class="flex flex-row grid grid-cols-3 gap-1 mt-2">
                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'source_kode';
                                                    $field_lable = label_case('Sumber');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = "required";
                                                ?>
                                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <select class="form-control" name="{{ $field_name }}" wire:model = {{ $field_name }} id="source_kode">
                                                    <option value="lantakan" {{ $source_kode == 'lantakan'? 'selected' : '' }}> Lantakan </option>
                                                    <option value="rongsok" {{ $source_kode == 'rongsok' ? 'selected' : '' }} disabled> Rongsok </option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group" id="karatasal_id">
                                                <?php
                                                    $field_name = 'karatasal_id';
                                                    $field_lable = __('Karat Asal');
                                                    $field_placeholder = Label_case($field_lable);
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                ?>
                                                <label for="{{ $field_name }}">{{ $field_lable }} <span class="text-danger">*</span></label>
                                                <select class="form-control" name="{{ $field_name }}" wire:model="{{ $field_name }}" >
                                                    <option value="" {{ ($source_kode =! 'lantakan') ? 'selected' : '' }} >Select Karat</option>
                                                    @foreach($dataKarat as $row)
                                                        <option value="{{$row->id}}" {{ old('karatasal_id') == $row->id ? 'selected' : '' }}>
                                                            {{$row->name}} | {{$row->kode}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'berat_asal';
                                                    $field_lable = label_case('Berat Asal');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = "required";
                                                ?>
                                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control"
                                                    type="number"
                                                    name="{{ $field_name }}"
                                                    id="{{ $field_name }}"
                                                    wire:model = "{{ $field_name }}"
                                                    placeholder="{{ $field_placeholder }}">
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

                                        From Hasil
                                        <hr>
                                        <div class="flex flex-row grid grid-cols-3 gap-1 mt-2">
                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'model_id';
                                                    $field_lable = label_case('Model Jadi');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = "required";
                                                ?>
                                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger"></span></label>
                                                <select class="form-control" name="{{ $field_name }}" wire:model="{{ $field_name }}" >
                                                    <option value="" selected >Select Model</option>
                                                    @foreach($dataGroup as $row)
                                                        <option value="{{$row->id}}" {{ old('model_id') == $row->id ? 'selected' : '' }}>
                                                            {{$row->name}}
                                                        </option>
                                                    @endforeach
                                                        <option value="0" {{ old('model_id') == 0 ? 'selected' : '' }}>
                                                            Other
                                                        </option>
                                                </select>
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>
                                            
                                            <div class="form-group" id="karat_id">
                                                <?php
                                                    $field_name = 'karat_id';
                                                    $field_lable = __('Karat Hasil');
                                                    $field_placeholder = Label_case($field_lable);
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = '';
                                                ?>
                                                <label for="{{ $field_name }}">{{ $field_lable }} <span class="text-danger">*</span></label>
                                                <select class="form-control" name="{{ $field_name }}" wire:model="{{ $field_name }}" >
                                                    <option value="" selected >Select Karat</option>
                                                    @foreach($dataKarat as $row)
                                                        <option value="{{$row->id}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
                                                            {{$row->name}} | {{$row->kode}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <?php
                                                    $field_name = 'berat';
                                                    $field_lable = label_case('Berat Jadi');
                                                    $field_placeholder = $field_lable;
                                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                    $required = "required";
                                                ?>
                                                <label for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
                                                <input class="form-control"
                                                    type="number"
                                                    name="{{ $field_name }}"
                                                    id="{{ $field_name }}"
                                                    wire:model = "{{ $field_name }}"
                                                    placeholder="{{ $field_placeholder }}">
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
                                                    $field_name = 'kategoriproduk_id';
                                                    $field_lable = __('Pilih Tipe');
                                                    $field_placeholder = Label_case($field_lable);
                                                    $required = '';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                <select class="form-control" name="{{ $field_name }}" wire:model = {{ $field_name }} id="type">
                                                    <option value="" selected >Select Tipe</option>
                                                    @foreach($dataKategoriProduk as $row)
                                                        <option value="{{$row->id}}" {{ old('kategoriproduk_id') == $row->id ? 'selected' : '' }}
                                                            {{ $row->id != $id_kategoriproduk_berlian ? 'disabled' : '' }}>
                                                            {{$row->name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <?php
                                                $field_name = 'tanggal';
                                                $field_lable = __('Tanggal');
                                                $field_placeholder = Label_case($field_lable);
                                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                $required = '';
                                                ?>
                                                <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                                <input id="{{ $field_name }}" type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" wire:model="{{ $field_name }}" value="{{ $hari_ini }}" placeholder="{{ $field_placeholder }}" {{ $required }} max="{{ $hari_ini }}">
                                                @if ($errors->has($field_name))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                </span>
                                                @endif
                                            </div>

                                        </div>
                                        
                                        @if($kategoriproduk_id == $id_kategoriproduk_berlian)
                                        <div class="py-2" id="berlianitem">
                                            Detail Berlian
                                            <hr class="mb-2">
                                            @foreach($inputs as $key => $value)
                                            <div class="flex justify-between mt-0">
                                                <div class="add-input w-full mx-auto flex flex-row grid grid-cols-4 gap-2">

                                                    <div class="form-group">
                                                        <?php
                                                            $field_name = 'inputs.' . $key . '.karatberlians_id';
                                                            $field_lable = __('Karat Berlian');
                                                            $field_placeholder = Label_case($field_lable);
                                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                            $required = '';
                                                        ?>
                                                        @if ($key==0)
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        @endif
                                                        <select class="form-control" name="{{ $field_name }}" wire:model="{{ $field_name }}">
                                                            <option value="" selected >Select Karat</option>
                                                            @foreach($dataKaratBerlian as $row)
                                                            <option value="{{$row->id}}">
                                                                {{$row->karat}} ct
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'inputs.' . $key . '.shapeberlian_id';
                                                        $field_lable = __('Shape');
                                                        $field_placeholder = Label_case($field_lable);
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        @if ($key==0)
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        @endif
                                                        <select class="form-control" name="{{ $field_name }}" wire:model="{{ $field_name }}">
                                                            <option value="" selected>Select Shape</option>
                                                            @foreach($dataShapes as $row)
                                                                <option value="{{$row->id}}" {{ old($field_name) == $row->id ? 'selected' : '' }}>
                                                                    {{$row->shape_name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'inputs.' . $key . '.qty';
                                                        $field_lable = 'Qty';
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        @if ($key==0)
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        @endif
                                                        <input class="form-control" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}">
                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'inputs.' . $key . '.keterangan';
                                                        $field_lable = "Keterangan";
                                                        $field_placeholder = $field_lable;
                                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                                        $required = '';
                                                        ?>
                                                        @if ($key==0)
                                                        <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                                        @endif
                                                        <input class="form-control" type="text" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{$field_lable}}">

                                                        @if ($errors->has($field_name))
                                                        <span class="invalid feedback" role="alert">
                                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                                        </span>
                                                        @endif
                                                    </div>

                                                </div>
                                                @if ($key == 0)
                                                <div class="px-1 mt-4">
                                                    <button class="btn text-white text-xl btn-info btn-md" wire:click.prevent="addInput()" wire:loading.attr="disabled">
                                                        <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i></span>
                                                        <span wire:loading wire:target="add" class="text-center">
                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                                @else
                                                <div class="px-1">
                                                    <button class="btn text-white text-xl btn-danger btn-md" wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                                                        <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                                                        <span wire:loading wire:target="remove({{$key}})" class="text-center">
                                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif

                                    <div class="grid grid-cols-3 gap-3">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" >Simpan</button>
            </div>
        </div>
    </form>
    </div>
</div>
@push('page_scripts')

<script>

</script>
@endpush
