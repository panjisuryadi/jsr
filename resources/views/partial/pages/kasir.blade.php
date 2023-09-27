

<div class="row">
    
<div class="col-md-6 col-lg-6">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                        <div class="p-4 rounded-full">
                              <img class="w-7 h-7 c-avatar rounded-circle" src="{{ auth()->user()->getFirstMediaUrl('avatars') }}" alt="Profile Image">
                        </div>
                        <div>
                            <div class="text-value text-primary">{{ auth()->user()->name }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">
                             {{ Auth::user()->namacabang?ucfirst(Auth::user()->namacabang->cabang()->first()->name):'' }} 
                        </div>
                        </div>
                    </div>
                </div>
            </div>

    
<div class="col-md-6 col-lg-6">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                <div class="p-3 flex flex-row">

                    <a class="hover:bg-gray-300 p-1 rounded-md border border-3 border-gray-800"
                        data-toggle="tooltip" data-placement="bottom" title="@lang('Hokkie POS')"
                        href="{{ route('app.pos.index') }}">
                        <i class="bi bi-cart text-2xl"></i>
                    </a> 

                    <a class="hover:bg-gray-300 p-1 ml-2 rounded-md border border-3 border-gray-800"
                        data-toggle="tooltip" data-placement="bottom" title="@lang('Penjualan')"
                        href="{{ route('sales.index') }}">
                        <i class="bi bi-receipt text-2xl"></i>
                    </a>

                   




                  </div>

 

                    </div>
                </div>
            </div>



</div>

