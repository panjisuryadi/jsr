    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                     <div>
                       <p class="uppercase text-lg text-gray-600 font-semibold">
                      Stok 
                      <span class="text-yellow-500 uppercase">{{$module_action}}</span>
                        </p>
                        </div>
                        <div></div>
                    </div>
                    <div class="flex justify-between">
                            <div class="card">
                                <div class="card-body font-semibold">
                                    <p>Info Stok</p>
                                    <p>Karat : <span id="karat"></span></p>
                                    <p>Sisa Stok : <span id="sisa-stok"></span></p>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="karat_filter" class="font-bold">Pilih Karat</label>
                                <select name="karat_filter" id="karat_filter" class="form-control">
                                    @foreach ($datakarat as $karat )
                                    <option value="{{$karat->id}}">{{ $karat->name }} | {{$karat->kode}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    <div class="table-responsive mt-1">

                        <table id="datatable" style="width: 100%" class="table table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                <th style="width: 6%!important;">No</th>
                                <th class="text-left">{{ Label_Case('Image') }}</th>
                                <th class="text-left">{{ Label_Case('Product') }}</th>
                                <th class="text-left">{{ Label_Case('Karat') }}</th>
                                <th class="text-left">{{ Label_Case('weight') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<x-library.datatable />
@push('page_scripts')
   <script type="text/javascript">
    $(function(){
        datatable()
        getStockInfo()
    })

    function datatable(){
        $('#datatable').DataTable({
            destroy: true,
        }).destroy();
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
            ajax: '{{ route("$module_name.index_data_pending") }}?karat='+$('#karat_filter').val(),
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
                {data: 'product', name: 'product'},
                {data: 'karat', name: 'karat'},
                {data: 'weight', name: 'weight'},
              
            ]
        })
        .buttons().remove()
        .container()
        .appendTo("#buttons");
    }


        $('#karat_filter').change(function(){
            datatable()
            getStockInfo()
        })

        function getStockInfo(){
        $.ajax({
            type: "get",
            url: '{{ route("$module_name.get_stock_pending") }}?karat='+$('#karat_filter').val(),
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept' : 'application/json'
            },
            success: function(data){
                $('#karat').text(data.karat)
                $('#sisa-stok').text(data.sisa_stok + ' gr')
            }
        })
    }


    </script>

@endpush