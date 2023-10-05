@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{$module_title}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

<div class="px-0 py-1 grid grid-cols-3 gap-4 m-2 mt-0 mb-2 text-center no-underline">
    
    <div class="bg-white card-body p-0 d-flex align-items-center border shadow">
        <div class="bg-gradient-success p-4 mfe-3 rounded-left">
            <i class="bi bi-currency-dollar text-3xl"></i>
        </div>
        <div>
            <div class="text-value font-semibold text-lg text-success">122</div>
            <div class="text-gray-600 text-uppercase font-weight-bold text-md">
                TOTAL NOMINAL
            </div>
        </div>
    </div>
    <div class="bg-white card-body p-0 d-flex align-items-center border shadow">
        <div class="bg-gradient-danger p-4 mfe-3 rounded-left">
            <i class="bi bi-wallet-fill text-3xl"></i>
           
        </div>
        <div>
            <div class="text-xl font-semibold text-value text-success">22</div>
            <div class="text-md text-gray-600 text-uppercase font-weight-bold">
               TOTAL BERAT
            </div>
            <i class="bi bi-suitcase-lg"></i>
        </div>
    </div>
    <div class="bg-white card-body p-0 d-flex align-items-center  border shadow">
        <div class="bg-gradient-warning p-4 mfe-3 rounded-left">
            <i class="bi bi-map-fill text-3xl"></i>

        </div>
        <div>
            <div class="text-md font-semibold text-value text-success">Filter /Cabang</div>
            <div class="text-gray-600 text-uppercase font-weight-bold text-lg">
        
            </div>
        </div>
    </div>
</div>



            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                           <a href="{{ route(''.$module_name.'.create') }}"
                                id="Add"
                                data-toggle="tooltip"
                                 class="btn bg-green-600 uppercase  text-white px-3">
                                 <i class="bi bi-plus"></i>
                                 @lang('Tambah Penerimaan Barang Luar')
                                </a>

                             <a href="{{ route(''.$module_name.'.index_insentif') }}"
                                id="Add"
                                data-toggle="tooltip"
                                 class="btn bg-green-600 uppercase text-white px-3">
                                 <i class="bi bi-plus"></i>
                                 Insentif
                                </a>

                        </div>
                        
                        <div id="buttons">
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 5%!important;">No</th>
                                    <th style="width: 9%!important;">No Barang Luar</th>
                                    <th style="width: 10%!important;">Detail Produk</th>
                                   
                             <th style="width: 10%!important;">Status</th>
                             <th style="width: 10%!important;">Nominal Beli</th>
                                  
                                    <th style="width: 10%!important;" class="text-center">
                                        {{ __('Action') }}
                                    </th>
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

                {data: 'no_barang_luar', name:  'no_barang_luar'},
                {data: 'nama_produk', name: 'nama_produk'},
                {data: 'status', name: 'status'},
            
                {data: 'nominal_beli', name: 'nominal_beli'},
           

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
$(document).on('click', '#Tambah, #Edit, #Status', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }  

        if($(this).attr('id') == 'Status')
        {
            $('.modal-dialog').addClass('modal-md');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Status {{ Label_case($module_title) }}');
        }


        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>
@endpush