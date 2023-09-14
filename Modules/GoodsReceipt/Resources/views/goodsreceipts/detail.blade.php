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

@push('page_css')
<style type="text/css">
.c-main {
    padding-top: 0.5rem!important;
}
.table th, .table td {
    padding: 0.5rem !important;
    vertical-align: top;
    border-top: 1px solid;
    border-top-color: #d8dbe0;
}


.checkbox {
  position: relative;
}

.checkbox [type="checkbox"] {
  position: absolute;
  visibility: hidden;
  pointer-events: none;
}

.checkbox [type="checkbox"] + label {
  position: relative;
  display: block;
  width: 15px;
  height: 15px;
  border: 2px solid;
  cursor: pointer;
  border-radius: 2px;
  will-change: color;
  transition: .2s color ease-in-out;
}

table thead .checkbox [type="checkbox"] + label:hover,
table thead .checkbox [type="checkbox"] + label:hover:after {
  color: #e73e9d;
}

table tbody .checkbox [type="checkbox"] + label:hover,
table tbody .checkbox [type="checkbox"] + label:hover:after {
  color: #701347;
}

.checkbox [type="checkbox"] + label:after {
  content: '';
  position: absolute;
  width: 5px;
  height: 12px;
  top: 60%;
  left: 50%;
  border-bottom: 2px solid;
  border-right: 2px solid;
  margin-top: -2px;
  opacity: 0;
  transform: translate(-50%, 0%) rotate(45deg) scale(.75);
  will-change: opacity, transform, color;
  transition: .17s opacity ease-in-out, .2s transform ease-in-out, .2s color ease-in-out;
}

.checkbox [type="checkbox"]:checked + label:after {
  opacity: 1;
  transform: translate(-50%, -50%) rotate(45deg) scale(1);
}

.dataTables_wrapper .dataTables_processing {
position: absolute;
top: 55% !important;
  background: transparent !important;
  border: none;
  font-weight: bold;
}

</style>
@endpush
<div class="container-fluid">


   <div class="text-lg bg-white flex justify-between w-full px-2 py-3">
        <div class="px-3 py-2">
   
            <div class="mt-3 text-gray-600">No Penerimaan Barang</div>
            <h3 class="font-medium text-gray-900 uppercase font-medium font-semibold">{{ $detail->code }}</h3>
        </div>
          <div class="px-6 py-2">

   <div class="flex flex-row justify-end">
        <a class="flex" href="{{ route('goodsreceipt.index') }}">
            <div class="flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
                <i class="bi bi-house text-gray-600"></i>
            </div>
        </a>
        <a class="flex" target="_blank"
            id="Save"
            href="{{ route(''.$module_name.'.cetak',encode_id($detail->id)) }}">
            <div class="flex h-8 w-8 items-center justify-center p-2 rounded-full border border-muted bg-muted">
                <i class="bi bi-printer text-gray-600"></i>
            </div>
        </a>
    </div>

      <div class="mt-0 text-gray-600">Supplier</div>
         <div class="leading-5 mt-0 font-semibold text-gray-500">{{ $detail->supplier->supplier_name }}</div>
         <div class="leading-5 text-gray-500">{{ $detail->supplier->address }}</div>

        </div>
    </div>


<div class="bg-white grid grid-cols-3 gap-4">

  <div class="text-gray-600 px-2 py-2">
  

<div class="text-sm px-3 py-2 poppins">
 <div class="flex justify-between w-full py-1">
                <p class="text-gray-600">{{ Label_case('tanggal') }}</p>
                <p class="text-gray-900">{{ tanggal($detail->date) }}</p>
            </div>
           <div class="flex justify-between w-full py-1">
                <p class="poppins text-gray-600">{{ Label_case('no_invoice') }}</p>
                <p class="poppins dark:text-gray-300 text-gray-800">{{ $detail->no_invoice }}</p>
            </div>
  <div class="flex justify-between w-full py-1">
                <p class="poppins text-gray-600">{{ Label_case('total_berat_kotor') }}</p>
                <p class="poppins font-semibold text-blue-800">{{ $detail->total_berat_kotor }}
                   <small class="text-gray-700">Gram</small></p>
            </div>
  <div class="flex justify-between w-full py-1">
                <p class="poppins text-gray-600">{{ Label_case('berat_timbangan') }}</p>
                <p class="poppins font-semibold text-green-800">{{ $detail->berat_timbangan }}
                    <small class="text-gray-700">Gram</small></p>
            </div>


    <div class="flex justify-between w-full py-1">
                <div class="poppins text-gray-600">
                    <div> {{ Label_case('Total_Emas') }}</div>
                   <div style="font-size:0.7rem !important;" class="mt-0 small text-blue-600">Total Emas yg harus di bayar
                   </div>

                </div>
                <div class="mt-2 poppins font-semibold text-gray-800">{{ $detail->total_emas }}</div>
            </div>

  @if($detail->selisih)
<div class="flex justify-between w-full py-1">
    <p class="poppins text-gray-600">{{ Label_case('selisih') }}</p>
    <div style="font-size: 0.7rem !important;" class="poppins text-gray-800">
        <div> Gram : {{ $detail->selisih }}</div>
        
    </div>
