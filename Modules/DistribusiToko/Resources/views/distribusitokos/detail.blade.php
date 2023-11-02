@extends('layouts.app')
@section('title', ''.$module_title.' Details')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("distribusitoko.index") }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item active">{{$module_action}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    @livewire('distribusi-toko.summary',['dist_toko' => $dist_toko])
    @livewire('distribusi-toko.modal.edit',['dist_toko' => $dist_toko])
    @livewire('distribusi-toko.modal.create',['dist_toko' => $dist_toko])
    <!-- @include('distribusitoko::distribusitokos.includes.modal.edit') -->
</div>
@endsection
@push('page_css')
<style type="text/css">
@media (max-width: 767.98px) {
.table-sm th,
.table-sm td {
padding: .2em !important;
}
}
</style>
@endpush
@push('page_scripts')
    <script>
        function showEditModal(row){
            $('#editModal').modal('show');
            Livewire.emit('setData',row);
        }
        function showCreateModal(){
            $('#createModal').modal('show');
        }
    </script>

@endpush