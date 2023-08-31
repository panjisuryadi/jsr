@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{$module_title}}</li>
</ol>
@endsection
@section('content')
@push('page_css')
<style type="text/css">
    
.c-main {
    flex-basis: auto;
    flex-shrink: 0;
    flex-grow: 1;
    min-width: 0;
    padding-top: 0.2rem !important;
}
</style>

@endpush
<div class="container-fluid">


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="flex justify-between py-1 border-bottom">
                        <div>
                       <p class="uppercase text-lg text-gray-600 font-semibold">
                      Distribusi  {{ $distribusi }}</p>
                        </div>
                        <div id="buttons">


    <div class="dropdown show">
                <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pilih Distribusi
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" 
                    href="{{route(''.$module_name.'.type','toko')}}">Toko</a>
                    <a class="dropdown-item"
                     href="{{route(''.$module_name.'.type','sales')}}">Sales</a>
                </div>
            </div>


                        </div>
                    </div>


<div class="card-body px-1">

<div class="bg-white w-full rounded-lg border border-1 px-3 py-5 mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center">

        </div>
        <div class="text-gray-700">
            <div class="font-bold text-xl mb-2">INVOICE</div>
            <div class="text-sm">Tanggal: 01/05/2023</div>
            <div class="text-sm">Kepada #: INV12345</div>
        </div>
    </div>


    <table class="w-full text-left mb-3 table table-bordered p-3">
        <thead>
            <tr>
   <th class="text-gray-700 font-bold uppercase py-2">No</th>
      <th class="text-gray-700 font-bold uppercase py-2">Code</th>
      <th class="text-gray-700 font-bold uppercase py-2">NO Nota</th>
      <th class="text-gray-700 font-bold uppercase py-2">Berat Kotor</th>
      <th class="text-gray-700 font-bold uppercase py-2">Berat Bersih</th>
      <th class="text-gray-700 font-bold uppercase py-2">kadar</th>
      <th class="text-gray-700 font-bold uppercase py-2">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="py-4 text-gray-700">1</td>
                <td class="py-4 text-gray-700">PO-0004</td>
                 <td class="py-4 text-gray-700">DE9800</td>
                <td class="py-4 text-gray-700">900.87</td>
                <td class="py-4 text-gray-700">899.90</td>
                <td class="py-4 text-gray-700">28</td>

                <td class="py-4 text-gray-700">9800</td>
            </tr>

        </tbody>
    </table>


  <table class="w-full table table-borderless">
                        <tbody>
                            <tr class="content">
                                  <td class="w-50"></td>
                                  <td class="font-normal">
                         <div class="font-semibold text-gray-700 uppercase">Jumlah</div>
                         <div class="font-semibold text-gray-700 uppercase">Diskon</div>
                         <div class="font-semibold text-gray-700 uppercase">Total</div>

                                </td>
                                <td class="font-normal">
                            <div class="font-semibold text-gray-700 uppercase">809</div>
                            <div class="text-gray-700 text-sm">20%</div>
                            <div class="text-gray-700 text-sm">8990</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

  <table class="w-full table table-borderless">
                        <tbody>
                            <tr class="content">
                                  <td class="w-50"></td>
                                  <td class="font-normal">
                                 <div class="font-semibold text-gray-500 uppercase">pic</div>
                                 <div class="text-gray-800 text-lg">Gunawan</div>
                                </td>
                                <td class="font-normal">
                                 <div class="font-semibold text-gray-500 uppercase">sales</div>
                                 <div class="text-gray-800 text-lg">Rahman</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

</div>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<x-library.datatable />
@push('page_scripts')
  
@endpush