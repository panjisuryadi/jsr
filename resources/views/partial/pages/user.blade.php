<div class="card-body">
    <div class="form-group">
        <label for="image">Users Info <span class="text-danger">*</span></label>
        <img style="width: 100px;height: 100px;" class="d-block mx-auto img-thumbnail img-fluid rounded-circle mb-2" src="{{ auth()->user()->getFirstMediaUrl('avatars') }}">        
        <div class="flex items-center justify-center">
            <div class="font-weight-bold py-1 px-2 text-lg">
                {{ ucfirst(auth()->user()->name) }}
            </div>
        </div>
        <div class="flex items-center justify-center">
            <div class="text-gray-500">
                Roles : {{ ucfirst(Auth::user()->roles->first()->name) }}
            </div>
        </div>
        <div class="flex items-center justify-center">
            <div class="text-blue-400">
                Cabang : {{ Auth::user()->isUserCabang()?ucfirst(Auth::user()->namacabang()->name):'' }}
            </div>
        </div>
    </div>
</div>