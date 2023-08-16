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

{{$detail}}

<div class="px-0 py-1 grid grid-cols-2 gap-4 m-2 text-center no-underline">
    

       <div class="relative bg-white py-1 px-3 rounded-lg  my-4 shadow-xl">
           
            <div class="mt-2">
                <div class="text-xl text-left font-semibold my-2">{{tgl($detail->date)}}</div>
                <div class="flex space-x-2 text-gray-400 text-sm">
                   
                     <p>Berat Barang : {{$detail->berat_barang}}</p> 
                    
                </div>

                <div class="flex space-x-2 text-gray-400 text-sm my-3">
                  <p>Berat Real : {{$detail->berat_real}}</p> 
                </div>
             
            
            </div>
        </div>






       <div class="relative bg-white py-1 px-3 rounded-lg  my-4 shadow-xl">
           
            <div class="mt-2">
                <div class="text-xl text-left font-semibold my-2">{{$detail->code}}</div>
                <div class="flex space-x-2 text-gray-400 text-sm">
                    <!-- svg  -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                     <p>{{$detail->count}}</p> 
                </div>
               

<div class="flex justify-between">
  <div>01</div>

  <div>  
   <a
                         href="{{ route('products.add_produk_modal_from_pembelian', encode_id($detail->id)) }}"
                          id="GroupKategori"
                          data-toggle="tooltip"
                          class="btn btn-success btn-md px-3 py-1">
                            @lang('Add Detail')
                        </a> 


  </div>
</div>

            
            </div>
        </div>










</div>



    <div class="row">


        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                    {{--        <a href="{{ route(''.$module_name.'.create') }}"
                                id=""
                                data-toggle="tooltip"
                                 class="btn btn-primary px-3 py-1">
                                 <i class="bi bi-plus"></i>@lang('Add')&nbsp;
                                 {{ __($module_title) }}
                                </a>
 --}}
                        </div>
                        <div id="buttons">
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th style="width: 6%!important;">No</th>
                                    <th class="w-5 text-center">{{ __('Image') }}</th>
                                    <th style="width: 18%!important;"  class="text-left">{{ __('Date') }}</th>
                                   <th style="width: 15%!important;" class="text-center">{{ __('Code') }}</th>
                                    <th class="text-left">{{ __('Berat') }}</th>
                                    <th class="text-left">{{ __('Qty') }}</th>
                                    <th style="width: 6%!important;" class="text-center">{{ __('Detail') }}
                                    </th>
                                    <th style="width: 22%!important;" class="text-center">{{ __('Action') }}
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


<div id="ModalGroupKategori" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="ModalHeaderGroupkategori"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ModalContentGroupKategori"> </div>
         <div class="modal-footer" id="ModalFooterGroupKategori"></div>

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
            ajax: '{{ route("$module_name.get_produk") }}',
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

                {data: 'image', name: 'image'},
                {data: 'date', name: 'date'},
                {data: 'code', name: 'code'},
                {data: 'berat', name: 'berat'},
                {data: 'qty', name: 'qty'},
                {data: 'detail', name: 'detail'},


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
//group modal kategori

  $(document).on('click', '#GroupKategori', function(e){
         e.preventDefault();
          $('#ModalBacktoKategori').modal('hide');
          $("#ModalBacktoKategori").trigger("reset");
               $('#ModalKategori').modal('hide');
          $('#ModalKategori').modal('hide');
          $("#ModalKategori").trigger("reset");
         if($(this).attr('id') == 'GroupKategori')
         {

            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').addClass('modal-xl');
            $('#ModalHeaderGroupkategori').html('<i class="bi bi-grid-fill"></i> &nbspGroup {{ Label_case(' Kategori') }}');
        }
        $('#ModalContentGroupKategori').load($(this).attr('href'));
        $('#ModalGroupKategori').modal('show');
        $('#ModalGroupKategori').modal({
                        backdrop: 'static',
                        keyboard: true,
                        show: true
                });
    });


})(jQuery);
</script>
@endpush
