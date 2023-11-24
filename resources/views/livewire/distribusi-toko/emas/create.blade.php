<div class="row mt-0 p-3">


    <div class="col-md-5 bg-white">
        <div class="pt-3">
            {{-- <livewire:distribusi-toko.berlian.table /> --}}
            <div>

                <p class="uppercase text-lg text-gray-600 font-semibold">Input Barcode</p>
                <hr style="
                    height: 1px;
                    border: none;
                    color: #333;
                    background-color: #333;">

                <div class="col-md-12 mt-2">
                    <!-- Search box -->
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="form-group">
                                <input id = "barcodeForm" type="text" class="form-control rounded rounded-lg sortir text-center" placeholder="Kode Produk" style="width: 100%;" wire:model='kode_produk' wire:keydown.enter="submitBarcode()" autofocus>
                            </div>
                        </div>
                    </div>
                </div>

                
                <p class="uppercase text-lg text-gray-600 font-semibold">Input Manual</p>
                <hr style="
                    height: 1px;
                    border: none;
                    color: #333;
                    background-color: #333;">
                <div class="col-md-12 mt-2">
                    <!-- Search box -->
                    <div class="grid grid-cols-2 gap-3 justify-between">
                        <div class="form-group">
                            <input type="text" wire:model="search" class="form-control" placeholder="Cari Produk" style="width: 100%;" >
                        </div>
                        <div class="form-group justify-self-end">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                                Tambah Produk
                            </button>
                        </div>
                    </div>

                    <!-- Paginated records -->
                    <div class="table-responsive">
                        <table id="produksisTable" class="table table-sm table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="no-sort text-center">No</th>
                                    <th class="no-sort">Image</th>
                                    <th class="no-sort">Informasi Produk</th>
                                    <th class="no-sort text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($products as $key => $product)
                                @php
                                    $image = $product->images;
                                    $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="flex justify-center"> <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image">
                                            <img src="{{ $imagePath }}" order="0" width="70" class="img-thumbnail"/>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="block">Nama : <span class="font-bold">{{ $product->product_name }}</span></span>
                                        <span class="block">Karat : <span class="font-bold">{{ $product->karat->label }}</span></span>
                                        <span class="block">Berat : <span class="font-bold">{{ $product->berat_emas }} gr</span></span>
                                    </td>
                                    <td>
                                        <button wire:click="selectProduct({{ $product }})"
                                        class="w-100 btn btn-sm btn-outline-success "
                                        style="cursor: pointer;"> Tambah
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" align="center">No record found</td>
                                </tr>
                                @endforelse
                                
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
                @if ($errors->has('details_count'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            <span>{{ $errors->first('details_count') }}</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                @endif
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
                                        @foreach($cabangs as $sup)
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
                                    <th class="align-middle">@lang('Image')</th>
                                    <th class="align-middle">@lang('Informasi Produk')</th>
                                    <th class="align-middle">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($distribusi_toko_details as $index => $product )
                                @php
                                    $image = $product['images'];
                                    $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center"> <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image flex justify-center">
                                            <img src="{{ $imagePath }}" order="0" width="70" class="img-thumbnail"/>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="block">Nama : <span class="font-bold">{{ $product['product_name'] }}</span></span>
                                        <span class="block">Karat : <span class="font-bold">{{ $product['karat']['name'] }} | {{ $product['karat']['kode'] }}</span></span>
                                        <span class="block">Berat : <span class="font-bold">{{ $product['berat_emas'] }} gr</span></span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" wire:click="remove({{ $index }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                        
                                @empty
                                    <td class="text-center" colspan="4">Belum ada produk yang dipilih</td>
                                </tr>
                                @endforelse
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
    @include('distribusitoko::distribusitokos.emas.modal.add-product')
</div>

@push('page_scripts')
<script>
    window.addEventListener('create-modal:close', event => {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('#createModal').modal('hide');
        $('#imageprev').attr('src','');
        toastr.success('Berhasil Menambahkan Produk');
    });
    window.addEventListener('not:selected', event => {
        toastr.error('Produk belum dipilih');
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
@endpush