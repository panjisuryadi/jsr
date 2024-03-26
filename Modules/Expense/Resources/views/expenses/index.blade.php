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
                    <div class="card-header mt-2">
                        <div class="row">
                            <div class="col-md-3">
                                @php
                                    $total_masuk = $data->sum('amount');
                                    $total_keluar = $data->sum('amount_out');
                                    $total = $total_masuk - $total_keluar;
                                @endphp
                                <table class="table table-sm table-striped table-hover">
                                    <tr>
                                        <th>
                                            <p class="text-gray-600 font-semibold">Jumlah Masuk</p>
                                        </th>
                                        <th>
                                            <span class="text-blue-500 "> {{ format_uang($total_masuk) }}</span>
                                        </th>
                                        {{-- <th></th> --}}
                                    </tr>
                                    <tr>
                                        <th>
                                            <p class="text-gray-600 font-semibold">Jumlah Keluar</p>
                                        </th>
                                        <th>
                                            <span class="text-blue-500 "> {{ format_uang($total_keluar) }}</span>
                                        </th>
                                        {{-- <th>
                                            <p class="text-lg text-gray-600 font-semibold">
                                                Hasil :<span class="text-red-500 "> {{ format_uang($total) }}</span>
                                            </p>
                                        </th> --}}
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-9">
                                <div class="">
                                    <p class="text-lg text-gray-600 font-semibold">
                                        Sisa :<span class="text-red-500 "> {{ format_uang($total) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-4">
                            {{  __("Add") }}<i class="bi bi-plus"></i>
                        </a>

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
