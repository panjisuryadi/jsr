@extends('layouts.app')

@section('title', 'Purchases')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Purchases</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

               <div class="flex justify-between py-1 border-bottom">
                        <div>
                      <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                            Add Purchase <i class="bi bi-plus"></i>
                        </a>

                        </div>
                        <div id="buttons">
                        </div>
                    </div>

                 <div class="table-responsive pt-3">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Selesaikan Pembelian</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="{{route('purchase.completepurchase')}}">
        @csrf
        <div class="modal-body">
            <div id="modal-content">

            </div>
            <input type="hidden" id="purchase_id" name="purchase_id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" >Confirm</button>
        </form>
        </div>
        </div>
    </div>
    </div>
@endsection

@push('page_scripts')
    {!! $dataTable->scripts() !!}
<script>
    function completepurchase(id,noref){
        $('#purchase_id').val(id)
        $('#modal-content').html('Konfirmasi Untuk Menyelesaikan Pembelian '+noref)
        $('#exampleModal').modal('show')
    }
    function confirmcomplete(){
        
    }
</script>
@endpush
