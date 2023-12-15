@extends('layouts.app')

@section('title', ''.$module_title.' Details')



@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("datasale.index") }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item ">Laporan Sales</li>
    <li class="breadcrumb-item active">Index</li>
</ol>
@endsection


@section('content')
<div class="container-fluid">

<div class="card">
<div class="flex flex-row grid grid-cols-3 gap-2 px-4 py-3">
    <livewire:reports.laporan-sales/>
    
</div>

</div>





<div class="card">
    <div class="p-5 border">
        <div class="text-center">
            <div style="font-size:20px;">
                <div class="font-semibold tracking-wide">Rekapan Transaksi Sales</div>
            </div>
            <div>
                Periode <span id="periods">2023</span>
            </div>
        </div>
        <div class="pt-3 table-responsive">
            <div class="pb-3">
                <table width="100%">
                    <tbody><tr>
                        <td width="50%">
                            <table>
                                <tbody>

                                    <tr>
                                    <td width="10%"><b>Nama Pengrajin</b></td>
                                    <td width="10%" colspan="2">: <span class="names" id="names">-</span></td>
                                </tr>
                                <tr>
                                    <td><b>Total Piutang Emas</b></td>
                                    <td width="10%">: <span class="piutangemas" id="piutangemas">-</span> </td>
                                    <td width="2%"><b>Dibayar</b></td>
                                    <td width="10%">: <span class="emasdibayar" id="emasdibayar">-</span></td>
                                    <td width="2%"><b>Sisa</b> </td>
                                    <td width="10%">: <span class="sisapiutangemas" id="sisapiutangemas">-</span> </td>
                                    <td width="35%"></td>
                                </tr>
                                <tr>
                                    <td><b>Total Piutang Nominal</b></td>
                                    <td>: <span class="piutangnominal" id="piutangnominal">-</span> </td>
                                    <td> <b>Dibayar</b></td>
                                    <td>: <span class="nominaldibayar" id="nominaldibayar">-</span></td>
                                    <td><b>Sisa</b> </td>
                                    <td>: <span class="sisapiutangnominal" id="sisapiutangnominal">-</span> </td>
                                    <td></td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
            </div>
            <h1 class="font-semibold">Rekapan Transaksi Emas</h1>
            <table class="text-gray-400 table table-bordered mt-2" id="tablejournalemas">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>keterangan</th>
                        <th>Piutang JSR</th>
                        <th>Bayar</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="pt-3 table-responsive">
            <h1 class="font-semibold">Rekapan Transaksi Nominal</h1>
            <table class="text-gray-400 table table-bordered mt-2" id="tablejournalnominal">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>keterangan</th>
                        <th>Piutang JSR</th>
                        <th>Bayar</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
</div>





</div>

@endsection

@push('page_css')
<style>
    .dt-buttons{
        float: initial !important;
        width: fit-content;
        margin-left: auto;
        margin-bottom: 2rem;
    }
</style>
    
@endpush
<x-library.datatable />
@push('page_scripts')

@endpush