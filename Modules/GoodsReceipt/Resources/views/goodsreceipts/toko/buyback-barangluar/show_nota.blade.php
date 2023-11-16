@extends('layouts.app')

@section('title', 'Nota ' . $nota->invoice)

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('goodsreceipt.toko.buyback-barangluar.index') }}">Barang BuyBack & Barang Luar (Toko)</a></li>
        <li class="breadcrumb-item active">#{{ $nota->invoice }}</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
    @if ($nota->isProcessing())
        @livewire('goods-receipt.toko.nota.confirm',['nota' => $nota])
    @elseif ($nota->isSent())
        @livewire('goods-receipt.toko.nota.sent',['nota' => $nota])
    @else
        @livewire('goods-receipt.toko.nota.detail',['nota' => $nota])
    @endif
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

@push('page_scripts')
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        let selectedItems = [];
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked
            if(checkbox.checked){
                selectedItems.push(checkbox.value);
            }
        });
        Livewire.emitTo('goods-receipt.toko.nota.confirm', 'selectAllItem', selectedItems)
        });

        window.addEventListener('items:not-selected', event => {
            toastr.error(event.detail.message);
        });

        window.addEventListener('approve:modal', event => {
            $('#approve-modal').modal('show');
        });

        window.addEventListener('check:all-selected', event => {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            let isAllSelected = true;
            checkboxes.forEach(checkbox => {
                if(!checkbox.checked){
                    isAllSelected = false;
                    return;
                }
            });
            Livewire.emitTo('goods-receipt.toko.nota.confirm', 'isSelectAll', isAllSelected)
            
        });
    </script>
@endpush

