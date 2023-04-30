@extends('layouts.app')

@section('title', 'Karat')

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
   <a href="{{ route(''.$module_name.'.create') }}" class="btn btn-primary">
                            Add {{$module_title}}<i class="bi bi-plus"></i>
                        </a>
    </div>

  <div></div>
</div>

                        <div class="table-responsive mt-1">
                          <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th style="width: 5%!important;">
                                    NO
                                </th>

                                <th> Title </th>
                                <th> Value </th>
                                 <th style="width: 15%!important;" class="text-center">
                                    Updated
                                </th>
                                <th style="width: 15%!important;" class="text-center">
                                    Action
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

@push('page_scripts')
   <script type="text/javascript">
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: true,
            responsive: true,
            "aaSorting": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }],
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("$module_name.index_data") }}',
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {data: 'name', name: 'name'},
                {data: 'value', name: 'value'},
                 {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    </script>
@endpush
