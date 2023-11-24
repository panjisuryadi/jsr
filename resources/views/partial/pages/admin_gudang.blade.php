<div class="flex gap-1">

  <div class="w-3/4">
  @can('dashboard_gudang')
  <div class="flex flex-row grid grid-cols-3 gap-2 mt-1">  
<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-primary">{{ \Modules\GoodsReceipt\Models\GoodsReceipt::count() }}</div>
            <div class="text-muted text-uppercase font-weight-bold">
           Penerimaan
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
            {{ \Modules\DistribusiToko\Models\DistribusiToko::count() }}
           </div>
            <div class="text-muted text-uppercase font-weight-bold">
          Distribusi Toko
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
                {{ \Modules\Product\Entities\Product::count() }}
            </div>
            <div class="text-muted text-uppercase font-weight-bold">

           Produk
            </div>

        </div>
    </div>
</div>



</div>
@endcan


<div class="card">
<div class="card-body">
    <div class="flex relative py-2">
  <div class="absolute inset-0 flex items-center">
    <div class="w-full border-b border-gray-300"></div>
  </div>
  <div class="relative flex justify-left">
    <span class="bg-white pl-0 pr-3  text-sm uppercase  font-semibold text-dark">
    Dashboard Gudang
   </span>
  </div>
</div>

    
    <ul class="nav nav-tabs py-1" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home">Penerimaan</a>
        </li>
         @can('show_distribusi')
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#sales">Distribusi Toko</a>
        </li> 
          @endcan
       @can('show_products')
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#DataSales">Produk</a>
        </li>
        @endcan    

         @can('show_products')
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#GoodsReceiptNota">Goods Receipt Nota </a>
        </li>
        @endcan  

      
    </ul>

    <div class="tab-content py-3 mb-2">
        <div id="home" class="container px-0 tab-pane active">


            <div class="pt-3">

                    <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('tgl') }}</th>
                            <th>{{ label_case('Supplier') }}</th>
                            <th>{{ label_case('berat_kotor') }}</th>
                            <th>{{ label_case('berat_timbangan') }}</th>
                            <th>{{ label_case('selisih') }}</th>
                            <th>{{ label_case('pengirim') }}</th>
                            <th>{{ label_case('Aksi') }}</th>
                        </tr>

                          @forelse(\Modules\GoodsReceipt\Models\GoodsReceipt::get() as $row)
                            @if($loop->index > 4)
                                  @break
                            @endif
                        
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> <p class="text-blue-500">{{ shortdate($row->date) }}</p></td>
                            <td>{{ $row->supplier->toko }}</td>
                            <td>{{ $row->total_berat_kotor }}</td>
                            <td>{{ $row->berat_timbangan }}</td>
                            <td>{{ $row->selisih }}</td>
                            <td>{{ $row->pengirim }}</td>
                            <td>
                            @can('show_goodsreceipts')
                                    <a href="{{ route("goodsreceipt.show",encode_id($row->id)) }}"
                                     class="btn btn-outline-info btn-sm">
                                        <i class="bi bi-eye"></i> &nbsp;@lang('Show')
                                    </a>
                                @endcan

                            </td>
                      
                          
                        </tr>
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse
                        
                    </table>




            </div>
        </div>

  <div id="sales" class="container px-0 tab-pane">
            <div class="pt-3">
             <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('Tanggal') }}</th>
                            <th>{{ label_case('Invoice') }}</th>
                            <th>{{ label_case('Cabang') }}</th>
                            <th>{{ label_case('Status') }}</th>
                            <th>{{ label_case('Admin') }}</th>
                        </tr>
                      @forelse(\Modules\DistribusiToko\Models\DistribusiToko::get() as $row)
                            @if($loop->index > 4)
                               @break
                            @endif

                        <tr>

                            <td>{{ $loop->iteration }}</td>
                        <td> <p class="text-blue-500">{{ shortdate($row->date) }}</p></td>
                            <td>{{ $row->no_invoice }}</td>
                            <td>{{ $row->cabang->name }}</td>
                            <td>
                         @if($row->current_status->id == 2)
                        <button class="w-full btn uppercase btn-outline-warning px  leading-5 btn-sm">In Progress</button>

                        @elseif($row->current_status->id == 3)
                        <button class="w-full btn uppercase btn-outline-danger px  btn-sm">Retur</button>

                        @elseif($row->current_status->id == 4)
                        <button class="w-full btn uppercase btn-outline-info px btn-sm">Completed</button>

                        @elseif($row->current_status->id == 1)
                        <button class="w-full btn uppercase btn-success px btn-sm">Draft</button>
                        @endif

                            </td>
                         
                            <td>{{ $row->created_by ?? ' - ' }}</td>
                        </tr>
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse
                        
                    </table>

            </div>
        </div>

  <div id="DataSales" class="container px-0 tab-pane">
            <div class="pt-3">

                    <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">
                            {{ label_case('No') }}
                           </th>
                            <th>{{ label_case('Code') }}</th>
                            <th>{{ label_case('Cabang') }}</th>
                            <th>{{ label_case('kategori') }}</th>
                          
                        </tr>
                        @forelse(\Modules\Product\Entities\Product::get() as $sale)
                            @if($loop->index > 4)
                                                @break
                                            @endif
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->product_code }}</td>
                            <td>{{ $sale->cabang->name }}</td>
                            <td>{{ $sale->category->category_name }}</td>
                            
                        </tr>
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse
                    </table>
     
            </div>
        </div>

