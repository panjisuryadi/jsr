@extends('layouts.app')

@section('title', 'Create Purchase')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@push('page_css')
<style type="text/css">
    .dropzone {
        height: 220px !important;
        min-height: 220px !important;
        border: 2px dashed #FF9800 !important;
        border-radius: 8px;
        background: #ff98003d !important;
    }
    .dropzone i.bi.bi-cloud-arrow-up {
        font-size: 5rem;
        color: #bd4019 !important;
    }
</style>
@endpush
@section('content')
<x-library.select2 />
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12">
                <div class="bg-white flex p-0">
                    <div class="w-4/5">
                        <livewire:purchase-product/>
                        </div>
                        <div class="w-1/5 py-4">
                            <a href="{{ route('purchase-product.add') }}"
                                id="Tambah"
                                data-toggle="tooltip"
                                class="btn btn-primary px-3">
                                <i class="bi bi-plus"></i>@lang('Add')&nbsp;{{ __('Product') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">


                    <div class="card-body">
                     <div class="flex relative py-2">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-b border-gray-300"></div>
                                    </div>
                                    <div class="relative flex justify-left">

                                        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark"><small>Pembelian</small> Toko / Pabrik <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Tambah Produk tipe Pabrik /Toko."></i></span>
                                    </div>
                                </div>

                        @include('utils.alerts')
                        <form id="purchase-form" action="{{ route('purchases.store') }}" method="POST">
                            @csrf

                            <div class="form-row mt-2">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="reference">Reference <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="reference" required readonly value="PR">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">

                                          <div class="py-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="supplier" id="sup1" checked>
                                            <label class="form-check-label" for="sup1">Supplier</label>
                                        </div>

                                    <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="supplier"
                                            id="sup2">
                                            <label class="form-check-label" for="sup2">Non Supplier</label>
                                        </div>
                                    </div>

                                    <div id="supplier1" style="display: none !important;" class="align-items-center justify-content-center">
                                     <input type="text" class="form-control" placeholder="Nama Suplier" name="none_supplier" required >
                                    </div>


                                    <div id="supplier2" style="display: block !important;" class="align-items-center justify-content-center">
                                       <select class="form-control select2" name="supplier_id" id="supplier_id" required>
                                                @foreach(\Modules\People\Entities\Supplier::all() as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                                @endforeach
                                            </select>
                                       </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="date">Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="date" required value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <livewire:product-cart :cartInstance="'purchase'"/>

                            <div class="form-row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="status" id="status" required>
                                            <option value="Pending">Pending</option>
                                            <option value="Ordered">Ordered</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="from-group">
                                        <div class="form-group">
                                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="payment_method" id="payment_method" required>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
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

                            <div class="form-group">
                                <label for="note">Note (If Needed)</label>
                                <textarea name="note" id="note" rows="5" class="form-control"></textarea>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    Create Purchase <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('page_scripts')
<script src="{{ asset('js/jquery-mask-money.js') }}"></script>
    <script>
        $('#purchase-form').on('submit',function(e){
            var total = $('#total_amount').val()
            var paid = $('#paid_amount').val()
           console.log(paid)
        })
    </script>

<script>
    jQuery.noConflict();
    (function( $ ) {
        $(document).ready(function() {
        $('#getTotalAmount').click(function(){
            $('#paid_amount').val($('#total_amount').val())
              });
        });

        $('#sup1').change(function() {
            $('#supplier2').toggle();
            $('#supplier1').hide();
        });
        $('#sup2').change(function() {
            $('#supplier1').toggle();
            $('#supplier2').hide();
        });


    })(jQuery);
</script>

<script type="text/javascript">
jQuery.noConflict();
(function( $ ) {
$(document).on('click', '#Tambah, #Edit', function(e){
         e.preventDefault();
        if($(this).attr('id') == 'Tambah')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbspTambah {{ Label_case(' Products') }}');
        }
        if($(this).attr('id') == 'Edit')
        {
            $('.modal-dialog').addClass('modal-lg');
            $('.modal-dialog').removeClass('modal-sm');
            $('#ModalHeader').html('<i class="bi bi-grid-fill"></i> &nbsp;Edit {{ Label_case('Edit item') }}');
        }
        $('#ModalContent').load($(this).attr('href'));
        $('#ModalGue').modal('show');
    });
})(jQuery);
</script>
@endpush
