@extends('layouts.app')

@section('title', ''.$module_title.' Details')

@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("datasale.index") }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item ">{{$detail->name}}</li>
    <li class="breadcrumb-item active">{{$module_action}}</li>
</ol>
@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- component -->
            <div class="px-5 py-5">
                <div class="w-full">
                    <div class="-mx-2 md:grid grid-cols-3 grid-rows-2 mb-4 gap-y-4">
                        <div class="w-full h-full px-2 row-span-2">
                            <div class="h-full rounded-lg shadow-sm">
                                <div class="h-full rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-5 pt-8 pb-10 relative z-10">
                                        <h2 class="font-bold text-3xl text-gray-700 mb-4 tracking-wide"> {{ $detail->name }}</h2>
                                        @if ($detail->address)
                                        <p class="text-lg text-gray-500 font-medium"> <i class="cil-location-pin"></i> {{ $detail->address }}</p>
                                        @endif
                                        @if ($detail->phone)
                                        <p class="text-lg text-gray-500 font-medium"> <i class="cil-phone"></i> {{ $detail->phone }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg shadow-sm">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Target Penjualan</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">{{ formatBerat($detail->target) }} gram</h3>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart1" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2 relative">
                            <div class="absolute right-5 top-2 z-20">
                                <a id="modal-insentif" href="{{ route(''.$module_name.'.edit_insentif', ['id' => $detail->id]) }}" class="btn btn-outline-nfo btn-sm">
                                    <i class="bi bi-pencil"></i> &nbsp;@lang('Update')
                                </a>
                            </div>
                            <div class="rounded-lg shadow-sm">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Insentif</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">Rp. {{ rupiah($detail->insentif->nominal??0) }}</h3>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart1" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full px-2">
                            <div class="rounded-lg shadow-sm">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Jumlah Penjualan</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">{{ $detail->penjualanSale->sum('total_weight') }} gram</h3>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart1" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <div class="rounded-lg shadow-sm">
                                <div class="rounded-lg bg-white shadow-lg md:shadow-xl relative overflow-hidden">
                                    <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                        <h4 class="text-sm uppercase text-gray-500 leading-tight">Total Stock</h4>
                                        <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">{{ $detail->stockSales->sum('weight') }} gram</h3>
                                    </div>
                                    <div class="absolute bottom-0 inset-x-0">
                                        <canvas id="chart2" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                   
                </div>
                <div class="card">
                    <div class="card-body">
                    <div class="table-responsive mt-1">
                        <table id="penjualan_table" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 3%!important;">No</th>

                                    <th style="width: 15%!important;" class="text-center">{{ Label_Case('date') }}</th>
                                    <th style="width: 15%!important;" class="text-center">{{ Label_Case('store_name') }}</th>
                                    <th style="width: 10%!important;" class="text-center">{{ Label_Case('total_weight') }}</th>
                                    <th style="width: 10%!important;" class="text-center">{{ Label_Case('total_nominal') }}</th>
                                    <th style="width: 10%!important;" class="text-center">{{ Label_Case('created_by') }}</th>

                                    <th style="width: 18%!important;" class="text-center"> {{ __('Action') }} </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    </div>
                </div>

                <div class="card w-full">
                    <div class="card-body">
                    <div class="table-responsive mt-1">
                        <table id="stock_table" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 3%!important;">No</th>

                                    <th style="width: 15%!important;" class="text-center">{{ Label_Case('karat') }}</th>
                                    <th style="width: 15%!important;" class="text-center">{{ Label_Case('berat') }}</th>

                                    <th style="width: 18%!important;" class="text-center"> {{ __('Action') }} </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</div>
@endsection

@push('page_css')
<style>
    .dt-buttons{
        float: initial !important;
        width: fit-content;
        margin-left: auto;
        margin-bottom: 2rem;
    }
</style>
    
@endpush
<x-library.datatable />
@push('page_scripts')
   <script type="text/javascript">
        $('#penjualan_table').DataTable({
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
            },
            },
            "aaSorting": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false,
                }
            ],
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("$module_name.show_data", $detail) }}',
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
                {data: 'store_name', name: 'store_name'},
                {data: 'total_weight', name: 'total_weight'},
                {data: 'total_nominal', name: 'total_nominal'},
                {data: 'created_by', name: 'created_by'},

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



        $('#stock_table').DataTable({
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
            },
            },
            "aaSorting": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": 'no-sort',
                    "orderable": false,
                }
            ],
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("$module_name.show_stock", $detail) }}',
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

                {data: 'karat', name: 'karat'},
                {data: 'berat', name: 'berat'},

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
$(document).on('click', '#Tambah, #modal-insentif', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }
        if($(this).attr('id') == 'modal-insentif')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>
@endpush