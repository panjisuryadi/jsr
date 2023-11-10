@extends('layouts.app')

@section('title', 'Sales Details')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('buysback.index') }}">Buys Back</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap align-items-center">
                        <div>
                            Invoice: <strong>{{@$detail->no_buy_back}}</strong>
                        </div>
                        @can('print_buybacktoko')
                        <a target="_blank" class="btn btn-sm btn-success mfs-auto mfe-1 d-print-none" href="#"><i class="bi bi-printer"></i> Print
                        </a>
                        @endcan
                       
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Company Info:</h5>
                    <div><strong>{{ settings()->company_name }}</strong></div>
                                <div>{{ settings()->company_address }}</div>
                       <div>Cabang: <strong>{{ Auth::user()->namacabang?ucfirst(Auth::user()->namacabang->cabang()->first()->name):'' }} </strong></div>
                                <div>Email: {{ settings()->company_email }}</div>
                                <div>Phone: {{ settings()->company_phone }}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Customer Info:</h5>
                    <div><strong>{{@$detail->customer->customer_name}}</strong></div>

                                <div>{{@$detail->customer->address}} </div>
                                <div>Email: {{@$detail->customer->customer_email}}</div>
                                <div>Phone: {{@$detail->customer->customer_phone}}</div>
                            </div>

                            <div class="col-sm-4 mb-3 mb-md-0">
                                <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                                <div>Invoice: <strong>{{@$detail->no_buy_back}}</strong></div>
                                <div>Date: {{ \Carbon\Carbon::parse($detail->date)->format('d M, Y') }}</div>
                                <div>
                                    Status: <strong>dssdsds</strong>
                                </div>
                                
                            </div>

                        </div>

                        <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                            <table style="width: 100% !important;" class="table table-sm table-striped">
                                <thead>
                                <tr>
                                    <th class="align-middle">Product</th>
                                    <th class="align-middle">Karat</th>
                                    <th class="align-middle">Berat</th>
                                  
                                    <th class="align-middle">Sub Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                 {{-- {{$detail}} --}}
                                    <tr>
                                     <td> {{@$detail->product_name}}</td>   
                                     <td> {{@$detail->karat->name}}</td>   
                                     <td> {{@$detail->weight}} <small>Gram</small></td>   
                                     <td> {{format_uang(@$detail->nominal)}}</td>   
                                     

                                    </tr>

             


                                </tbody>
                            </table>
                        </div>
                 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

        @push('page_css')
        <style type="text/css">
        @media (max-width: 767.98px) { 
         .table-sm th,
         .table-sm td {
             padding: .4em !important;
          }
        }
        </style>
        @endpush

