

<div class="flex gap-1">

  <div class="w-3/4">

  @can('dashboard_kepala_toko')
  <div class="flex flex-row grid grid-cols-3 gap-2 mt-1">
<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>

            <div class="text-value text-primary">{{ \Modules\DistribusiToko\Models\DistribusiToko::whereIn('status_id',[2])->count() }}</div>
          <div class="text-muted text-uppercase font-weight-bold">
              In Progresss
            </div>
           <div class="small text-green-400 text-uppercase font-weight-bold">
           Distribusi Toko
            </div>

        </div>
    </div>
</div>




<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-success">
            {{ \Modules\BuysBack\Models\BuyBackNota::count() }}
           </div>
            <div class="text-muted text-uppercase font-weight-bold">
             BuyBack Nota
            </div>

        </div>
    </div>
</div>

<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-warning">
                {{ \Modules\BuysBack\Models\BuysBack::count() }}
            </div>
            <div class="text-muted text-uppercase font-weight-bold">

           Buys Back
            </div>

        </div>
    </div>
</div>



</div>
@endcan

{{-- {{ auth()->user() }} --}}
<div class="card">




<div class="card-body">

<div class="flex relative py-2">
  <div class="absolute inset-0 flex items-center">
    <div class="w-full border-b border-gray-300"></div>
  </div>
  <div class="relative flex justify-left">
    <span class="bg-white pl-0 pr-3  text-sm uppercase tracking-wider font-semibold text-dark">
    Dashboard Kepala Toko
   </span>
  </div>
</div>


    <ul class="nav nav-tabs py-1" role="tablist">

        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#Buysback">Buys Back</a>
        </li>

        @can('access_buysback_nota')
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#BuysBacNota">
            Buys Back Nota</a>
        </li>
        @endcan


        @can('show_distribusi')
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#distribusitoko">Distribusi Toko</a>
        </li>
        @endcan

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#Penjualan">Penjualan</a>
        </li>

         <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#StockPending">Stok Pending</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#StockReady">Stok Ready</a>
        </li>
    </ul>

    <div class="tab-content py-3 mb-2">
 <div id="Buysback" class="container px-0 tab-pane active">
            <div class="pt-3">


<table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('no_buys_back') }}</th>
                            <th>{{ label_case('Tanggal') }}</th>
                            <th>{{ label_case('Cabang') }}</th>
                            <th>{{ label_case('karat') }}</th>
                            <th>{{ label_case('berat') }}</th>

                            <th>{{ label_case('Status') }}</th>
                            <th>{{ label_case('Aksi') }}</th>
                        </tr>
                        @forelse(\Modules\BuysBack\Models\BuysBack::get() as $sale)
                            @if($loop->index > 4)
                               @break
                            @endif


                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-blue-400">{{ shortdate($sale->date) }}</td>
                            <td>{{ $sale->no_buy_back }}</td>
                            <td>{{ $sale->cabang->name }}</td>
                            <td>{{ $sale->karat->name }}</td>
                            <td>{{ $sale->weight }}</td>


                            <td>

                         <a href="{{ route('buysback.status', $sale->id) }}"
                            id="Status"
                            data-toggle="tooltip"
                             class="btn {{bpstts($sale->current_status?$sale->current_status->name:'PENDING')}} btn-sm uppercase">
                               {{$sale->current_status?$sale->current_status->name:'PENDING'}}
                            </a>

                            </td>
                            <td>

                        <a href="{{ route('buysback.show', $sale->id) }}"
                            data-toggle="tooltip"
                             class="btn btn-sm btn-outline-info uppercase">Detail
                            </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8"> <p class="uppercase">Tidak ada Data</p></td>

                            </tr>
                        @endforelse

                    </table>




            </div>
        </div>

  <div id="distribusitoko" class="container px-0 tab-pane">
            <div class="pt-3">
             <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th class="text-center">{{ label_case('Cabang') }}</th>
                            <th class="text-center">{{ label_case('Date') }}</th>
                            <th class="text-center">{{ label_case('Invoice') }}</th>
                            <th class="text-center">{{ label_case('Items') }}</th>
                            <th class="text-center">{{ label_case('Status') }}</th>
                            <th class="text-center">{{ label_case('Pic') }}</th>
                            <th class="text-center">{{ label_case('Aksi') }}</th>
                        </tr>
                      @forelse(\Modules\DistribusiToko\Models\DistribusiToko::inprogress()->get() as $row)
                            @if($loop->index > 4)
                               @break
                            @endif

                            {{-- {{ $row }} --}}
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->cabang->name }}</td>
                            <td>{{ shortdate($row->date) }}</td>
                            <td>{{ $row->no_invoice }}</td>
                            <td>{{ $row->items->count() }}</td>
                            <td>
                            @if($row->current_status->id == 2)
                                <button class="w-full btn uppercase btn-outline-warning px  leading-5 btn-sm">In Progress</button>
                                @endif
                            </td>
                            <td>{{ $row->created_by }}</td>

            <td class="text-center">
             <a  href="{{ route('distribusitoko.detail_distribusi', $row->id) }}" class="btn btn-success px-4 btn-sm w-full">
    <i class="bi bi-eye"></i> Approve
