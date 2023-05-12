@extends('layouts.app')

@section('title', 'Locations')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('css/treeview.css') }}">
    <style type="text/css">
    .tree li {
            margin: 0;
            padding: 0 1 em;
            line - height: 2 em;
            color: #3c4b64;
    font-weight: 700;
    font-size: 0.9rem !important;
    position: relative;
    }
    .tree li a{
    color: # 6 a6a75;
            font - family: 'Poppins',
            Arial,
            Helvetica,
            sans - serif!important;
        }
        .tree li span {
            -moz - border - radius: 5 px; -
            webkit - border - radius: 5 px;
            border: 2 px solid #e4e4e4;
            border - radius: 4 px;
            display: inline - block;
            padding: 3 px 8 px;
            text - decoration: none;
            cursor: pointer;
        }
    </style>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Locations</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header"><i class="bi bi-geo-alt"></i> Level Lokasi</div>
                    <div class="card-body">
                        <ul id="tree1">
                            @foreach($Alllocation as $lokasi)

                         {{--    {{ $lokasi }} --}}
                            <li>
                                {{ $lokasi->name }}
                                @if(count(array($lokasi->childs)))
                                @include('location',['childs' => $lokasi->childs])
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('locations.create') }}" class="btn btn-primary">
                            Add Locations <i class="bi bi-plus"></i>
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
    <script src="{{ asset('js/treeview.js') }}"></script>
@endpush
