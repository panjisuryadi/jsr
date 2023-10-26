<form wire:submit.prevent="submit" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex relative py-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Goods Receipts')}} <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Goods Receipts')}}"></i>
                            </span>
                        </div>
                        <a class="flex" href="{{ route('goodsreceipt.index') }}">
                            <div class="absolute bottom-7 right-0 flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
                                <i class="bi bi-house text-gray-600"></i>
                            </div>
                        </a>
                    </div>

                    <div class="flex flex-row grid grid-cols-4 gap-2">
                        <div class="px-0 py-2">
                            <div class="form-group">
                                <div class="py-1">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="upload" id="up2" checked>
                                        <label class="form-check-label" for="up2">Upload</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="upload" id="up1">
                                        <label class="form-check-label" for="up1">Webcam</label>
                                    </div>
                                </div>
                                <div id="upload2" style="display: none !important;" class="align-items-center justify-content-center" wire:ignore>
                                    @livewire('goods-receipt-berlian.webcam', ['image' => isset($detail->images) ? $detail->images : ''])
                                </div>
                                <div id="upload1" wire:ignore>
                                    <div class="form-group">

                                        <div class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                            <div class="dz-message" data-dz-message>
                                                <i class="bi bi-cloud-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                        @endif
                        <div class="col-span-3 px-2">
                            <div class="flex flex-row grid grid-cols-3 gap-1">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'code';
                                    $field_lable = __('no_penerimaan_barang');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = 'readonly';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                    <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{ $field_placeholder }}" {{ $required }}>
                                    <input type="hidden" value="2" class="form-control" name="kategoriproduk_id" wire:model="kategoriproduk_id" >
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <?php
                                        $field_name = 'type';
                                        $field_lable = __('Pilih Tipe');
                                        $field_placeholder = Label_case($field_lable);
                                        $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <select class="form-control" name="{{ $field_name }}" wire:model = {{ $field_name }} wire:ignoe id="type">

                                        <option value="1" {{ $type == 1 ? 'selected' : '' }}> Berlian </option>
                                        <option value="2" {{ $type == 2 ? 'selected' : '' }}> Perhiasan </option>

                                    </select>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                                
                                @if ($type == 2) 
                                <div class="form-group" id="karat_id">
                                    <?php
                                        $field_name = 'karat_id';
                                        $field_lable = __('Kadar Emas');
                                        $field_placeholder = Label_case($field_lable);
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }} <span class="text-danger">*</span></label>
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
                                @endif
                                

                                <div class="form-group">
                                    <?php
                                    $field_name = 'nama_produk';
                                    $field_lable = __('Nama Barang');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }} <span class="text-danger">*</span></label>
                                    <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{ $field_placeholder }}" {{ $required }}>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <?php
                                    $field_name = 'supplier_id';
                                    $field_lable = __('Supplier');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">Supplier<span class="text-danger">*</span></label>
                                    <select class="form-control" name="{{ $field_name }}" wire:model="{{$field_name}}">
                                        <option value="" selected disabled>Select Supplier</option>
                                        @foreach($dataSupplier as $row)
                                        <option value="{{$row->id}}" {{ old('supplier_id') == $row->id ? 'selected' : '' }}>
                                            {{$row->supplier_name}}
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
                                    $field_name = 'no_invoice';
                                    $field_lable = __('No Surat Jalan / Invoice');
                                    $field_placeholder = Label_case($field_lable);
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = '';
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                    <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{ $field_placeholder }}" {{ $required }}>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <?php
                                    $field_name = 'tanggal';
                                    $field_lable = __('Tanggal Terima');
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
                            
                            @if($type == 2)
                            <div class="py-2" id="berlianitem">
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
                                                <option value="{{$row->id}}" {{ old('karat_id') == $row->id ? 'selected' : '' }}>
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

                            @if($type == 1)
                            <div class="grid grid-cols-4 gap-2" id="komponenberlian">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'total_karat';
                                    $field_lable = label_case('total_karat');
                                    $field_placeholder = 0;
                                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                    $required = "required";
                                    ?>
                                    <label class="mb-0" for="{{ $field_name }}">{{ $field_lable }}
                                        <span class="text-danger small"> (yg harus dibayar)</span></label>
                                    <input class="form-control numeric" type="number" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" placeholder="{{ $field_placeholder }}" $required>
                                    @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                        {{-- ///batas --}}

                        <div class="form-group">
                            <?php
                            $field_name = 'catatan';
                            $field_lable = __('Catatan');
                            $field_placeholder = Label_case($field_lable);
                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                            $required = '';
                            ?>
                            <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                            <textarea name="{{ $field_name }}" placeholder="{{ $field_placeholder }}" rows="5" id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}" wire:model="{{ $field_name }}"></textarea>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div class="form-group">
                                <?php
                                $field_name = 'tipe_pembayaran';
                                $field_lable = label_case('tipe_pembayaran');
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = "required";
                                ?>
                                <label class="mb-0" for="{{ $field_name }}">Tipe Pembayaran <span class="text-danger">*</span></label>
                                <select class="form-control" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                    <option value="" selected disabled>Pilih {{ $field_lable }}</option>
                                    <option value="cicil">Cicil</option>
                                    <option value="jatuh_tempo">Jatuh Tempo</option>
                                    <option value="lunas">Lunas</option>
                                </select>
                                @if ($errors->has($field_name))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                </span>
                                @endif
                            </div>

                            @if ($this->tipe_pembayaran == 'cicil')
                            <div id="cicilan" class="form-group">
                                <?php
                                $field_name = 'cicil';
                                $field_lable = __('cicil');
                                $field_placeholder = Label_case($field_lable);
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                $required = '';
                                ?>
                                <label class="mb-0" for="{{ $field_name }}"> {{ $field_placeholder }} <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                                    <option value="" selected disabled>Jumlah {{ $field_name }}an</option>
                                    <option value="2">2 kali</option>
                                    <option value="3">3 kali </option>
                                </select>
                                @if ($errors->has($field_name))
                                    <span class="invalid feedback" role="alert">
                                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                    </span>
                                @endif
                            </div>
                            @elseif ($this->tipe_pembayaran == 'jatuh_tempo')
                            <div id="jatuh_tempo" class="form-group">
                                <?php
                                $field_name = 'tgl_jatuh_tempo';
                                $field_lable = __('Tanggal Jatuh Tempo');
                                $field_placeholder = Label_case($field_lable);
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                ?>
                                <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                <input type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" id="{{$field_name}}_input" wire:model="{{ $field_name }}" min="{{ $hari_ini }}" placeholder="{{ $field_placeholder }}">
                                @if ($errors->has($field_name))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>

                        @if ($tipe_pembayaran == 'cicil' && $cicil != '')
                        <div class="card p-6 bg-gray-100 rounded-lg shadow-md">
                            <div class="text-md font-bold mb-4">Input Tanggal Cicilan</div>

                            @for ($i = 1; $i <= $cicil; $i++)
                                <div class="mb-4">
                                    <label for="cicilan{{ $i }}" class="text-gray-600 text-sm mb-2 block">Cicilan Ke {{ $i }}</label>
                                    <div class="relative rounded-lg">
                                        <?php
                                        $field_name = 'detail_cicilan.'.$i;
                                        $field_lable = __('Tanggal Jatuh Tempo');
                                        $field_placeholder = Label_case($field_lable);
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        ?>
                                        <input
                                            type="date"
                                            id="{{ $field_name }}"
                                            name="{{ $field_name }}"
                                            wire:model="{{ $field_name }}"
                                            wire:change="resetDetailCicilanAfterwards({{$i}})"
                                            min="{{ $this->getMinCicilDate($i)}}"
                                            class="block w-full py-2 px-3 text-gray-800 bg-white border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                        />

                                        @if ($errors->has($field_name))
                                        <span class="invalid feedback" role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @endfor
                        </div>
                        @endif

                        <div class="flex flex-row grid grid-cols-2 gap-2">
                            <div class="form-group">
                                <?php
                                $field_name = 'pengirim';
                                $field_lable = __('nama_pengirim');
                                $field_placeholder = Label_case($field_lable);
                                $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                ?>
                                <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                <input type="text" name="{{ $field_name }}" class="form-control {{ $invalid }}" wire:model="{{ $field_name }}" placeholder="{{ $field_placeholder }}">
                                @if ($errors->has($field_name))
                                <span class="invalid feedback" role="alert">
                                    <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="mt-4 flex justify-between">
                            <div></div>
                            <div class="form-group">
                                <a class="px-5 btn btn-danger" href="{{ route("goodsreceiptberlian.qc.index") }}">
                                    @lang('Cancel')</a>
                                <button type="submit" class="px-5 btn btn-success">@lang('Save') <i class="bi bi-check"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
@push('page_scripts')
<script>
    // $(document).ready(function() {
    //     if($('#type').val() == 1) {
    //         $('#karat_id').toggle('hide');
    //         $('#berlianitem').toggle('hide');
    //     }else{
    //         $('#karat_id').toggle('show');
    //         $('#berlianitem').toggle('show');
    //     }
    // })

    // $('#type').on('change', function(e) {
    //     e.preventDefault();
    //     if($(this).val() == 2) {
    //         $('#karat_id').toggle('show');
    //         $('#total_karat').toggle('show');
    //         $('#berlianitem').toggle('show');
    //     }else{
    //         $('#karat_id').toggle('hide');
    //         $('#berlianitem').toggle('hide');
    //         $('#total_karat').toggle('show');
    //     }
    // })

</script>
@endpush
