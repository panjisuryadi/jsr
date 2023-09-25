@extends('layouts.app')
@section('title', 'Create Buy Back Sales')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("buybacksale.index") }}">{{__('Buy Back Sales')}}</a></li>
    <li class="breadcrumb-item active">Add</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <form action="{{ route('buybacksale.store') }}" method="POST">
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
        <span class="font-semibold tracking-widest bg-white pl-0 pr-3 text-sm uppercase text-dark">{{__('Buy Back Sales')}} &nbsp;<i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="{{__('Buys Back Sale')}}"></i>
        </span>
    </div>
</div>


<div class="flex flex-row grid grid-cols-2 gap-2">
    
     <div class="form-group">
            <?php
            $field_name = 'no_buy_back';
            $field_lable = __('no_buy_back');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = '';
            ?>
            <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
            <input type="text" name="{{ $field_name }}"
            class="form-control {{ $invalid }}"
            name="{{ $field_name }}"
            value="{{ old($field_name) }}"
            placeholder="{{ $field_placeholder }}" {{ $required }}>
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>

  <div class="form-group">
            <?php
            $field_name = 'date';
            $field_lable = __('Tanggal');
            $field_placeholder = Label_case($field_lable);
            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
            $required = 'required';
            ?>
            <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
            <input type="date" name="{{ $field_name }}"
            class="form-control {{ $invalid }}"
            name="{{ $field_name }}"
            value="{{ old($field_name) }}"
            placeholder="{{ $field_placeholder }}" {{ $required }}>
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>

</div>


<div class="flex flex-row grid grid-cols-2 gap-2">
<div class="form-group">
        <label for="customer_sales_id" style="margin-bottom: 0.2rem;">Customer Sales <span class="text-danger">*</span></label>
        <div class="input-group">
            <select class="form-control select2" name="customer_sales_id" id="customer_sales_id" >
                <option value="" selected disabled>Pilih Customer Sales</option>
                @foreach(\Modules\CustomerSales\Entities\CustomerSales::all() as $cust)
                <option value="{{ $cust->id }}">{{ $cust->customer_name }}</option>
                @endforeach
            </select>
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>
</div>
<div class="form-group">
    <div>
        <label for="sales_id" style="margin-bottom: 0.2rem;">Sales <span class="text-danger">*</span></label>
        <div class="input-group">
            <select class="form-control select2" name="sales_id" id="sales_id" >
                <option value="" selected disabled>Pilih Sales</option>
                @foreach(\Modules\DataSale\Models\DataSale::all() as $sale)
                <option value="{{ $sale->id }}">{{ $sale->name }}</option>
                @endforeach
            </select>
            @if ($errors->has($field_name))
            <span class="invalid feedback"role="alert">
                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                class="text-danger">
            </span>
            @endif
        </div>
    </div>
</div>

</div>


<div class="flex flex-row grid grid-cols-2 gap-2"> 

 <div class="form-group">
        <?php
        $field_name = 'nama_product';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="text"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        @if ($errors->has($field_name))
        <span class="invalid feedback"role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </span>
        @endif
    </div>
 <div class="form-group">
        <?php
        $field_name = 'kadar';
        $field_lable = label_case('kadar');
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <select class="form-control select2" name="{{ $field_name }}" id="{{ $field_name }}" >
            <option value="" selected disabled>Pilih Karat</option>
            @foreach(\Modules\Karat\Models\Karat::all() as $karat)
            <option value="{{ $karat->id }}">{{ $karat->name }}</option>
            @endforeach
        </select>
        @if ($errors->has($field_name))
        <span class="invalid feedback"role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </span>
        @endif
    </div>
    <div class="form-group">
        <?php
        $field_name = 'berat';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        min="0" step="0.001"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        @if ($errors->has($field_name))
        <span class="invalid feedback"role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </span>
        @endif
    </div>



</div>



 <div class="form-group">
        <?php
        $field_name = 'nominal';
        $field_lable = label_case($field_name);
        $field_placeholder = $field_lable;
        $invalid = $errors->has($field_name) ? ' is-invalid' : '';
        $required = "required";
        ?>
        <label class="text-xs" for="{{ $field_name }}">{{ $field_lable }}<span class="text-danger">*</span></label>
        <input class="form-control"
        type="number"
        name="{{ $field_name }}"
        id="{{ $field_name }}"
        value="{{old($field_name)}}"
        placeholder="{{ $field_placeholder }}">
        @if ($errors->has($field_name))
        <span class="invalid feedback"role="alert">
            <small class="text-danger">{{ $errors->first($field_name) }}.</small
            class="text-danger">
        </span>
        @endif
    </div>






    
  <div class="form-group">
    <?php
    $field_name = 'note';
    $field_lable = __('Keterangan');
    $field_placeholder = Label_case($field_lable);
    $invalid = $errors->has($field_name) ? ' is-invalid' : '';
    $required = '';
    ?>
    <label class="mb-0" for="{{ $field_name }}">{{ $field_placeholder }}</label>
    <textarea name="{{ $field_name }}"
    placeholder="{{ $field_placeholder }}"
    value="{{ old($field_name) }}"
    rows="5"
    id="{{ $field_name }}" rows="4 " class="form-control {{ $invalid }}"></textarea>
    @if ($errors->has($field_name))
    <span class="invalid feedback"role="alert">
        <small class="text-danger">{{ $errors->first($field_name) }}.</small
        class="text-danger">
    </span>
    @endif
</div>



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
 })(jQuery);   
</script>
@endpush