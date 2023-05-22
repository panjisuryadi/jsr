@extends('layouts.app')

@section('title', 'POS')

@section('third_party_stylesheets')
 <style type="text/css">
 .c-main {
    flex-basis: auto;
    flex-shrink: 0;
    flex-grow: 1;
    min-width: 0;
    padding-top: 0.5rem !important;
}
 </style>
@endsection


@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">POS</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('utils.alerts')
            </div>
            <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="form-group mb-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="bi bi-search text-primary"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="cariproduk" onkeyup="getproduct()" placeholder="@lang('Type product name or code') ....">
                        </div>
                    </div>
                    <div  id="productcontent" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 w-full mt-3">

                    </div>
                </div>
            </div>
        </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('app.pos.store')}}" method="POST" id="addsales">
                            @csrf

                    <div class="py-2 mb-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" value="member" name="member" id="members" checked>
                            <label class="form-check-label" for="members">Members</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="member"
                            value="manual" id="manual">
                            <label class="form-check-label" for="manual">Non Members</label>
                        </div>
                    </div>

                    <div id="showMembers" class="form-group">
                            <label for="customer_id">Customer <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                        <i class="bi bi-person-plus"></i>
                                    </a>
                                </div>
                                <select name="customer_id" id="customer_id" class="form-control">
                                    <option value="" selected>Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                       <div id="NonMember" style="display: none !important;" class="form-group">
                         {{--    <label for="customer_name">Non Members <span class="text-danger">*</span></label>
                       <input type="text" placeholder="Nama" class="form-control"  name="customer_name"> --}}
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="tablelist">
                                <thead>
                                    <tr class="text-center">
                                        <th class="align-middle">Product</th>
                                        <th class="align-middle">Price</th>
                                        <th class="align-middle">Quantity</th>
                                        <th class="align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr align="center">
                                        <td colspan="4">Tidak Ada Data</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        {{-- <tr>
                                            <th>Order Tax</th>
                                            <td>(+) <span id="tax">Rp. 0</span></td>
                                        </tr> --}}
                                        <tr>
                                            <th>Discount</th>
                                            <td>(-) <span id="discount">Rp. 0</span></td>
                                        </tr>
                                      {{--   <tr>
                                            <th>Shipping</th>
                                            <td>(+) <span id="shipping">Rp. 0</span></td>
                                        </tr> --}}
                                        <tr class="text-blue-500">
                                            <th>Grand Total</th>

                                            <th>
                                                <input type="hidden" id="total_amount" name="total_amount">
                                                (=) <span id="grand_total">Rp. 0</span>
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-5">
   <input type="hidden" class="form-control" min="0" value="0" name="order_tax" max="100"  required onkeyup="getsummary()">

    <input type="hidden" class="form-control" min="0" value="0" required name="shipping_amount" onkeyup="getsummary()">

                     {{--        <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="tax_percentage">Order Tax (%)</label>
                                    <input type="number" class="form-control" min="0" value="0" name="order_tax" max="100"  required onkeyup="getsummary()">
                                </div>
                            </div> --}}
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="discount_percentage">Discount (%)</label>
                                    <input type="number" class="form-control" min="0" value="0" max="100" name="discount_amount" required onkeyup="getsummary()">
                                </div>
                            </div>
                       {{--      <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="shipping_amount">Shipping</label>
                                    <input type="number" class="form-control" min="0" value="0" required name="shipping_amount" onkeyup="getsummary()">
                                </div>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">Metode Pembayaran</label>
                                    <select class="form-control select2" name="payment_method" id="payment_method" required>
                                        <option value="Cash">Cash</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paid_amount">Amount Paid <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input id="paid_amount" type="text" class="form-control" name="paid_amount" required>
                                        <div class="input-group-append">
                                            <button id="getTotalAmount" class="btn btn-primary" type="button">
                                                <i class="bi bi-check-square"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


<div class="flex px-3 row justify-between pt-3 border-top">
    <div></div>
    <div class="form-group d-flex justify-content-center flex-wrap mb-0">
        <button type="button" class="btn btn-md btn-danger mr-2" id="reset"><i class="bi bi-x"></i> Reset</button>
        <button type="submit" class="px-4 btn btn-md btn-primary" id="proccess"><i class="bi bi-check"></i> Proceed</button>
    </div>
</div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
@endpush
@push('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>

<script type="text/javascript">
    $('#members').change(function() {
        $('#showMembers').toggle();
        $('#NonMember').hide();
    });
    $('#manual').change(function() {
        $('#NonMember').toggle();
        $('#showMembers').hide();
    });
</script>
<script>
    $(document).ready(function () {
        getproduct()
    });
    var product = []
    var total = 0
    function getproduct(){
        $.ajax({
            type: "GET",
            url: "{{route('products.getsalesProduct')}}?cariproduk="+$('#cariproduk').val(),
            dataType:'json',
            contentType: false,
            processData: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                $('#productcontent').html(data)
            }
        })
    }

    function selectproduct(id,stock){
        if(stock == 0){
            toastr.error('Stock 0, pindahkan product ke etalase terlebih dahulu')
        }else{
            if ($.inArray(id, product) !== -1) {
                toastr.error('Data Sudah Ada')
            } else {
                $.ajax({
                    type: "GET",
                    url: "{{route('products.getone',"")}}/"+id,
                    dataType:'json',
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        list = '<tr id="row'+data.product.id+'">\
                                    <td align="center" class="align-middle">'+data.product.product_name+' | '+data.product.product_code+'<input type="hidden" name="product_id[]" value="'+data.product.id+'"></input></td>\
                                    <td align="center" class="align-middle"><input name="price[]" type="hidden" value="'+data.product.product_price+'"></input>Rp. '+data.product.product_price.toLocaleString()+'</td>\
                                    <td align="center" class="align-middle"><input class="form-control form-control-sm" min="0" max="'+data.stock.stock+'" value="1" type="number" style="min-width: 40px;max-width: 90px;" name="quantity[]" onkeyup="getsummary()"></input></td>\
                                    <td align="center" class="align-middle"><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct('+data.product.id+')">\
                                                <i class="bi bi-trash"></i>\
                                            </button></td>\
                                </tr>';
                        if(product.length == 0){
                            $('#tablelist tbody').html(list)
                        }else{
                            $('#tablelist tbody').append(list)
                        }

                        product.push(data.product.id)
                        getsummary()
                    }
                })
            }
        }
    }
    function removeProduct(id){
        product = product.filter(function(value) {
            return value !== id;
        });
        $('#row'+id).remove()
        if(product.length == 0){
            $('#tablelist tbody').html('<tr align="center">\
                                            <td colspan="4">Tidak Ada Data</td>\
                                        </tr>')
        }
        getsummary()
    }

    $('#reset').click(function(){
        $('#tablelist tbody').html('<tr align="center">\
                                            <td colspan="4">Tidak Ada Data</td>\
                                        </tr>')
        product = []
        getsummary()
    })

    function getsummary(){
        var form = $('#addsales');
        $.ajax({
            type: "POST",
            url: "{{route('app.pos.salesummary')}}",
            data: form.serialize(),
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept' : 'application/json'
            },
            success: function(data){
                $('#grand_total').html('Rp. '+data.grand_total)
                $('#shipping').html('Rp. '+data.shipping)
                $('#tax').html('Rp. '+data.tax)
                $('#discount').html('Rp. '+data.discount)
                $('#total_amount').val(data.total_amount)
            }
        })
    }

    $('#proccess').click(function(){

    })

    $('#getTotalAmount').click(function(){
        $('#paid_amount').val($('#total_amount').val())
    })
</script>

@endpush
