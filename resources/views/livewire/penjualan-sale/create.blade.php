<div>
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



                <div class="w-2/4">
                    <!-- No Invoice -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Invoice No.</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <input wire:model="penjualan_sales.invoice_no" type="text" name="invoice" id="first_name" placeholder="eg. #INV-100001" class="form-control @error('penjualan_sales.invoice_no') is-invalid @enderror">
                            @error('penjualan_sales.invoice_no')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>


                    <!-- Date -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide"> Date</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <input wire:model="penjualan_sales.date" max="{{ $hari_ini }}" type="date" name="invoice" id="date" class="form-control @error('penjualan_sales.date') is-invalid @enderror">
                            @error('penjualan_sales.date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sales -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <?php
                        $field_name = 'penjualan_sales.sales_id';
                        $field_lable = __('Sales');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Sales</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <select class="form-control select2" wire:model="{{ $field_name }}" wire:change="updateKaratList">
                                <option value="" selected disabled>Pilih Sales</option>
                                @foreach($dataSales as $sales)
                                <option value="{{$sales->id}}">
                                    {{$sales->name}}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Konsumen Sales -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <?php
                        $field_name = 'penjualan_sales.konsumen_sales_id';
                        $field_lable = __('Konsumen Sales');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Konsumen Sales</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <select class="form-control select2" wire:model="penjualan_sales.konsumen_sales_id" wire:change="updateMarketName()">
                                <option value="" selected disabled>Pilih Konsumen</option>
                                @foreach($konsumenSales as $konsumen)
                                <option value="{{$konsumen->id}}">
                                    {{$konsumen->customer_name}}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has($field_name))
                            <span class="invalid feedback" role="alert">
                                <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Store Name -->
                    <div class="mb-2 md:mb-1 md:flex items-center">
                        <label class="w-32 text-gray-400 block font-semibold text-sm uppercase tracking-wide">Nama Pasar</label>
                        <span class="mr-4 inline-block hidden md:block">:</span>
                        <div class="flex-1">
                            <input wire:model="penjualan_sales.store_name" type="text" name="store_name" id="store_name" placeholder="" class="form-control @error('penjualan_sales.store_name') is-invalid @enderror" readonly>
                            @error('penjualan_sales.store_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            @foreach($penjualan_sales_details as $key => $value)
            <div class="flex justify-between mb-3">
                <div class="add-input w-full mx-auto flex flex-row grid grid-cols-5 gap-2">


                    <div class="form-group">
                        <?php

                        $field_name = 'penjualan_sales_details.' . $key . '.karat_id';
                        $field_lable = __('Parameter Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="' . $field_name . '"';
                        ?>
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm" wire:model="penjualan_sales_details.{{$key}}.karat_id" name="{{ $field_name }}" wire:change="changeParentKarat({{$key}})">
                            <option value="" selected disabled>Select Karat</option>
                            @foreach($dataKarat as $karat)
                            <option value="{{$karat->id}}">
                                {{$karat->name}} | {{$karat->kode}}
                            </option>
                            @endforeach
                        </select>
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>

                    <!-- Sub Karat -->
                    <div class="form-group">
                        <?php
                        $field_name = 'penjualan_sales_details.' . $key . '.sub_karat_id';
                        $field_lable = __('Kategori Karat');
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        $required = 'wire:model="'.$field_name.'"';
                        ?>
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>
                        <select  class="form-control form-control-sm" 
                        name="{{ $field_name }}" wire:model="{{$field_name}}">
                            <option value="" selected disabled>Select Kategori</option>
                            @foreach($penjualan_sales_details[$key]['sub_karat_choice'] as $karat)
                            <option value="{{$karat['id']}}">
                            {{$karat['name']}} | {{$karat['kode']}} </option>
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

                        $field_name = 'penjualan_sales_details.' . $key . '.weight';
                        $field_lable = label_case('berat');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        ?>
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                            {{ $field_lable }}<span class="text-danger">*</span></label>
                        <input wire:change="$emit('beratChanged', {{ $key }})" type="number" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm {{$invalid}}" required min="0" step="0.001" wire:model.debounce.1s="{{ $field_name }}">
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <?php

                        $field_name = 'penjualan_sales_details.' . $key . '.nominal';
                        $field_lable = label_case('harga');
                        $field_placeholder = $field_lable;
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        ?>
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">
                            {{ $field_lable }}</label>

                        <span class="ml-2">
                            <input type="radio" wire:model="penjualan_sales_details.{{$key}}.harga_type" value="persen" wire:change="clearHarga({{$key}})">
                            <label class="text-black mb-0">%</label>
    
                            <input type="radio" wire:model="penjualan_sales_details.{{$key}}.harga_type" value="nominal" wire:change="clearHarga({{$key}})">
                            <label class="text-black mb-0">Rp.</label>
                        </span>
                        <input wire:change="$emit('hargaChanged', {{ $key }})" type="number" placeholder="{{ $field_placeholder }}" class="form-control form-control-sm {{$invalid}}" required min="0" wire:model.debounce.1s="{{ $field_name }}">
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>


                    <div class="form-group">
                        <?php
                        $field_name = 'penjualan_sales_details.' . $key . '.jumlah';
                        if ($penjualan_sales_details[$key]['harga_type'] == 'persen'){
                            $field_lable = __('Konversi 24K');
                        }else{
                            $field_lable = __('Total Harga');
                        }
                        $field_placeholder = Label_case($field_lable);
                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                        ?>
                        <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                        <input type="number" name="{{ $field_name }}" class="form-control form-control-sm {{ $invalid }}" name="{{ $field_name }}" wire:model="{{ $field_name }}" readonly>
                        @if ($errors->has($field_name))
                        <span class="invalid feedback" role="alert">
                            <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                        </span>
                        @endif
                    </div>






                </div>
                @if ($key == 0)
                <div class="px-1 pt-4">
                    <button class="btn text-white text-xl btn-info btn-sm" wire:click.prevent="add" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="add"><i class="bi bi-plus"></i></span>
                        <span wire:loading wire:target="add" class="text-center">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
                @else
                <div class="px-1 pt-4">
                    <button class="btn text-white text-xl btn-danger btn-sm" wire:click.prevent="remove({{$key}})" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="remove({{$key}})"><i class="bi bi-trash"></i></span>
                        <span wire:loading wire:target="remove({{$key}})" class="text-center">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
                @endif
            </div>
            @endforeach


            <div class="flex grid grid-cols-4 gap-2">
                <div class="form-group">
                    <?php
                    $field_name = 'penjualan_sales.tipe_pembayaran';
                    $field_lable = label_case('tipe_pembayaran');
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = "required";
                    ?>
                    <label class="text-gray-700 mb-0" for="{{ $field_name }}">Tipe Pembayaran <span class="text-danger">*</span></label>
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
                @if ($this->penjualan_sales['tipe_pembayaran'] == 'cicil')
                <div id="cicilan" class="form-group">
                    <?php
                    $field_name = 'penjualan_sales.cicil';
                    $field_lable = __('cicil');
                    $field_placeholder = Label_case($field_lable);
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    $required = '';
                    ?>
                    <label class="text-gray-700 mb-0" for="{{ $field_name }}"> {{ $field_placeholder }} <span class="text-danger">*</span></label>
                    <select class="form-control select2" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}">
                        <option value="" selected disabled>Jumlah {{ $field_lable }}an</option>
                        <option value="1">1 kali</option>
                        <option value="2">2 kali </option>
                    </select>
                    @if ($errors->has($field_name))
                    <span class="invalid feedback" role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                    </span>
                    @endif
                </div>
                @elseif ($this->penjualan_sales['tipe_pembayaran'] == 'jatuh_tempo')
                <div id="jatuh_tempo" class="form-group">
                    <?php
                    $field_name = 'penjualan_sales.tgl_jatuh_tempo';
                    $field_lable = __('Tanggal');
                    $field_placeholder = Label_case($field_lable);
                    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                    ?>
                    <label class="text-gray-700 mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
                    <input type="date" name="{{ $field_name }}" class="form-control {{ $invalid }}" name="{{ $field_name }}" id="{{$field_name}}_input" wire:model="{{ $field_name }}" min="{{ $hari_ini }}" placeholder="{{ $field_placeholder }}">
                    @if ($errors->has($field_name))
                    <span class="invalid feedback" role="alert">
                        <small class="text-danger">{{ $errors->first($field_name) }}.</small class="text-danger">
                    </span>
                    @endif
                </div>
                @endif

            </div>









<div class="flex flex-col items-end mb-8">
    <div class="mb-2 md:mb-1 flex items-center">
        <label class="w-30 text-gray-700 block text-sm tracking-wide">Total Berat</label>
        <span class="mr-4 md:block">:</span>
        <div class="flex-1">
            <input class="form-control form-control-sm" wire:model.debounce.1s="penjualan_sales.total_weight" type="text" placeholder="0" readonly>
        </div>
    </div>
    <div class="mb-2 md:mb-1 flex items-center">
        <label class="w-30 text-gray-700 block text-sm tracking-wide">Jumlah</label>
        <span class="mr-4 md:block">:</span>
        <div class="flex-1">
            <input class="form-control form-control-sm" type-currency="IDR" wire:model.debounce.1s="penjualan_sales.total_jumlah" type="text" placeholder="0" readonly>
        </div>
    </div>

</div>






</div>




<div class="pt-2 border-t flex justify-between">
    <div></div>
    <div class="form-group">
        <a class="px-5 btn btn-outline-danger" href="{{ route("goodsreceipt.index") }}">
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
</script>



@endpush