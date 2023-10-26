@extends('layouts.app')
@section('title', ''.$module_title.' Details')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route("goodsreceipt.index") }}">{{$module_title}}</a></li>
    <li class="breadcrumb-item active">{{$module_action}}</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center">
                    <div>
                        Invoice: <strong>{{ $detail->no_invoice }}</strong>
                    </div>
                    <a target="_blank" class="btn btn-sm btn-secondary mfs-auto mfe-1 d-print-none" href="{{ route(''.$module_name.'.cetak',encode_id($detail->id)) }}"><i class="bi bi-printer"></i> Print
                    </a>
                    <a target="_blank" class="btn btn-sm btn-info mfe-1 d-print-none" href="{{ route(''.$module_name.'.cetak',encode_id($detail->id)) }}">
                        <i class="bi bi-save"></i> Save
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Company Info:</h5>
                            <div><strong>{{ settings()->company_name }}</strong></div>
                            <div>{{ settings()->company_address }}</div>
                            <div>Cabang: <strong>{{ Auth::user()->namacabang?ucfirst(Auth::user()->namacabang->cabang()->first()->name):'' }} </strong></div>
                            <div>Email: {{ settings()->company_email }}</div>
                            <div>Phone: {{ settings()->company_phone }}</div>
                        </div>
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Supplier Info:</h5>
                            <div><strong>{{ $detail->supplier->supplier_name }}</strong></div>
                            <div>{{ $detail->supplier->address }}</div>
                            <div>Email: {{ $detail->supplier->supplier_email }}</div>
                            <div>Phone: {{ $detail->supplier->supplier_phone }}</div>
                            {{--  {{ $detail->supplier }} --}}
                        </div>
                        <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Invoice Info:</h5>
                            <div>Invoice: <strong>{{ $detail->no_invoice }}</strong></div>
                              <div>Tanggal: {{ \Carbon\Carbon::parse($detail->date)->format('d M, Y') }}</div>
                            <div>
                                Pengirim: <strong>{{ $detail->pengirim }}</strong>
                            </div>
                            <div>
                                {{ Label_case('tipe_pembayaran') }}: <label class="bg-green-400 rounded-md py-0 px-3">{{ $detail->tipe_pembayaran }}</label>
                                @if($detail->pembelian->tipe_pembayaran == 'jatuh_tempo')
                                <div class="text-gray-800 text-sm">
                                    <label class="small text-blue-500">Jatuh Tempo</label>
                                    {!! tanggal2(@$data->pembelian->jatuh_tempo)!!}
                                </div>
                                @elseif($detail->pembelian->tipe_pembayaran == 'cicil')
                                <p class="text-gray-600">Cicilan : {{ $detail->pembelian->cicil }} Kali</p>
                                @else
                                <p class="text-gray-600">LUNAS</p>
                                @endif
                            </div>

                         {{--    {{ $detail }} --}}

                        </div>


                   <div class="col-sm-3 mb-3 mb-md-0">
                            <h5 class="mb-2 border-bottom pb-2">Gambar Nota :</h5>
                           <div class="align-items-center text-center">

                              @php
                                  if ($detail->images) {
                                   $url = asset(imageUrl(). @$detail->images);
                                } else {
                                   $url = $detail->getFirstMediaUrl('pembelian', 'thumb');
                                }
                              @endphp


                               <div class="text-center align-items-center items-center">

                                 <img src="{{ $url  }}" width="40%" border="0" width="50" class="img-thumbnail" align="center"/>


                               </div>
                    {{--        {{ $detail }} --}}



                           </div>

                        </div>








                    </div>
                    <div class="card-header">
                       <span class="text-gray-600 text-md font-semibold">Detail</span>
                    </div>
                    <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                        <table style="width: 100% !important;" class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Karat</th>
                                    <th class="text-center">Berat Real</th>
                                    <th class="text-center">Berat Kotor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($detail->goodsreceiptitem as $row)
                                <tr>
                                    <th class="text-center">{{$loop->iteration}}</th>
                                    <td class="text-center"> {{@$row->mainkategori->name}}</td>
                                    <td class="text-center"> {{@$row->karat->kode}} | {{@$row->karat->name}}</td>
                                    <td class="text-center"> {{@$row->berat_real}}</td>
                                    <td class="text-center"> {{@$row->berat_kotor}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="5" class="text-center">Tidak ada data</th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($detail->pembelian->isCicil())
                        <div class="card-header">
                            <span class="text-gray-600 text-md font-semibold">Rincian Cicilan</span>

                        </div>
                        <div class="w-full md:overflow-x-scroll lg:overflow-x-auto table-responsive-sm">
                            <table style="width: 100% !important;" class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nomor Cicilan</th>
                                        <th class="text-center">Tanggal Cicilan</th>
                                        <th class="text-center">Jumlah Cicilan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Sisa Cicilan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($detail->pembelian->detailCicilan as $row)
                                    <tr>
                                        <th class="text-center">{{$row->nomor_cicilan}}</th>
                                        <td class="text-center"> {{@$row->tanggal_cicilan}}</td>
                                        <td class="text-center"> {{@$row->jumlah_cicilan??'-'}}</td>
                                        <td class="text-center"> - </td>
                                        <td class="text-center"> - </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <th colspan="5" class="text-center">Tidak ada data</th>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-sm-5 ml-md-auto">
                            <table style="width: 100% !important;"
                                class="table md:table-sm lg:table-sm">
                                <tbody>
                                    <tr>
                                        <td class="left"><strong>{{ Label_case('total_berat_kotor') }}</strong></td>
                                        <td class="right"><strong class="text-blue-600 text-md">{{ $detail->total_berat_kotor }}
                                         <small class="text-gray-700">Gram</small></strong></td>
                                    </tr>
                                     <tr>
                                        <td class="left"><strong>{{ Label_case('berat_timbangan') }}</strong></td>
                                        <td class="right"><strong class="text-blue-600 text-md">{{ $detail->berat_timbangan }}
                                         <small class="text-gray-700">Gram</small></strong></td>
                                    </tr>

                                    <tr>
                                        <td class="left"><strong>{{ Label_case('total emas yang harus di bayar') }}</strong></td>
                                        <td class="right"><strong class="text-blue-600 text-md">{{ $detail->total_emas }}
                                         <small class="text-gray-700">Gram</small></strong></td>
                                    </tr>
                                </tbody>
                            </table>


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