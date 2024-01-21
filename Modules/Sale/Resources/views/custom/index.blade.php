@extends('layouts.app')
@section('title', 'Custome')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Custome</li>
</ol>
@endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                    <div class="flex justify-between">
                    <p class="uppercase text-lg text-gray-600 font-semibold">
                      Data <span class="text-yellow-500 uppercase">CUSTOM</span>
                        {{-- <span class="text-gray-400 uppercase">{{ $type }}</span> --}}
                    </p>
                    </div>

                    @php
                    $users = Auth::user()->id;
                    @endphp
  
                    @if($users == 1)
                    <div class="form-group px-4">
                      <select class="form-control form-control-sm select2" data-placeholder="Pilih Cabang" tabindex="1" name="cabang_id" id="cabang_id">
                          <option value="">Pilih Cabang</option>
                             @foreach($cabangs as $k)
                              <option value="{{$k->id}}" {{ old("id") == $k ? 'selected' : '' }}>{{$k->name}}</option>
                          @endforeach
                      </select>
                    </div>
                    @else
                     <p class="uppercase text-lg text-gray-600 font-semibold">
                       &nbsp;| {{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }} 
                    </p>
                   
                    @endif
                    </div>  
  
                    <div class="w-full md:overflow-x-scroll lg:overflow-x-auto mt-1">
                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover md:table-sm lg:table-sm table-responsive-sm">
                        <thead>
                            <tr>
                                <th style="width: 3%!important;">No</th>
                                <th style="width: 20%!important;" class="text-center">{{ __("Date") }}</th>
                                <th style="width: 11%!important;" class="text-center">{{ __('Berat') }}</th>
                                <th style="width: 11%!important;" class="text-center">{{ __("Harga") }}</th>
                                <th style="width: 19%!important;" class="text-center">{{ __('Jenis Barang') }}</th>
                                <th style="width: 18%!important;" class="text-center">{{ __('Total') }}</th>
                                <th style="width: 18%!important;" class="text-center"> {{ __('Action') }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customs as $custom)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($custom['created_at'])->format('d/m/Y') }}</td>
                                    <td>{{ $custom['berat'] }}</td>
                                    <td>{{ $custom['harga'] }}</td>
                                    <td>{{ $custom['jenis_barang'] }}</td>
                                    <td>{{ $custom['total'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ __('Action') }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Hasil</a>
                                                <a class="dropdown-item" href="#">Proses</a>
                                                <!-- ... tambahkan pilihan lainnya jika diperlukan ... -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
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
    jQuery.noConflict();
      (function( $ ) {
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
        
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [ 0,1,2,3,4 ]
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [ 0,1,2,3,4 ]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [ 0,1,2,3,4 ]
                    }
                }
            ],
            data: @json($customs),
            },
            columns: [
                {
                    data : 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'berat',
                    searchable: false,
                    name: 'berat'
                },
                {
                    data: 'harga',
                    orderable: false,
                    name: 'harga'
                },
                {
                    data: 'jenis_barang',
                    name: 'jenis_barang'
                },
                {
                    data: 'total',
                    name: 'total'
                }
            ]
        })
        .buttons()
        .container()
        .appendTo("#buttons");

 
     })(jQuery);
    </script>



<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {
    $( document ).ready(function() {
        var idSales;
    });
   
$(document).on('click', '#Tambah, #Edit, #Show', function(e){
         e.preventDefault();
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });

    $(document).on("click", "#btn-dp", function (e) {

        e.preventDefault();
        var _self = $(this);
        idSales = _self.data('id');
    });

    // A $( document ).ready() block.
    $( document ).ready(function() {
        $(document).on('shown.bs.modal', '#pembayaran_dp', function (e) {
            Livewire.emit('setSaleId', idSales)
        })
    });

})(jQuery);
</script>
@endpush