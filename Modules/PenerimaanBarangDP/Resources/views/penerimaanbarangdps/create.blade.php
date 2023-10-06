@extends('layouts.app')
@section('title', $module_title)
@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('penerimaanbarangdp.index') }}">Penerimaan Barang DP</a></li>
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
.form-group {
margin-bottom: 0.5rem !important;
}
</style>
<style type="text/css">
.dropzone {
    height: 280px !important;
    min-height: 190px !important;
    border: 2px dashed #FF9800 !important;
    border-radius: 8px;
    background: #ff98003d !important;
}

.dropzone i.bi.bi-cloud-arrow-up {
    font-size: 5rem;
    color: #bd4019 !important;
}

.loading {
    pointer-events: none;
    opacity: 0.6;
}

.loading:after {
    content: '';
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 2px solid #fff;
    border-top-color: transparent;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    0% {
        transform: translate(-50%, -50%) rotate(0deg);
    }

    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
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
                      Penerimaan Barang <span class="text-yellow-500">DP</span></p>
                        </div>
                        


                    </div>
            
  
                        <div class="flex flex-row">
                            <x-library.alert />
                        </div>
                 
       <script src="{{ asset('js/jquery.min.js') }}"></script>
  
       <form id="FormTambah" 
        action="{{ route("penerimaanbarangdp.store") }}"
        method="POST" 
        enctype="multipart/form-data">

        @csrf
      {{-- {{$mainkategori}} --}}
                      
                        <div class="grid grid-cols-5 gap-7">
                            <div class="border-right pr-3 col-span-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="form-group">
                                        <div class="py-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="upload" id="up2" checked>
                                                <label class="form-check-label" for="up2">Upload</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="upload"
                                                id="up1">
                                                <label class="form-check-label" for="up1">Webcam</label>
                                            </div>
                                        </div>
                                        <div id="upload2" style="display: none !important;" class="align-items-center justify-content-center">
                                            <x-library.webcam />
                                        </div>
                                        <div id="upload1" style="display: block !important;" class="align-items-center justify-content-center">
                                            <div  class="dropzone d-flex flex-wrap align-items-center justify-content-center" id="document-dropzone">
                                                <div class="dz-message" data-dz-message>
                                                    <i class="text-red-800 bi bi-cloud-arrow-up"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                    <div class="form-group mt-5">
                                        <div>
                                            <label for="cabang_id">Cabang <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="form-control select2" name="cabang_id" id="cabang_id" >
                                                    <option value="" selected disabled>Pilih Cabang</option>
                                                    @foreach(\Modules\Cabang\Models\Cabang::all() as $cabang)
                                                    <option value="{{ $cabang->id }}">{{ $cabang->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('cabang_id'))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first('cabang_id') }}.</small
                                                    class="text-danger">
                                                </span>
                                            @endif
                                            </div>
                                        </div>
                                    </div> 
                                        @livewire('penerimaan-barang-dp.karat')
                                    </div>
                                </div>
                                <div class="mt-3">
                                    @livewire('penerimaan-barang-dp.pembayaran')
                                </div>
                                
                            </div>

                            <div class="col-span-2 bg-transparent order-first pt-3">
                                <div class="grid grid-cols-1 gap-y-3">
                                    
                                    <div class="flex flex-row grid grid-cols-2 gap-2">
                                        
                                        <div class="form-group">
                                            <label for="no_barang_dp">No Barang DP <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="no_barang_dp" class="form-control" name="no_barang_dp" placeholder="No Barang DP">
                                            </div>
                                            @if ($errors->has('no_barang_dp'))
                                                <span class="invalid feedback" role="alert">
                                                    <small class="text-danger">{{ $errors->first('no_barang_dp') }}.</small
                                                    class="text-danger">
                                                </span>
                                            @endif
                                        </div> 
    
                                        <div class="form-group">
                                            <?php
                                            $field_name = 'date';
                                            $field_lable = __('Tanggal');
                                            $field_placeholder = Label_case($field_lable);
                                            $invalid = $errors->has($field_name) ? ' is-invalid' : '';
                                            $required = 'required';
                                            ?>
                                            <label for="{{ $field_name }}">{{ $field_placeholder }}</label>
                                            <input type="date" name="{{ $field_name }}"
                                            class="form-control {{ $invalid }}"
                                            name="{{ $field_name }}"
                                            value="{{ old($field_name) }}"
                                            placeholder="{{ $field_placeholder }}" {{ $required }}>
                                            @if ($errors->has($field_name))
                                            <span class="invalid feedback"role="alert">
                                                <small class="text-danger">{{ $errors->first($field_name) }}.</small
                                                class="text-danger">
                                            </span>
                                            @endif
                                        </div>
    
                                    </div>
                                        
                                    <div class="form-group">
                                        <label for="nama_pemilik">Nama Konsumen <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="nama_pemilik" class="form-control" name="nama_pemilik" placeholder="Nama Konsumen">
                                        </div>
                                        @if ($errors->has('nama_pemilik'))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first('nama_pemilik') }}.</small
                                                class="text-danger">
                                            </span>
                                        @endif
                                    </div> 
                                    <div class="form-group">
                                        <label for="no_hp">No HP <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" id="no_hp" class="form-control" name="no_hp" placeholder="No HP">
                                        </div>
                                        @if ($errors->has('no_hp'))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first('no_hp') }}.</small
                                                class="text-danger">
                                            </span>
                                        @endif
                                    </div> 
                                    <div class="form-group">
                                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="alamat" class="form-control" name="alamat" placeholder="Alamat">
                                        </div>
                                        @if ($errors->has('alamat'))
                                            <span class="invalid feedback" role="alert">
                                                <small class="text-danger">{{ $errors->first('alamat') }}.</small
                                                class="text-danger">
                                            </span>
                                        @endif
                                    </div> 
                                </div>
                        
                                        </div>
                                        <div class="col-span-full">
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="5"></textarea>
                                                </div>
                                                @if ($errors->has('keterangan'))
                                                    <span class="invalid feedback" role="alert">
                                                        <small class="text-danger">{{ $errors->first('keterangan') }}.</small
                                                        class="text-danger">
                                                    </span>
                                                @endif
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="flex justify-between px-3 pb-2 border-bottom">
                                        <div>
                                        </div>
                                        <div class="form-group">
                                        
                                            <a class="px-5 btn btn-danger"
                                                href="{{ route("goodsreceipt.index") }}">
                                            @lang('Cancel')</a>
                                            <button id="SimpanTambah" type="submit" class="px-4 btn btn-primary">@lang('Save')  <i class="bi bi-check"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </form>
                </div>
            </div>
        </div>
 

