<div class="row mt-0 p-3">


    <div class="col-md-5 bg-white">
        <div class="pt-3">
            {{-- <livewire:distribusi-toko.berlian.table /> --}}
            <div>
                <div class="col-md-12">
                    <!-- Search box -->
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Cari Produk" style="width: 100%;" wire:model="searchTerm" >
                            </div>
                        </div>
                    </div>

                    <!-- Paginated records -->
                    <div class="table-responsive">
                        <table class="table table-sm table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="no-sort text-center">No</th>
                                    <th class="no-sort">Kode Produksi</th>
                                    <th class="no-sort">Produk Informasi</th>
                                    <th class="no-sort text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($products->count())
                                @foreach ($products as $key => $value)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td> {{ $value->code }} </td>
                                    <td> {{ $value->model?->name }} {{ $value->karatjadi?->name  }} | {{ $value->berat }} gr </td>
                                    <td>
                                        <button wire:click="selectProduct('{{ $value }}')"
                                        class="w-100 btn btn-sm btn-outline-success "
                                        style="cursor: pointer;"> Tambah
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" align="center">No record found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <!-- Pagination navigation links -->
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">

            <div class="card-body">
                @include('utils.alerts')
                <form wire:submit.prevent="store">
                    @csrf
                    <div class="form-row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                    <?php
                                        $field_name = 'distribusi_toko.no_distribusi_toko';
                                        $field_lable = label_case('No Surat Jalan');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">{{ $field_lable }}</label>
                                    <input type="text" class="form-control form-control-sm" name="{{ $field_name }}" wire:model="{{ $field_name }}" required readonly>
                                    @if ($errors->has($field_name))
                                        <span class="invalid feedback"role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                            class="text-danger">
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                    <?php
                                        $field_name = 'distribusi_toko.date';
                                        $field_lable = label_case('Date');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">Date</label>
                                    <input type="date" class="form-control form-control-sm" name="{{ $field_name }}" wire:model="{{ $field_name }}" required>
                                    @if ($errors->has($field_name))
                                        <span class="invalid feedback"role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                            class="text-danger">
                                        </span>
                                    @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                    <?php
                                        $field_name = 'distribusi_toko.cabang_id';
                                        $field_lable = label_case('cabang');
                                        $field_placeholder = $field_lable;
                                        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                        $required = "required";
                                    ?>
                                    <label for="{{ $field_name }}">Cabang</label>
                                    <select class="form-control @error($field_name) is-invalid @enderror" name="{{ $field_name }}" id="{{ $field_name }}" wire:model="{{ $field_name }}" >
                                        <option value="" selected>Pilih Cabang</option>
                                        @foreach($cabang as $sup)
                                        <option value="{{$sup->id}}">
                                            {{$sup->name}}
                                        </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has($field_name))
                                        <span class="invalid feedback"role="alert">
                                            <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                            class="text-danger">
                                        </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="tablelist">
                            <thead>
                                <tr class="align-middle">
                                    <th class="align-middle">@lang('No')</th>
                                    <th class="align-middle">@lang('Kode Produksi')</th>
                                    <th class="align-middle">@lang('Produk Informasi')</th>
                                    <th class="align-middle">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distribusi_toko_details as $index => $val )
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td> {{ !empty($val['code']) ? $val['code'] : ''  }} </td>
                                    <td> {{ $val['model']['name'] }} {{ $val['karatjadi']['name']  }} | {{ $val['berat'] }} gr </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" wire:click="remove({{ $index }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            @lang('Create Distribution') <i class="bi bi-check"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('page_scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('alreadySelected', function () {
            toastr.error('Item sudah dipilih!');
        });
    });
</script>

@endpush