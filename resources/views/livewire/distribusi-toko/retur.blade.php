<div class="row">
    <div class="col-lg-12">
        <div class="card">


            <div class="card-header d-flex flex-wrap align-items-center">
                <div>
                    <h1 class="text-lg font-semibold">RETUR DISTRIBUSI</h1>
                </div>
                <a class="btn  mfs-auto btn-sm btn-success mfe-1" href="#"><i class="bi bi-house-door"></i> Dashboard
                </a>

                <a id="Tracking" class="btn btn-sm btn-info mfe-1 d-print-none" href="#" onclick="showHistory()">
                    <i class="bi bi-save"></i> History Distribusi
                </a>
            </div>


            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Invoice Info: </div>
                        <div>Invoice: <strong>{{ $dist_toko->no_invoice }}</strong></div>
                        <div>Tanggal Distribusi: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong></div>
                        <div>Tanggal Retur: <strong> {{ \Carbon\Carbon::parse($dist_toko->current_status_date())->format('d M, Y') }}</strong></div>
                        <div>Cabang: <strong>{{ $dist_toko->cabang->name }}</strong></div>
                        <div>
                            Diretur oleh: <strong>{{ $dist_toko->current_status_pic()->name }}</strong>
                        </div>


                    </div>

                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Retur Info: </div>
                        <div>Jumlah Item: <strong>{{ $dist_toko->items()->returned()->count() }} buah</strong></div>
                        <div>Jumlah Jenis Karat: <strong> {{ $dist_toko->items()->returned()->groupBy('karat_id')->count() }} </strong></div>
                        <div>Total Berat Emas: <strong> {{ $dist_toko->items()->returned()->sum('gold_weight') }} gr</strong></div>
                        <div>Alasan Retur: <strong>{{ $dist_toko->current_status_note() }}</strong></div>
                    </div>





                </div>


                <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">



                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400"> Detail Retur Distribusi
                                </span>

                        </div>
                    </div>

                    <table style="width: 100% !important;" class="table table-sm table-striped rounded rounded-lg table-bordered">
                        <thead>
                            <tr>

                                <th class="text-center">No</th>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Kode</th>
                                <th class="text-center">Karat</th>
                                <th class="text-center">Berat Emas</th>
                                <th class="text-center">Gambar Produk</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total_weight = 0;
                            @endphp
                            @forelse($dist_toko->items()->returned()->get() as $row)
                                @php
                                $row->load('product');
                                $total_weight = $total_weight + @$row->product->berat_emas;
                                $image = $row->product?->images;
                                $imagePath = empty($image)?url('images/fallback_product_image.png'):asset(imageUrl().$image);
                                @endphp
                            <tr>

                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="font-semibold">
                                    <p>Nama : {{ @$row->product->product_name }}</p>
                                    <p>Kategori : {{ @$row->product->category->category_name }}</p>
                                </td>
                                <td class="font-semibold text-center">
                                    <p>{{ @$row->product->product_code }}</p>
                                </td>
                                <td class="text-center font-semibold"> {{@$row->product->karat->label}}</td>
                                <td class="text-center font-semibold"> {{@$row->product->berat_emas}} gr</td>
                                <td class="text-center"> <a href="{{ $imagePath }}" data-lightbox="{{ @$image }} " class="single_image flex justify-center">
                                        <img src="{{ $imagePath }}" order="0" width="70" class="img-thumbnail"/>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="8" class="text-center">Tidak ada data</th>
                            </tr>
                            @endforelse
                            <tr>
                                <td class="border-0" colspan="3"></td>
                                <td class="border-0"></td>
                                <td class="border-0"></td>

                                <td colspan="3" class="border-0 text-center font-semibold">
                                    <div class="text-right px-3 text-2xl">
                                        <span class="text-base text-gray-500"> Jumlah Emas : </span>

                                        <span class="px-2"> {{ $total_weight }} <small>GR</small></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    <div class="flex justify-end items-center mt-1 gap-3">
                        <div>
                            
                        </div>
                        <div>

                            <a href="#" class="px-5 btn btn-lg btn-success" onclick="approve()">Setujui</a>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
    @include('distribusitoko::distribusitokos.modal.history')
    @livewire('distribusi-toko.modal.retur.detail',['dist_toko' => $dist_toko])
</div>

@push('page_scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showHistory() {
        $('#history-modal').modal('show');
    }

    function showDetailModal(row) {
        $('#retur-detail').modal('show');
        Livewire.emitTo('distribusi-toko.modal.retur.detail', 'setData', row)
    }

    function approve(){
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Aksi ini tidak bisa dibatalkan",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#0a0",
            cancelButtonColor: "#d33",
            confirmButtonText: "Setujui"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emitTo('distribusi-toko.retur', 'is_approved', true)
                Swal.fire({
                    title: "Berhasil!",
                    text: "Retur disetujui",
                    icon: "success"
                });
            }
        });
    }
</script>

@endpush