<div id="GoodsReceiptNota" class="container px-0 tab-pane">
            <div class="pt-3">

                <table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">{{ label_case('No') }}</th>
                            <th>{{ label_case('Code') }}</th>                          
                        </tr>
                        @forelse(\Modules\GoodsReceipt\Models\Toko\BuyBackBarangLuar\GoodsReceiptNota::get() as $sale)
                            @if($loop->index > 4)
                                                @break
                                            @endif
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->product_code }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">Tidak Ada Data</td>
                        </tr>
                        @endforelse
                    </table>
     
            </div>
        </div>









        
    </div>
{{-- batas --}}





<div class="px-1 py-1 border-t-black">
    
<div class="flex relative py-2">
  <div class="absolute inset-0 flex items-center">
    <div class="w-full border-b border-gray-300"></div>
  </div>
  <div class="relative flex justify-left">
    <span class="bg-white pl-0 pr-3  text-sm uppercase  font-semibold text-dark">
    Stock Pending
   </span>
  </div>
</div>
<table style="width: 100%;" class="table table-striped table-bordered">
                        <tr>
                            <th class="text-center">
                            {{ label_case('No') }}
                           </th>
                          
                            <th>{{ label_case('Cabang') }}</th>
                            <th>{{ label_case('Karat') }}</th>
                            <th>{{ label_case('Weight') }}</th>
                            <th>{{ label_case('Aksi') }}</th>
                          
                        </tr>
                        @forelse(\Modules\Stok\Models\StockPending::get() as $stok)
                            @if($loop->index > 4)
                                                @break
                                            @endif



                            {{-- {{ $stok }} --}}

                           <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $stok->karat->name }}</td>
                            <td>{{ $stok->cabang->name }}</td>
                            <td>{{ $stok->weight }}</td>
                            <td>
                            @can('show_stock_pending_office')
                                <a id="Detail" href="{{ route('stok.view_pending', $stok) }}"
                                 class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-eye"></i> &nbsp;@lang('Detail')
                                </a>
                             @endcan
                            </td>
                            
                        </tr> 
                        @empty
                        <p>Tidak ada Data</p>
                        @endforelse
                        
                    </table>


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
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<style type="text/css">
    div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: 220px !important;
    }
    div.dataTables_wrapper div.dataTables_length select {
    width: 70px !important;
    display: inline-block;
    }
table.dataTable {
    clear: both;
    margin-top: 0.3rem !important;
    margin-bottom: 0.3rem !important;
    max-width: none !important;
    border-collapse: separate !important;
    border-spacing: 0;
}

.table th, .table td {
    padding: 0.3rem !important;
    vertical-align: top;
    border-top: 1px solid;
    border-top-color: #d8dbe0;
}

.table td {
      text-align: center !important;
}

div.dataTables_wrapper div.dataTables_paginate {
    margin: 0;
    white-space: nowrap;
    text-align: right;
    font-size: 0.7rem !important;
}

</style>
@endsection



<x-library.datatable />
@push('page_scripts')

  <script type="text/javascript">
        $('#datatable').DataTable({
           processing: true,
           serverSide: true,
           autoWidth: true,
           responsive: true,
           lengthChange: true,
            searching: true,
           "oLanguage": {
            "sSearch": "<i class='bi bi-search'></i> {{ __("labels.table.search") }} : ",
            "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per {{ __("labels.table.page") }} ",
            "sInfo": "{{ __("labels.table.showing") }} _START_ s/d _END_ {{ __("labels.table.from") }} <b>_TOTAL_ data</b>",
            "sInfoFiltered": "(filter {{ __("labels.table.from") }} _MAX_ total data)",
            "sZeroRecords": "{{ __("labels.table.not_found") }}",
            "sEmptyTable": "{{ __("labels.table.empty") }}",
            "sLoadingRecords": "Harap Tunggu...",
            "oPaginate": {
                "sPrevious": "{{ __("labels.table.prev") }}",
                "sNext": "{{ __("labels.table.next") }}"
            }
            },
            "aaSorting": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false,
                }
            ],
            "sPaginationType": "simple_numbers",
             ajax: "{{ route("buysback.nota.index_data") }}",
             dom: 'Blfrtip',
            buttons: [

                'excel',
                'pdf',
                'print'
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'date', name: 'date'},
                {data: 'invoice', name: 'invoice'},
                {data: 'cabang', name: 'cabang'},
                {data: 'status', name: 'status'},
              

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })
        .buttons()
        .container()
        .appendTo("#buttons");



    </script>

<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {
$(document).on('click', '#Tambah, #Detail, #Status', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah Stok');
        }
        if($(this).attr('id') == 'Status')
        {
            $('.modal-dialog').addClass('modal-md');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Status Stok');
        }

        if($(this).attr('id') == 'Detail')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-md');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Detail Stok Pending');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>










@endpush