</div>
  @endif




    <div class="flex justify-between w-full py-1">
                <p class="poppins text-gray-600">{{ Label_case('Tipe Pembayaran') }}</p>
      @if($detail->pembelian[0]->tipe_pembayaran =='cicil')
     <p class="poppins text-gray-800">
       Cicilan : {{ $detail->pembelian[0]->cicil }} Kali</p>
    </div>
      @elseif($detail->pembelian[0]->tipe_pembayaran =='jatuh_tempo')
 <div style="font-size:0.7rem !important;" class="poppins text-gray-800">
    <div> Jatuh Tempo : </div>
    <div>{{ tgl($detail->pembelian[0]->jatuh_tempo) }}</div>
      
   </div>
    </div>
    @endif
         <div class="flex justify-between w-full py-1">
                <p class="poppins text-gray-600">{{ Label_case('pengirim') }}</p>
                <p class="poppins dark:text-gray-300 text-gray-800">{{ $detail->pengirim }}</p>
            </div>

             <div class="flex justify-between w-full py-1">
                <p class="poppins text-gray-600">{{ Label_case('penerima') }}</p>
                <p class="poppins dark:text-gray-300 text-gray-800">
                    {{ @$detail->user->name }}</p>
            </div>


</div>




  </div>






  <div class="text-gray-600 col-span-2 px-2 py-2 border-l">


       <div class="card-body">


                <div class="flex items-center">
                    <h4
                    class="flex-shrink-0 pr-4 bg-white text-sm leading-5 tracking-wider font-semibold uppercase text-teal-600">
                   Item
                    </h4>
                    <div class="flex-1 border-t-2 border-gray-200">
                    </div>
                </div>

                    <div class="text-gray-600 table-responsive mt-1">

                  

<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th class="text-center">No</th>
      <th class="text-center">Kategori</th>
      <th class="text-center">Karat</th>
      <th class="text-center">Berat Real</th>
      <th class="text-center">Berat Kotor</th>
    </tr>
  </thead>
  <tbody>

 @foreach($detail->goodsreceiptitem as $row)
   <tr>
      <th class="text-center">{{$loop->iteration}}</th>
      <td class="text-center"> {{$row->mainkategori->name}}</td>
      <td class="text-center"> {{$row->karat->kode}} | {{$row->karat->name}}</td>
      <td class="text-center"> {{$row->berat_real}}</td>
      <td class="text-center"> {{$row->berat_kotor}}</td>
    
    </tr>
@endforeach

  

  </tbody>
</table>


                    </div>
                </div>



  </div>
</div>




  {{--   {{ $detail }} --}}



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

            "sprocessing": "<span class='fa-stack fa-lg'>\n\
                            <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
                       </span>&emsp;Processing ...",
            "sSearch": "<i class='bi bi-search'></i> {{ __("labels.table.search") }} : ",
            "sLengthMenu": "_MENU_ &nbsp;&nbsp; ",
            "sInfo": "{{ __("labels.table.showing") }} _START_ s/d _END_ {{ __("labels.table.from") }} <b>_TOTAL_ data</b>",
            "sInfoFiltered": "(filter {{ __("labels.table.from") }} _MAX_ total data)",
            "sZeroRecords": "{{ __("labels.table.not_found") }}",
            "sEmptyTable": "{{ __("labels.table.empty") }}",
            "sLoadingRecords": "Harap Tunggu...",
            "oPaginate": {
                "sPrevious": "{{ __("Prev") }}",
                "sNext": "{{ __("Next") }}"
            }
            },
            "aaSorting": [[ 0, "desc" ]],
     
            'columnDefs': [
                     {
                        "targets": 'no-sort',
                        "orderable": false,
                        'checkboxes': {
                           'selectRow': true,
                           'selectCallback': function(){
                              printSelectedRows();
                           }
                        }
                     }
                  ],
                  'select': {
                     'style': 'multi'
                  },
            "sPaginationType": "simple_numbers",
            ajax: '{{ route("$module_name.index_data_product",$detail->code) }}',
            dom: 'Blfrtip',
            buttons: [

                // 'excel',
                // 'pdf',
                // 'print'
            ],
            columns: [{
                    "data": 'id',
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'checkbox', name: 'checkbox'},
                {data: 'image', name: 'image'},
                {data: 'name', name: 'name'},
                {data: 'qty', name: 'qty'},
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

// Print 
function printSelectedRows(){
   var rows_selected = $('#datatable').DataTable().column(0).checkboxes.selected();

   // Output form data to a console     
   $('#example-console-rows').text(rows_selected.join(","));
};

    </script>


<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {
$(document).on('click', '#GroupKategori, #DetailProduk', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'GroupKategori')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah Product');
        }
        if($(this).attr('id') == 'DetailProduk')
        {
            $('.modal-dialog').addClass('modal-xl');
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-dialog').removeClass('modal-lg');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Detail Product');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });



$(document).ready(function() {
  var $selectAll = $('#selectAll'); 
  var $table = $('#datatable');
  var $tdCheckbox = $table.find('tbody input:checkbox'); 
  var tdCheckboxChecked = 0; 

  $selectAll.on('click', function () {
    $tdCheckbox.prop('checked', this.checked);
  });

  
  $tdCheckbox.on('change', function(e){
    tdCheckboxChecked = $table.find('tbody input:checkbox:checked').length; 
    $selectAll.prop('checked', (tdCheckboxChecked === $tdCheckbox.length));
  })
});


})(jQuery);
</script>



@endpush