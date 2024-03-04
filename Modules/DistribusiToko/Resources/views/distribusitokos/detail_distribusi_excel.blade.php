@extends('layouts.cetak')
@section('title', ''.$module_title.' Details')

@section('content')
<div class="container-fluid">
    @if ($dist_toko->isInProgress())
        @livewire('distribusi-toko.cabang.detail',['dist_toko' => $dist_toko])
    @elseif ($dist_toko->isRetur())
        @livewire('distribusi-toko.cabang.retur',['dist_toko' => $dist_toko])
    @elseif ($dist_toko->isCompleted())
        @livewire('distribusi-toko.cabang.completed',['dist_toko' => $dist_toko])
    @endif

</div>
@endsection
@push('page_css')
<style type="text/css">
@media (max-width: 767.98px) {
.table-sm th,
.table-sm td {
padding: .3em !important;
}
}
.card-body {
font-size: 0.9rem !important;
}
</style>
@endpush
@push('page_scripts')




@endpush