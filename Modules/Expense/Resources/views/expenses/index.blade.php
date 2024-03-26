@extends('layouts.app')

@section('title', 'Expenses')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ __("Expenses") }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                                    {{  __("Add") }}<i class="bi bi-plus"></i>
                                  </a>
                            </div>
                            <div class="col-md-4">
                                <p class="uppercase text-lg text-gray-600 font-semibold">
                                    Jumlah <span class="text-red-500 uppercase">Masuk {{ format_uang($data->sum('amount')) }}</span>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="uppercase text-lg text-gray-600 font-semibold">
                                    Jumlah Keluar <span class="text-red-500 uppercase">Keluar {{ format_uang($data->sum('amount_out')) }}</span>
                                </p>
                            </div>
                        </div>



                        <hr>

                        <div class="table-responsive">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    {!! $dataTable->scripts() !!}
@endpush
