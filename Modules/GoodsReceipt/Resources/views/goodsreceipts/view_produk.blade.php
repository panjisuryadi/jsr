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
            <div class="card col-lg-12">
{{-- {{ @$detail }} --}}
    <div class="mx-auto flex flex-wrap">
      <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="https://dummyimage.com/400x400">
      <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
        <h2 class="text-sm title-font text-gray-500 tracking-widest">
            {{ @$detail->code }}
       
        </h2>
        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ @$detail->product_name }}</h1>
        <div class="flex mb-4">
          <span class="flex items-center">
            <span class="text-gray-600 ml-1">Berat : {{ @$detail->berat_barang }}</span>
          </span>
      
        </div>
        <p class="leading-relaxed">Fam locavore kickstarter distillery. Mixtape chillwave tumeric sriracha taximy chia microdosing tilde DIY. XOXO fam indxgo juiceramps cornhole raw denim forage brooklyn. Everyday carry +1 seitan poutine tumeric. Gastropub blue bottle austin listicle pour-over, neutra jean shorts keytar banjo tattooed umami cardigan.</p>
        <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
      
          <div class="flex ml-6 items-center">
            <span class="mr-3">Size</span>
            <div class="relative">
             fdfdfd
              <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                  <path d="M6 9l6 6 6-6"></path>
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="flex">
          <span class="title-font font-medium text-2xl text-gray-900">
            {{ number_format($detail->product_price) }}</span>
          <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">Print</button>
        
        </div>
      </div>
    </div>


            </div>









        </div>
    </div>
@endsection

