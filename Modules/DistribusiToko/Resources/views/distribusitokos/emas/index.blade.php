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
            <div class="card">
                <div class="card-body">
               <div class="flex justify-between py-1 border-bottom">
                        <div>
                            <a class="btn btn-primary px-5 uppercase tracking-widest mb-2" href="{{ route('distribusitoko.emas.create') }}">
                                Input Distribusi <i class="bi bi-plus"></i>
                            </a>
                        </div>

                        <div id="buttons" class="px-1"> </div>

                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 6%!important;">No</th>
                                    <th>Tanggal</th>
                                    <th>No Invoice</th>
                                   <th style="width: 15%!important;" class="text-center">{{ __('Cabang') }}</th>
                                    <th style="width: 16%!important;" >{{ __('Karat') }}</th>

                                    <th style="width: 13%!important;" class="text-center">
                                         {{ __('Status') }}
                                    </th>
                                  
                                   
                                    <th style="width: 14%!important;" class="text-center">
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




@push('page_css')
<style type="text/css">
    table.dataTable {
    clear: both;
    margin-top: 2px !important;
    margin-bottom: 2px !important;
    max-width: none !important;
    border-collapse: separate !important;
    border-spacing: 0;
}
</style>
@endpush
@push('page_scripts')
   <script type="text/javascript">
        $('#datatable').DataTable({
           processing: true,
           serverSide: false,
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
             ajax: {
              url: "{{ route("$module_name.index_data") }}",
              data: function (d) {
                 d.status = $('#status').val(),
                 d.start_date =  $('.start_date').val(),
                 d.end_date = $('.end_date').val(),
                 d.search = $('input[type="search"]').val()
                }
              },
            dom: 'Blfrtip',
            buttons: [

            {
                    extend: 'excel',
                    exportOptions: {
                        columns: [ 0,1,2,3,4,5 ]
                    }
                },
               
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [ 0,1,2,3,4,5 ]
                    }
                }
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {data: 'date', name: 'date'},
                {data: 'no_invoice', name: 'no_invoice'},
                {data: 'cabang', name: 'cabang'},
                {data: 'karat', name: 'karat'},
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


    $('#status').change(function(){
        table.draw();
        var show_id = $(this).val();
        alert(show_id);
        console.log(show_id);
    });




    </script>

<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {
$(document).on('click', '#Tambah, #Edit', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case($module_title) }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-md');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case($module_title) }}');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });


function autoRefresh(){
      var table = $('#datatable').DataTable();
        table.ajax.reload();

         }

})(jQuery);
</script>


@endpush