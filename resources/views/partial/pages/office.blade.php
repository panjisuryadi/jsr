<div class="flex gap-1">







  <div class="w-3/4">

  <div class="flex flex-row grid grid-cols-3 gap-2 mt-1">  
<div class="card border-0">
    <div class="card-body p-0 d-flex align-items-center shadow-sm">
        <div class="bg-gradient-primary p-4 mfe-3 rounded-left">
            <i class="bi bi-bar-chart font-2xl"></i>
        </div>
        <div>
            <div class="text-value text-primary">77</div>
            <div class="text-muted text-uppercase font-weight-bold small">
            menu office
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
            <div class="text-value text-success">20</div>
            <div class="text-muted text-uppercase font-weight-bold small">
            menu office
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
            <div class="text-value text-warning">20</div>
            <div class="text-muted text-uppercase font-weight-bold small">
            menu office
            </div>

        </div>
    </div>
</div>



</div>

<div class="card">
    <div class="card-body">
        <div class="flex justify-between py-1 border-bottom">
            <div>
             <span class="font-semibold text-gray-600 text-lg">Buys Back Nota</span> 
            </div>
            <div id="buttons">
            </div>
        </div>
        <div class="table-responsive mt-1">
            <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th style="width: 6%!important;">No</th>
                        <th>Date</th>
                        <th>No Invoice</th>
                        <th style="width: 15%!important;" class="text-center">{{ __('Cabang') }}</th>
                        <th>{{ __('Karat') }}</th>
                        <th style="width: 16%!important;" class="text-center">
                            {{ __('Status') }}
                        </th>
                        
                        
                        <th style="width: 14%!important;" class="text-center">
                            {{ __('Action') }}
                        </th>
                    </tr>
                </thead>
            </table>
        </div>

<hr>




    </div>
</div>

  </div>



  <div class="w-1/4 card">
<div class="card-body">
    <div class="form-group">
        <label for="image">Users Info <span class="text-danger">*</span></label>
        <img style="width: 100px;height: 100px;" class="d-block mx-auto img-thumbnail img-fluid rounded-circle mb-2" src="{{ auth()->user()->getFirstMediaUrl('avatars') }}" alt="Profile Image">
        
<div class="flex items-center justify-center">
    <div class="font-weight-bold py-1 px-2 text-lg">{{ ucfirst(auth()->user()->name) }}</div>
   
</div>
<div class="flex items-center justify-center">
    
     <div class="text-gray-500">
      Roles : {{ ucfirst(Auth::user()->roles->first()->name) }} 
    </div>
   
</div>
<div class="flex items-center justify-center">
    
   
    <div class="text-blue-400">
        Cabang : {{ Auth::user()->namacabang?ucfirst(Auth::user()->namacabang->cabang()->first()->name):'' }}
    </div>
</div>

    </div>
</div>




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



    </script>

@endpush