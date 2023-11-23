

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
                             {{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }} 
                        </div>
                        </div>
                    </div>
                </div>
            </div>

    
            <div class="col-md-6 col-lg-6">
                <div class="card border-0">
                    <div class="card-body p-0 d-flex align-items-center shadow-sm">
                <div class="p-3 flex flex-row">

                <a href="{{ route('app.pos.index') }}" class="hover:bg-gray-300 py-1 px-4 rounded-md border border-3 border-gray-800 rounded inline-flex items-center font-semibold hover:no-underline">
                  <i class="bi bi-cart text-2xl"></i>
                  <span class="px-2 text-lg">POS</span>
                </a>


               <a href="{{ route('sales.index') }}" class="ml-2 hover:bg-gray-300 py-1 px-4 rounded-md border border-3 border-gray-800 rounded inline-flex items-center font-semibold hover:no-underline">
                  <i class="bi bi-receipt text-2xl"></i>
                  <span class="px-2 text-lg">Penjualan</span>
                </a>

            
           

                  </div>

 

                    </div>
                </div>
            </div>



</div>

