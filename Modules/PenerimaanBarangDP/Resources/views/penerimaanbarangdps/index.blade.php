@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Penerimaan Barang DP</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

<div class="px-0 py-1 grid grid-cols-3 gap-4 m-2 mt-0 mb-2 text-center no-underline">
    



    <div class="bg-white card-body p-0 d-flex align-items-center border shadow cursor-pointer hover:zoom-1">
        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
            <i class="bi bi-badge-8k text-3xl"></i>
        </div>
        <div>
            <div class="text-value font-semibold text-lg text-gray-600">
              122
            </div>
            <div class="text-gray-400 font-weight-bold text-md">
               Total Karat
            </div>
        </div>
    </div>   

     <div class="bg-white card-body p-0 d-flex align-items-center border shadow cursor-pointer hover:zoom-1">
        <div class="bg-gradient-info p-4 mfe-3 rounded-left">
            <i class="bi bi-badge-8k text-3xl"></i>
        </div>
        <div>
            <div class="text-value font-semibold text-lg text-gray-600">
              122 <small class="text-muted">GRAM</small>
            </div>
            <div class="text-gray-400 font-weight-bold text-md">
               Total Berat
            </div>
        </div>
    </div>


     <div class="bg-white card-body p-0 d-flex align-items-center border shadow cursor-pointer hover:zoom-1">
        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
            <i class="bi bi-badge-8k text-3xl"></i>
        </div>
        <div>
            <div class="text-value font-semibold text-lg text-gray-600">
              <small class="text-muted">Rp</small> 120.000.000
            </div>
            <div class="text-gray-400 font-weight-bold text-md">
               Total Nominal DP
            </div>
        </div>
    </div>



</div>







            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                           <a href="{{ route(''.$module_name.'.create') }}"
                                id="Tambah"
                                data-toggle="tooltip"
                                 class="btn btn-outline-secondary px-3">
                                 <i class="bi bi-plus"></i>@lang('Add')&nbsp;Penerimaan Barang DP
                                </a>

                        </div>
                        <div id="buttons">
                        </div>
                    </div>
                    <div class="table-responsive mt-1">

{{-- 
1.no barang
2.tanggal 
3.nama konsumen
4.cabang
5.nama produk
6.kadar
7.berat
8.nominal dp
9.pengambilan jatuh tempo
10.status
11.aksi 
--}}


                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                  <th style="width: 4%!important;">No</th>
<th class="text-center">{{ Label_Case('No Barang') }}</th>
<th class="text-center">{{ Label_Case('Tanggal') }}</th>
<th class="text-center">{{ Label_Case('Nama Konsumen') }}</th>
<th class="text-center">{{ Label_Case('cabang') }}</th>
<th class="text-center">{{ Label_Case('nama produk') }}</th>
<th class="text-center">{{ Label_Case('kadar') }}</th>
<th class="text-center">{{ Label_Case('berat') }}</th>
<th class="text-center">{{ Label_Case('nominal') }}</th>
<th class="text-center">{{ Label_Case('pengambilan jatuh tempo') }}</th>
<th class="text-center">{{ Label_Case('status') }}</th>
<th style="width: 10%!important;" class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
            ajax: '{{ route("$module_name.index_data") }}',
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

                {data: 'no_barang_dp', name: 'no_barang_dp'},
                {data: 'cabang', name: 'cabang'},
                {data: 'nama_pemilik', name: 'nama_pemilik'},
                {data: 'kadar', name: 'kadar'},
                {data: 'berat', name: 'berat'},
                {data: 'berat', name: 'berat'},
                {data: 'berat', name: 'berat'},
                {data: 'berat', name: 'berat'},
                {data: 'berat', name: 'berat'},
                {data: 'nominal_dp', name: 'nominal_dp'},
           

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

</script>
@endpush