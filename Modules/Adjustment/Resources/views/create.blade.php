@extends('layouts.app')

@section('title', 'Create Adjustment')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('adjustments.index') }}">@lang('Adjustments')</a></li>
        <li class="breadcrumb-item font-bold">{{ $active_location['label'] }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-1">

        <div class="row mt-0">


        <div class="col-md-5 bg-white">
            <div class="pt-3">
                <livewire:product-table/>
            </div>
        </div>

        <div class="col-md-7">
                <div class="card">

                    <div class="card-body">
                        @include('utils.alerts')
                        <form action="{{ route('adjustments.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="reference" required readonly value="ADJ">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="date">Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control form-control-sm" name="date" required value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="tablelist">
                                    <thead>
                                    <tr class="align-middle">
                                        <th class="align-middle">@lang('Product Name')</th>
                                        <th class="align-middle">@lang('Location')</th>
                                        <th class="align-middle">Stock Data</th>
                                        <th class="align-middle">@lang('Stock Rill')</th>
                                        <th class="align-middle">@lang('Action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>



                            <div class="form-group">
                                <label for="notes">Note <span class="small text-danger">( @lang('If Needed'))</span></label>
                                <textarea name="notes" id="notes" rows="3" class="form-control"></textarea>
                            </div>




                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                   @lang('Create Adjustment')  <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
@include('adjustment::partials.add')
@endsection



 @push('page_css')
<style>
        html,
        body {
           /* height: 100vh;*/
        }
    </style>
    
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
 @endpush
 @push('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">

$("#load").scroll(function (e) {
    e.preventDefault();
    var elem = $(this);
    if (elem.scrollTop() > 0 &&
            (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight())) {
        //alert("At the bottom");
      window.livewire.emit('load-more');

    }
});
var prodval = []
function selectProduct(id){
        if ($.inArray(id, prodval) !== -1) {
            toastr.error('Data Sudah Ada')
        } else {
            $.ajax({
                type: "GET",
                url: "{{route('stock.getone',"")}}/"+id,
                dataType:'json',
                contentType: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    console.log(data)
                    $('#note').val('')
                    $('#product_name').html(data.name)
                    $('#product_name_val').val(data.name)
                    $('#stock').val(data.stock)
                    $('#stock_rill').val(data.stock)
                    $('#product_location_id').val(data.id)
                    $('#product_id').val(data.product_id)
                    $('#location').html(data.location)
                    $('#location_val').val(data.location)
                    $('#location_id').val(data.location_id)
                    $('#addModal').modal('show')
                }
            })
        }
    }
    function addtolist(){
        if($('#stock_rill').val() != $('#stock').val()){
            // toastr.success($('#stok_rill').val())
            if($('#note').val() == null || $('#note').val().trim() == ''){
                toastr.error('Note Wajib Diisi')
            }else{
                $('#addModal').modal('hide')
                prodval.push($('#product_location_id').val())
                list = '<tr id="row'+$('#product_location_id').val()+'">\
                            <td>'+$('#product_name_val').val()+'<input type="hidden" name="product_id[]" value="'+$('#product_id').val()+'"></input></td>\
                            <td>'+$('#location_val').val()+'<input type="hidden" name="location[]" value="'+$('#location_id').val()+'"></input></td>\
                            <td>'+$('#stock').val()+' PCS<input type="hidden" name="quantities[]" value="'+$('#stock_rill').val()+'"></input></td>\
                            <td>'+$('#stock_rill').val()+' PCS<input type="hidden" name="note[]" value="'+$('#note').val()+'"></input></td>\
                            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct('+$('#product_location_id').val()+')">\
                                        <i class="bi bi-trash"></i>\
                                    </button></td>\
                        </tr>';
                $('#tablelist tbody').append(list)
            }
        }else{
            $('#addModal').modal('hide')
            prodval.push($('#product_location_id').val())
            list = '<tr id="row'+$('#product_location_id').val()+'">\
                        <td>'+$('#product_name_val').val()+'<input type="hidden" name="product_id[]" value="'+$('#product_id').val()+'"></input></td>\
                        <td>'+$('#location_val').val()+'<input type="hidden" name="location[]" value="'+$('#location_id').val()+'"></input></td>\
                        <td>'+$('#stock').val()+' PCS<input type="hidden" name="quantities[]" value="'+$('#stock_rill').val()+'"></input></td>\
                        <td>'+$('#stock_rill').val()+' PCS<input type="hidden" name="note[]" value="'+$('#note').val()+'"></input></td>\
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct('+$('#product_location_id').val()+')">\
                                    <i class="bi bi-trash"></i>\
                                </button></td>\
                    </tr>';
            $('#tablelist tbody').append(list)
        }
        console.log(prodval)
    }
    
    function removeProduct(id){
        prodval = prodval.filter(function(value) {
            return value !== ''+id+'';
        });
        $('#row'+id).remove()
    }

    </script>

@endpush