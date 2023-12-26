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
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

<div class="flex relative py-2">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-b border-gray-300"></div>
    </div>
    
    <div class="relative flex justify-left">
        <span class="font-semibold tracking-widest pl-0 pr-3 text-sm uppercase text-dark">Laporan asset <i class="bi bi-question-circle-fill text-info" data-toggle="tooltip" data-placement="top" title="Laporan asset"></i>
        </span>
    </div>
</div>


<div class="card py-3 px-4 flex flex-row grid grid-cols-4 gap-2">
    
<div class="form-group">
    <label>Start Date <span class="text-danger">*</span></label>
    <input wire:model.defer="start_date" type="date" class="form-control" name="start_date">
    @error('start_date')
    <span class="text-danger mt-1">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label>End Date <span class="text-danger">*</span></label>
    <input wire:model.defer="end_date" type="date" class="form-control" name="end_date">
    @error('end_date')
    <span class="text-danger mt-1">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Status</label>
    <select wire:model.defer="purchase_return_status" class="form-control" name="purchase_return_status">
        <option value="">Select Status</option>
        <option value="Pending">Pending</option>
        <option value="Shipped">Shipped</option>
        <option value="Completed">Completed</option>
    </select>
</div>


<div class="form-group mb-0">
    <button type="submit" class="w-full mt-4 btn btn-primary">
   
    <i class="bi bi-shuffle"></i>
    Filter Report
    </button>
</div>


</div>






            <div class="card">

                <div class="card-body">
<div class="table-responsive mt-1">
<div class="table-wrap">
    <table class="table">
        <thead class="bg-green-500 text-uppercase">
            <tr>
                <th>auto</th>
                <th>auto</th>
                <th>auto</th>
                <th>Input</th>
                <th>Auto (berat x harga)</th>
            
            </tr>
        </thead> 

         <thead class="bg-gray-300 uppercase text-gray-800">
            <tr>
                <th>Tanggal</th>
                <th>Asset</th>
                <th>Berat</th>
                <th>Harga</th>
                <th>24K</th>
               
            </tr>
        </thead>


        <tbody>
            <tr>
                <th scope="row" class="scope">22/12/2023</th>
                <td>Stok Office</td>
                <td></td>
                <td></td>
                <td></td>
               
            </tr> 

            <tr>
                <th scope="row" class="scope">22/12/2023</th>
                <td>Stok Gudang</td>
                <td></td>
                <td></td>
                <td></td>
               
            </tr>

            <tr>
                <th scope="row" class="scope">22/12/2023</th>
                <td>17K</td>
                <td></td>
                <td></td>
                <td></td>
               
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

<x-library.datatable />
@push('page_scripts')


@endpush