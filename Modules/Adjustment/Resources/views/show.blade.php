@extends('layouts.app')

@section('title', 'Adjustment Details')

@push('page_css')
    @livewireStyles
@endpush

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('adjustments.index') }}">Adjustments</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="2">
                                         @lang('Date')
                                    </th>
                                    <th colspan="1">
                                         @lang('Reference')
                                    </th>
                                    <th colspan="2">
                                         @lang('locations')
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{ $adjustment->date }}
                                    </td>
                                    <td colspan="1">
                                        {{ $adjustment->reference }}
                                    </td>
                                    <td colspan="2">
                    {{ @$adjustment->adjustedLocations[0]->locations->name }}
                   <i class="bi bi-chevron-double-right"></i>
                    {{ @$adjustment->adjustedLocations[0]->sublocations->name }}

                                    </td>
                                </tr>

                                <tr>

                                    <th>@lang('Product Name')</th>
                                    <th>@lang('Code')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>Type</th>
                                </tr>

                                @foreach($adjustment->adjustedProducts as $adjustedProduct)
                                    <tr>

                                        <td>{{ $adjustedProduct->product->product_name }}</td>
                                        <td>{{ $adjustedProduct->product->product_code }}</td>
                                        <td>{{ $adjustedProduct->quantity }}</td>
                                        <td>
                                            @if($adjustedProduct->type == 'add')
                                                <span class="text-success">(+)</span> @lang('Addition')
                                            @else
                                                   <span class="text-danger">(-)</span>@lang('Subtraction')
                                            @endif
                                        </td>


                                    </tr>
                                @endforeach


                            </table>



















                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
