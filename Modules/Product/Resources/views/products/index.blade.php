@extends('layouts.app')
@section('title', 'Products')
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<style type="text/css">

div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: 220px !important;
}
div.dataTables_wrapper div.dataTables_length select {
    width: 70px !important;
    display: inline-block;
}
</style>
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="flex justify-between pb-3 border-bottom">
                        <div>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                Add Product <i class="bi bi-plus"></i>
                            </a>
                        </div>
                        <div id="button"></div>
                    </div>
                    <div class="table-responsive w-full mt-2">
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
<script type="text/javascript">

</script>
@endpush