@endsection

<x-library.datatable />
<x-library.select2 />
<x-toastr />
  @section('third_party_scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
    @endsection
 @push('page_scripts')

                <script type="text/javascript">
                    $('#up1').change(function() {
                        $('#upload2').toggle();
                        $('#upload1').hide();
                       });
                    $('#up2').change(function() {
                        $('#upload1').toggle();
                        $('#upload2').hide();
                    });

                </script>
                <script>
                    var uploadedDocumentMap = {}
                    Dropzone.options.documentDropzone = {
                        url: '{{ route('dropzone.upload') }}',
                        maxFilesize: 1,
                        acceptedFiles: '.jpg, .jpeg, .png',
                        maxFiles: 3,
                        addRemoveLinks: true,
                        dictRemoveFile: "<i class='bi bi-x-circle text-danger'></i> remove",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        success: function (file, response) {
                            $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
                            uploadedDocumentMap[file.name] = response.name;
                        },
                removedfile: function (file) {
                    file.previewElement.remove();
                    var name = '';
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name;
                    } else {
                        name = uploadedDocumentMap[file.name];
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{ route('dropzone.delete') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'file_name': `${name}`
                        },
                    });
                $('form').find('input[name="document[]"][value="' + name + '"]').remove();
                },
                init: function () {
                    @if(isset($product) && $product->getMedia('images'))
                        var files = {!! json_encode($product->getMedia('images')) !!};
                        for (var i in files) {
                            var file = files[i];
                            this.options.addedfile.call(this, file);
                            this.options.thumbnail.call(this, file, file.original_url);
                            file.previewElement.classList.add('dz-complete');
                            $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
                        }
                    @endif
                   }
                }
                </script>

               
         <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
                <script>
                jQuery.noConflict();
                (function($) {
             $('#generate-code').click(function() {
                var group = $('#group_id').val();
                //alert(group);
                $(this).prop('disabled', true);
                $(this).addClass('loading');
                $.ajax({
                    url: '{{ route('products.code_generate') }}',
                    type: 'POST',
                    data: { group: group },
                    dataType: 'json',
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.code === '0') {
                            $('#code').prop('readonly', true);
                            $('#code').val('Group harus di isi..!!');
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
           
         
                
            $(document).ready(function() {
                $('#category_id').change(function() {
                  var option = $(this).find(':selected').attr('data-name')
                //alert(option);
                
                if (option === 'Logam Mulia') {
                    toastr.success(option);
                    $('#lm_form').removeClass('d-none');
                    $('#lm_form').show();
                    $('#emas_form').hide();
                }
                else if(option == null) {
                // alert('Kategori tidak Boleh kosong');
                toastr.warning('Kategori belum di pilih ..!!!');
                
            } else {
                $('#lm_form').addClass('d-none');
                $('#lm_form').hide();
                $('#emas_form').removeClass('d-none');
                $('#emas_form').show();
            }

           });
         });


        $('#FormTambah').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        })(jQuery);
 </script>
@endpush

