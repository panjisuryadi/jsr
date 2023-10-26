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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-lg font-bold">Summary Distribusi</h1>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <div class="font-extrabold mb-2">Invoice Info: </div>
                            <div>Invoice: <strong>{{ $dist_toko->no_invoice }}</strong></div>
                            <div>Tanggal: {{ \Carbon\Carbon::parse($dist_toko->date)->format('d M, Y') }}</div>
                            <div>Cabang: <strong>{{ $dist_toko->cabang->name }}</strong></div>
                            <div>
                                Dibuat oleh: <strong>{{ $dist_toko->created_by }}</strong>
                            </div>
                            <div>
                                {{ Label_case('Status') }}: <label class="bg-green-400 rounded-md py-0 px-3">Draft</label>
                            </div>


                        </div>

                        <div class="col-sm-3 mb-3 mb-md-0">
                            <div class="font-extrabold mb-2">Distribusi Info: </div>
                            <div>Jumlah Item: <strong>{{ $dist_toko->items->count() }} buah</strong></div>
                            <div>Jumlah Jenis Karat: {{ $dist_toko->items->groupBy('karat_id')->count() }}</div>
                            <div>Total Berat Emas: <strong> {{ $dist_toko->items->sum('gold_weight') }} gram</strong></div>
                        </div>

                       



                    </div>
                    <div class="card">
                        <div class="card-header">
                           <span class="text-gray-600 text-md font-semibold">Detail</span>
                        </div>
                        <div class="card-body">
                            <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                                @foreach($dist_toko->items->groupBy('karat_id') as $karat_id => $items)
                                <h4 class="font-bold uppercase mb-3">Karat : {{$items->first()->karat->name}} {{$items->first()->karat->kode}}</h4>
                                <table style="width: 100% !important;" class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Karat</th>
                                            <th class="text-center">Berat Emas</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $total_weight = 0;
                                        @endphp
                                        @forelse($items as $row)
                                        @php
                                            $total_weight = $total_weight + $row->gold_weight;
                                        @endphp
                                        <tr>
                                            <th class="text-center">{{$loop->iteration}}</th>
                                            <td class="text-center"> {{@$row->karat->name}} {{@$row->karat->kode}}</td>
                                            <td class="text-center"> {{@$row->gold_weight}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <th colspan="5" class="text-center">Tidak ada data</th>
                                        </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="2" class="text-right font-extrabold">Jumlah Emas :</td>
                                            <td class="text-center font-extrabold">{{ $total_weight }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @endforeach
                                
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
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