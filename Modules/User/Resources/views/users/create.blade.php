@extends('layouts.app')

@section('title', 'Create User')

@section('third_party_stylesheets')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet"/>
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
          rel="stylesheet">
@endsection

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    @include('utils.alerts')
                    <div class="form-group">
                        <button class="btn btn-primary">Create User <i class="bi bi-check"></i></button>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                     

<div class="flex flex-row grid grid-cols-2 gap-2">
<div class="form-group">
    <label for="name">Name <span class="text-danger">*</span></label>
    <input class="form-control" type="text" name="name" required>
</div>

    <div class="form-group">
        <label for="is_active">Cabang</label>
<select class="form-control" name="cabang_id" id="cabang_id">
 <option value="" selected disabled>Pilih Cabang</option>
         @foreach(\Modules\Cabang\Models\Cabang::all() as $cabang)
            <option value="{{ $cabang->id }}">
               {{ $cabang->code }} | {{ $cabang->name }}
            </option>
        @endforeach
    </select>

    </div>

</div>
<div class="flex flex-row grid grid-cols-2 gap-2">

    <div class="form-group">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input class="form-control" type="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="kode_user">Code Sales<span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="text" id="code" class="form-control" name="kode_user">
            <span class="input-group-btn">
                <button class="btn btn-info relative rounded-l-none" id="generate-code">Generate</button>
            </span>
        </div>
        <span class="invalid feedback" role="alert">
            <span class="text-danger error-text product_code_err"></span>
        </span>
    </div>

</div>






                            <div class="form-row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password_confirmation"
                                               required>
                                    </div>
                                </div>
                            </div>






<div class="flex flex-row grid grid-cols-2 gap-2">
     <div class="form-group">
                                <label for="role">Role <span class="text-danger">*</span></label>
                                <select class="form-control" name="role" id="role" required>
                                    <option value="" selected disabled>Select Role</option>
                                    @foreach(\Spatie\Permission\Models\Role::where('name', '!=', 'Super Admin')->get() as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>   



                            <div class="form-group">
                                <label for="is_active">Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="is_active" id="is_active" required>
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Deactive</option>
                                </select>
                            </div>

</div>

                        

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="image">Profile Image <span class="text-danger">*</span></label>
                                <input id="image" type="file" name="image" data-max-file-size="500KB">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('third_party_scripts')
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script
        src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
@endsection

@push('page_scripts')
    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateSize,
            FilePondPluginFileValidateType
        );
        const fileElement = document.querySelector('input[id="image"]');
        const pond = FilePond.create(fileElement, {
            acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        });
        FilePond.setOptions({
            server: {
                url: "{{ route('filepond.upload') }}",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            }
        });


 $('#generate-code').click(function() {
           // var group = $('#group_id').val();
            //alert(group);
            $(this).prop('disabled', true);
            $(this).addClass('loading');
            $.ajax({
                url: '{{ route('users.code') }}',
                type: 'GET',
            //    data:{group:group},
                dataType: 'json',
                     success: function(response) {
                    if (response.code === '0') {
                             $('#code').prop('disabled', true);
                             $('#code').val('Kode Sales tidak boleh kosong..!!');
                            } else {
                              $('#code').val(response.code);
                            }

                      console.log(response);

                    },
                complete: function() {
                    $('#generate-code').prop('disabled', false);
                    $('#generate-code').removeClass('loading');
                }
            });
        });




    </script>
@endpush