</a>


            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="8"> <p class="uppercase">Tidak ada Data</p></td>

                            </tr>
                        @endforelse

                    </table>

            </div>
        </div>



  <div id="StockPending" class="container px-0 tab-pane">
            <div class="pt-3">

                   <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('Sales') }}</th>
                            <th>{{ label_case('karat') }}</th>
                            <th>{{ label_case('Berat') }}</th>
                            <th>{{ label_case('Aksi') }}</th>
                        </tr>
                    @forelse(\Modules\Stok\Models\StockPending::get() as $row)
                            @if($loop->index > 4)
                                                @break
                                            @endif
                                {{-- {{ $row }} --}}

                  <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->karat->kode }} | {{ $row->karat->name }}</td>
                            <td>{{ $row->cabang->name }}</td>
                            <td>{{ $row->weight ?? ' - ' }}</td>
                            <td>

                                    <a href="{{ route("sales.show",$row->id) }}"
                                     class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-eye"></i>&nbsp;@lang('Detail')
                                    </a>
                                @can('show_sales')
                                @endcan


                            </td>
                        </tr>
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse

                    </table>








            </div>
        </div>






  <div id="Penjualan" class="container px-0 tab-pane">
            <div class="pt-3">
                   <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('invoice_no') }}</th>
                            <th>{{ label_case('Cabang') }}</th>
                            <th>{{ label_case('Customer') }}</th>
                            <th>{{ label_case('Total') }}</th>
                            <th>{{ label_case('Status') }}</th>
                            <th>{{ label_case('Aksi') }}</th>
                        </tr>
                    @forelse(\Modules\Sale\Entities\Sale::akses()->get() as $row)
                            @if($loop->index > 4)
                                                @break
                                            @endif
                                {{-- {{ $row }} --}}


                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->reference }}</td>
                            <td>{{ $row->cabang->name }}</td>
                            <td>{{ $row->customer->customer_name }}</td>
                            <td>

                                {{-- Rp .<strong>{{ rupiah($row->total_amount)}}</strong> --}}
                                <div class="items-center justify-items-center text-center">
                                @if ($row->tipe_bayar == 'cicilan')
                                    <span class="text-center text-dark">
                                       {{ rupiah($row->total_amount) }}
                                       <div>  {{ shortdate($row->tgl_jatuh_tempo) }} </div>
                                    </span>
                                @elseif ($row->status == 'total')
                                    <span class="badge badge-primary">
                                        {{ $row->status }}
                                    </span>
                                @else
                                    <span class="text-center text-dark">
                                        {{ rupiah($row->total_amount) }}
                                    </span>
                                @endif
                                </div>


                            </td>
                            <td>
                             <div class="items-center justify-items-center text-center">
                                    @if ($row->tipe_bayar == 'cicilan')
                                    <a
                                    class="btn btn-sm btn-info"
                                    id="Show"
                                    href="{{ route('sales.show_cicilan', $row->id) }}">
                                    &nbsp;@lang('Cicilan')
                                    </a>
                                    @elseif ($row->status == 'total')
                                        <span class="badge badge-primary">
                                            {{ $row->status }}
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            Tunai
                                        </span>
                                    @endif
                                    </div>
                            </td>
                            <td>

                                @can('show_sales')
                                    <a href="{{ route("sales.show",$row->id) }}"
                                     class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-eye"></i> &nbsp;@lang('Detail')
                                    </a>
                                @endcan
                                    <a class="btn btn-outline-warning btn-sm" target="_blank" href="{{ route('sales.invoice', $row->id) }}"> <i class="bi bi-printer"></i>&nbsp;@lang('Print')</a>
                                  @can('print_sales')
                                     @endcan


                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5"> <p class="uppercase">Tidak ada Data</p></td>

                            </tr>
                        @endforelse

                    </table>

            </div>
        </div>




  <div id="BuysBacNota" class="container px-0 tab-pane">
            <div class="pt-3">

                   <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th class="text-center">{{ label_case('Date') }}</th>
                            <th>{{ label_case('invoice_no') }}</th>
                            <th>{{ label_case('Invoice Series') }}</th>
                            <th>{{ label_case('Cabang') }}</th>
                            <th>{{ label_case('Pic') }}</th>
                            <th>{{ label_case('Aksi') }}</th>
                        </tr>
                    @forelse(\Modules\BuysBack\Models\BuyBackNota::get() as $row)
                                    @if($loop->index > 4)
                                         @break
                                     @endif
                                            {{-- {{ $row }} --}}

                           <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ shortdate($row->date) }}</td>
                                <td>{{ $row->invoice }}</td>
                                <td>{{ $row->invoice_series }}</td>
                                <td>{{ @$row->cabang->name }}</td>
                                <td>{{ @$row->pic->name }}</td>
                            <td>

                                @can('approve_distribusi')
                              <a href="{{ route("sales.show",$row->id) }}"
                                     class="btn btn-outline-success btn-sm">
                                   {{ Label_case('approve_distribusi') }}
                                    </a>
                                @endcan


                            </td>
                        </tr>
                        @empty
                           <tr>
                                <td colspan="6"> <p class="uppercase">Tidak ada Data</p></td>

                            </tr>
                        @endforelse

                    </table>

            </div>
        </div>

  <div id="StockReady" class="container px-0 tab-pane">
            <div class="pt-3">

                   <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th class="text-center">{{ label_case('Date') }}</th>
                            <th>{{ label_case('Produk') }}</th>
                            <th>{{ label_case('Karat') }}</th>
                            <th>{{ label_case('Status') }}</th>

                        </tr>
                    @forelse(\Modules\Product\Entities\Product::ready()->get() as $row)
                        @if($loop->index > 4)
                             @break
                         @endif
                           {{-- {{ $row }} --}}

                           <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ tgl($row->created_at) }}</td>
                                <td>{{ $row->product_name }}</td>
                                <td>{{ $row->karat->name }}</td>
                                <td>
                                    <span class="bg-green-500 px-2 py-1 text-center text-white uppercase rounded-md">  {{ @$row->product_status->name }}</span>
                                  
                                </td>

                        </tr>
                        @empty
                           <tr>
                                <td colspan="6"> <p class="uppercase">Tidak ada Data</p></td>

                            </tr>
                        @endforelse

                    </table>

            </div>
        </div>















    </div>




</div>

</div>




  </div>



  <div class="w-1/4 card">
@include('partial.pages.user')




<hr class="mt-3">

  </div>
</div>



@section('third_party_stylesheets')

@endsection


@push('page_scripts')



@endpush
