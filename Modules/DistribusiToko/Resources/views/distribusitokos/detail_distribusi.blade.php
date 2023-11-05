@extends('layouts.app')
@section('title', ''.$module_title.' Details')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    
    <li class="breadcrumb-item active">{{$module_action}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    @livewire('distribusi-toko.cabang.detail',['dist_toko' => $dist_toko])
    @include('distribusitoko::distribusitokos.cabang.modal.summary')
    @include('distribusitoko::distribusitokos.cabang.modal.tracking',['dist_toko'=>$dist_toko])
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

<script type="text/javascript">
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    window.addEventListener('items:not-selected', event => {
        toastr.error(event.detail.message);
    });

    window.addEventListener('summary:modal', event => {
        $('#summary-modal').modal('show');
    });

    window.addEventListener('tracking:modal', event => {
        $('#tracking-modal').modal('show');
    });

    
    
</script>


@endpush