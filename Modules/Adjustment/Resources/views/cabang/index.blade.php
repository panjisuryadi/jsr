@extends('layouts.app')

@section('title', 'Adjustments Pending Office')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('adjustments.index') }}">@lang('Stock Opname')</a></li>
        <li class="breadcrumb-item"> @lang('Cabang')</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
    <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="text-value-md">Status Stok Opname</div>
                        <div class="text-value-lg my-2" id="status">Sedang Berjalan</div>
                        <div class="progress progress-xs my-3">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="text-value-md">Lokasi Stok Opname</div>
                        <div class="text-value-lg my-2">{{$location}}</div>
                        <div class="progress progress-xs my-3">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="justify-content: space-between;display:flex;">
                        <div>
                            <a href="{{ route('adjustment.cabang.create') }}" class="btn btn-primary mr-2">
                              @lang('Stock Opname Manual')  <i class="bi bi-plus"></i>
                            </a>
                        </div>
                        <div>
                            <a href="javascript:;" class="btn btn-primary" id="stopAdjustment">
                              @lang('Stop Adjustment') 
                            </a>
                        </div>
                        </div>

                        <div class="pt-2 pb-2">
                            <hr>
                        </div>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered dataTable no-footer">
                                <thead>
                                    <th>Date</th>
                                    <th>Reference</th>
                                    <th>Total Product</th>
                                    <th>Summary</th>
                                    <th>Action</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('adjustment::partials.modal')
@endsection

@push('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript" src="{{ asset('js/export/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/export/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/export/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/export/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/export/buttons.html5.min.js') }}"></script>

<script>
    $(function(){
        datatable()
    })
    function datatable(){
        $('#datatable').DataTable({
                destroy: true,
            }).destroy();

            $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                language: {
                    sEmptyTable:   "Tidak ada data yang tersedia pada tabel ini",
                    sProcessing:   "Sedang memproses...",
                    sLengthMenu:   "Tampilkan _MENU_ data",
                    sZeroRecords:  "Tidak ditemukan data yang sesuai",
                    sInfoFiltered: "(disaring dari _MAX_ data keseluruhan)",
                    sInfoPostFix:  "",
                    sSearch:       "Cari:",
                    sUrl:          "",
                },
                dom: "<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>>'tr'<'row'<'col-md-5'i><'col-md-7 mt-2'p>>",
                buttons: [
                    {
                        text: '<i class="bi bi-file-earmark-excel-fill"></i> Excel',
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="bi bi-file-earmark-pdf-fill"></i> PDF',
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="bi bi-printer-fill"></i> Print',
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="bi bi-x-circle"></i> Reset',
                        action: function () {
                            $('#your-datatable-id').DataTable().search('').columns().search('').draw();
                        }
                    },
                    {
                        text: '<i class="bi bi-arrow-repeat"></i> Reload',
                        action: function () {
                            $('#datatable').DataTable().ajax.reload(null, false);
                        }
                    }
                ],
                ajax: {
                    url:'/adjustments/pending-office/getdata',
                    type:"GET",
                },
                columns: [
                    { data: 'date', name: 'date' },
                    { data: 'reference', name: 'reference' },
                    { data: 'product', name: 'product' },
                    { data: 'summary', name: 'summary' },
                    { data: 'action', name: 'action' },
                ], 
                columnDefs: [
                    { 
                        width: "10", 
                        targets: [4]
                    },
                ],
                order : [
                    [0,'desc']
                ]
            });
    }

    $('#stopAdjustment').click(function(){
        $('#stopAdjustmentModal').modal('show')
    })

    function stopAdjustment(){
        $.ajax({
            type: "GET",
            url: "{{route('adjustment.stop')}}",
            dataType:'json',
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                window.location.href = data.redirectRoute;
                toastr.success('Stock Opname Berhasil Dihentikan')
            }
        })
    }
    </script>
@endpush



@push('page_css')
 <style type="text/css">

.aksi{
   width: 12% !important;
}
.tgl{
   width: 10% !important;
}

   </style>
   
 <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@endpush
