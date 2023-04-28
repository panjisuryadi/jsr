@extends('layouts.app')

@section('title', 'Create Adjustment')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('adjustments.index') }}">@lang('Adjustments')</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-1">

        <div class="row mt-0">


 <div class="col-md-5 bg-white">

     <livewire:search-product/>
<div id="load" class="p-1" style="overflow: auto; max-height: 20rem;">
    <livewire:adjustment.list-product/>
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
                            <livewire:adjustment.product-table/>


                              {{--    <livewire:locations.location/>
 --}}


                            <div class="form-group">
                                <label for="note">Note <span class="small text-danger">( @lang('If Needed'))</span></label>
                                <textarea name="note" id="note" rows="3" class="form-control"></textarea>
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
@endsection



 @push('page_css')
<style>
        html,
        body {
           /* height: 100vh;*/
        }
    </style>
 @endpush
 @push('page_scripts')
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

    </script>

@endpush