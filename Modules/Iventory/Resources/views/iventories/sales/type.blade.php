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


<div class="card-body">
                    <div class="flex flex-row grid grid-cols-2 gap-1">
                        <div class="p-2">
                       
                        </div>

                        <div class="p-2">

                        <div>Tgl</div>
                        <div>Kepada</div>

                        </div>
                    </div>

     
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Code</th>
      <th scope="col">NO Nota</th>
      <th scope="col">Berat Kotor</th>
      <th scope="col">Berat Bersih</th>
      <th scope="col">kadar</th>
      <th scope="col">JUmlah</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td>@mdo</td>
    </tr> 

    <tr>
      <th colspan="2"></th>
      <td>
          <div>Jumlah</div>
        <div>Diskon</div>
        <div>Total</div>


      </td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>@mdo</td>
      <td>@mdo</td>
     
    </tr>
   
  </tbody>
</table>


<table class="table table-bordered">
   <tbody>
    <tr>
      
      <td style="width:50%;"></td>
      <td>PIC</td>
      <td>SALES</td>
          
    </tr> 

   
  </tbody>
</table>



                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<x-library.datatable />
@push('page_scripts')
  
@endpush