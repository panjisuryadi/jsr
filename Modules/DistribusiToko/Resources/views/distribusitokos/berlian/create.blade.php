@extends('layouts.app')

@section('title', 'Create Diamond Distribution')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('distribusitoko.index') }}">Distribusi Berlian</a></li>
        <li class="breadcrumb-item font-bold"></li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-1">
        @livewire('distribusi-toko.berlian.create',['cabang' => $cabang])
    </div>

@endsection



 @push('page_css')
<style>
        html,
        body {
           /* height: 100vh;*/
        }
    </style>
    
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
 @endpush
 @push('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


@endpush