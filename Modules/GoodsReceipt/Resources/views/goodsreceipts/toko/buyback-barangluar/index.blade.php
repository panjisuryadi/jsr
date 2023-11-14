@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item">Penerimaan Barang (Toko)</li>
    <li class="breadcrumb-item active">BuyBack - Barang Luar</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    @if (auth()->user()->isUserCabang())
        @include('goodsreceipt::goodsreceipts.toko.buyback-barangluar.datatable.item')
        @include('goodsreceipt::goodsreceipts.toko.buyback-barangluar.datatable.nota')
    @endif
</div>
@endsection

@push('page_scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
function createModal(){
    $('#goodsreceipt-toko-buyback-create').modal('show');
}

function createBarangLuar(){
    $('#create-barangluar-modal').modal('show');
}
</script>
@endpush