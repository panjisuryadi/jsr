<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between">
                    <h2 class="text-lg font-bold uppercase">Penerimaan Barang BuyBack - Barang Luar</h2>
                </div>
            </div>
            <div class="card-body">
                <div class="flex justify-between py-1 border-bottom">

                    <div>

                        @if(auth()->user()->isUserCabang())
                        <div class="btn-group btn-group-md">
                            @can('create_buybacktoko')
                            <a href="#" data-toggle="tooltip" class="btn btn-primary btn-md px-3" onclick="createModal()">
                                <i class="bi bi-plus"></i>
                                {{ __('BuyBack Item') }}
                            </a>
                            @endcan
                        </div>
                        <div class="btn-group btn-group-md">
                            <a href="#" data-toggle="tooltip" class="btn btn-primary btn-md px-3" onclick="createBarangLuar()">
                                <i class="bi bi-plus"></i>
                                {{ __('Outside Item') }}
                            </a>
                        </div>
                        @endif



                    </div>
                </div>


                <div class="table-responsive mt-1">
                    <table id="goodsreceipt-buyback-barangluar-item-datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th style="width: 3%!important;">No</th>
                                <th style="width: 10%!important;">Tanggal</th>
                                <th style="width: 16%!important;">Produk</th>
                                <th style="width: 10%!important;">Tipe</th>
                                <th style="width: 17%!important;">Customer</th>
                                <th style="width: 10%!important;">Status</th>
                                <th style="width: 10%!important;">Nominal</th>

                                <th style="width: 15%!important;" class="text-center">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @livewire('goods-receipt.toko.buy-back.item.modal.create')
    @livewire('goods-receipt.toko.barang-luar.item.modal.create')
</div>

<x-library.datatable />

@push('page_scripts')
<script type="text/javascript">
        $('#goodsreceipt-buyback-barangluar-item-datatable').DataTable({
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
                    "visible": false,
                }
            ],
           
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("$module_name.toko.buyback-barangluar.index_data_item") }}',
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
                {data: 'barang', name: 'barang'},
                {data: 'tipe', name:'tipe'},
                {data: 'customer', name:  'customer'},
             
              
                {data: 'status', name: 'status'},
                {data: 'nominal', name: 'nominal'},
              

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        })
        .buttons().remove()
        .container()



    </script>
@endpush