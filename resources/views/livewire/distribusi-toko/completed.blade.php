<div class="row">
    <div class="col-lg-12">
        <div class="card">


            <div class="card-header d-flex flex-wrap align-items-center">
                <div>
                    <h1 class="text-lg font-semibold">DISTRIBUSI TOKO</h1>
                </div>
                <a class="btn  mfs-auto btn-sm btn-success mfe-1" href="#"><i class="bi bi-house-door"></i> Dashboard
                </a>

                <a id="Tracking" class="btn btn-sm btn-info mfe-1 d-print-none" href="#" onclick="showHistory()">
                    <i class="bi bi-save"></i> History Distribusi 
                </a>
            </div>


            <div id="DivIdToPrint" class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Invoice Info: </div>
                        <div>Invoice: <strong>{{ $dist_toko->no_invoice }}</strong></div>
                        <div>Tanggal Distribusi: <strong> {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</strong></div>
                        <div>Cabang: <strong>{{ $dist_toko->cabang->name }}</strong></div>
                        <div class="uppercase">Status: <span class="text-green-600 font-bold">{{ $dist_toko->current_status->name }}</span></div>

                    </div>

                    <div class="col-sm-6 mb-3 mb-md-0">
                        <div class="font-semibold mb-2 border-bottom pb-2">Distribusi Info: </div>
                        <div>Jumlah Item: <strong>{{ $dist_toko->items()->count() }} buah</strong></div>
                        <div>Jumlah Jenis Karat: <strong> {{ $dist_toko->items()->groupBy('karat_id')->count() }} </strong></div>
                        <div>Total Berat Emas: <strong> {{ $dist_toko->items()->sum('gold_weight') }} gr</strong></div>
                    </div>





                </div>

                <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">


                    <!-- Approved Items -->
                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400"> Detail Distribusi (Approved Items)
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
                            @forelse($dist_toko->items()->approved()->get() as $row)
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
                </div>

                <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">


                    <!-- Returned Items -->
                    <div class="flex relative py-1 pb-3">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-b border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
                                <span class="text-blue-400"> Detail Distribusi (Returned Items)
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
                                $image = @$row->product?->images;
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
                </div>
            </div>
        </div>
    </div>


    @include('distribusitoko::distribusitokos.modal.history')



</div>

@push('page_scripts')
<script>
    function showHistory() {
        $('#history-modal').modal('show');
    }
</script>
<script>
function printDiv() 
{

  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>
@endpush