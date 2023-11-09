<div class="flex gap-1">
  <div class="w-3/4 card">


      <div class="card">
        <div class="card-body">
     <div class="flex items-center justify-center">
        <h1> ini halaman office</h1> 
    </div>

        </div>
    </div>





  </div>



  <div class="w-1/4 card">
<div class="card-body">
    <div class="form-group">
        <label for="image">Users Info <span class="text-danger">*</span></label>
        <img style="width: 100px;height: 100px;" class="d-block mx-auto img-thumbnail img-fluid rounded-circle mb-2" src="{{ auth()->user()->getFirstMediaUrl('avatars') }}" alt="Profile Image">
        
<div class="flex items-center justify-center">
    <div class="font-weight-bold py-1 px-2 text-lg">{{ ucfirst(auth()->user()->name) }}</div>
   
</div>
<div class="flex items-center justify-center">
    
     <div class="text-gray-500">
      Roles : {{ ucfirst(Auth::user()->roles->first()->name) }} 
    </div>
   
</div>
<div class="flex items-center justify-center">
    
   
    <div class="text-blue-400">
        Cabang : {{ Auth::user()->namacabang?ucfirst(Auth::user()->namacabang->cabang()->first()->name):'' }}
    </div>
</div>

    </div>
</div>




<hr class="mt-3">

  </div>
</div>








@section('third_party_stylesheets')

@endsection



<x-library.datatable />
@push('page_scripts')

@endpush