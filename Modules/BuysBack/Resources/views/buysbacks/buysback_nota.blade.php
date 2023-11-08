@extends('layouts.app')
@section('title', 'Create Buys Back')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("buysback.index") }}">{{__('Buys Back')}}</a></li>
    <li class="breadcrumb-item active">Add</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">

    
    <form action="{{ route('buysback.store') }}" method="POST">
        @csrf
        <div class="row">

            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">

<div class="flex relative py-3">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Buys Back Nota')}} &nbsp;<i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Buys back Nota')}}"></i>
        </span> 
    </div>
</div>

{{-- batas --}}

<div class="flex flex-row grid grid-cols-1 gap-2">
    
<div class="rounded-md border px-3 py-2">
    <div class="font-semibold mb-2 border-bottom pb-2">Invoice Info: </div>
    <div>Invoice: <strong>DIST-TOKO-00002</strong></div>
    <div>Tanggal Distribusi: <strong> 03 Nov, 2023</strong></div>
    <div>Tanggal Retur: <strong> 03 Nov, 2023</strong></div>
    <div>Cabang: <strong>PUSAT</strong></div>
   
</div>




</div>


<div class="flex relative px-2 py-3 pb-3">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">
            <span class="text-green-500"> Item Buysback
            </span>
        </span></div>
    </div>





<table style="width: 100% !important;" class="table table-sm table-striped rounded rounded-lg table-bordered">
    <thead>
        <tr>
            <th class="text-center"><input type="checkbox" id="checkAll"></th>
            <th class="text-center">No</th>
            <th class="text-center">Karat</th>
            <th class="text-center">Berat Emas</th>
      
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>


        <tr>
            <td class="text-center">
                <input type="checkbox" class="checkbox">
            </td>
            <td class="text-center">2</td>
            <td class="text-center">0.6</td>
            <td class="text-center">11.5</td>
            <td class="text-center">xx</td>
        </tr>

         <tr>
            <td class="text-center">
                <input type="checkbox" class="checkbox">
            </td>
            <td class="text-center">32</td>
            <td class="text-center">4.6</td>
            <td class="text-center">22.5</td>
            <td class="text-center">xx</td>
        </tr>

        <tr>
            <td class="border-0"></td>
            <td class="border-0"></td>
          
            <td colspan="3" class="border-0 text-center">
           <div class="text-right uppercase px-3 font-semibold">total</div>
           </td>
        </tr>
       
    </tbody>
</table>




{{-- batas --}}



    <div class="flex justify-between">
        <div></div>
        <div class="form-group">
         <a class="px-5 btn btn-danger"
        href="{{ route("buysback.index") }}">
        @lang('Cancel')</a>
            <button type="submit" class="px-5 btn btn-success">@lang('Create')  <i class="bi bi-check"></i></button>
        </div>
    </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

   <x-library.select2 />
    <x-toastr />

@push('page_scripts')


<script type="text/javascript">
 jQuery.noConflict();
(function( $ ) {   
 $('#sup1').change(function() {
            $('#supplier2').toggle();
            $('#supplier1').hide();
        });
        $('#sup2').change(function() {
            $('#supplier1').toggle();
            $('#supplier2').hide();
        });

           $("#checkAll").on("change", function () {
                $(".checkbox").prop("checked", $(this).prop("checked"));
            });

            $(".checkbox").on("change", function () {
                if (!$(this).prop("checked")) {
                    $("#checkAll").prop("checked", false);
                }
            });


 })(jQuery); 

</script>

<script type="text/javascript">
    document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
        element.addEventListener('keyup', function(e) {
            let cursorPostion = this.selectionStart;
            let value = parseInt(this.value.replace(/[^,\d]/g, ''));
            let originalLenght = this.value.length;
            if (isNaN(value)) {
                this.value = "";
            } else {
                this.value = value.toLocaleString('id-ID', {
                    currency: 'IDR',
                    style: 'currency',
                    minimumFractionDigits: 0
                });
                cursorPostion = this.value.length - originalLenght + cursorPostion;
                this.setSelectionRange(cursorPostion, cursorPostion);
            }
        });
    });




</script>



@endpush

    @push('page_css')
        <style type="text/css">
        @media (max-width: 767.98px) { 
         .table-sm th,
         .table-sm td {
             padding: .4em !important;
          }
        }

        table {
                width: 100%;
                margin-bottom: 1rem;
                color: #3c4b64;
                font-size: 0.8rem !important;
            }
        </style>
        @endpush