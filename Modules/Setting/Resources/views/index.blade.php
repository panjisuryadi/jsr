@extends('layouts.app')
@section('title', 'Edit Settings')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Settings</li>
</ol>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @include('utils.alerts')
            <div class="card">
                <div
                    style="background-color: {{settings()->header_color}} !important;"
                    class="card-header bg-primary text-white" >
                    <h5 class="mb-0">@lang('General Settings')</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="form-row">
                            <div class="d-flex col-lg-12">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="company_name">@lang('Company Name') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_name" value="{{ $settings->company_name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_email">@lang('Company Email') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_email" value="{{ $settings->company_email }}" required>
                                    </div>



                <div class="flex flex-row grid grid-cols-2 gap-1">
                    <div class="form-group">
                        <label for="default_currency_id">@lang('Cabang')  <span class="text-danger">*</span></label>
                        <select name="cabang_id" id="default_currency_id" class="form-control" required>
                            @foreach(\Modules\Cabang\Models\Cabang::all() as $cab)
                            <option {{ $settings->cabang_id == $cab->id ? 'selected' : '' }} value="{{ $cab->id }}">{{ $cab->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="company_phone">@lang('Company Phone')  <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_phone" value="{{ $settings->company_phone }}" required>
                    </div>
                </div>



                                    <div class="form-row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="default_currency_id">Default @lang('Currency')  <span class="text-danger">*</span></label>
                                                <select name="default_currency_id" id="default_currency_id" class="form-control" required>
                                                    @foreach(\Modules\Currency\Entities\Currency::all() as $currency)
                                                    <option {{ $settings->default_currency_id == $currency->id ? 'selected' : '' }} value="{{ $currency->id }}">{{ $currency->currency_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="default_currency_position">Default Currency Position <span class="text-danger">*</span></label>
                                                <select name="default_currency_position" id="default_currency_position" class="form-control" required>
                                                    <option {{ $settings->default_currency_position == 'prefix' ? 'selected' : '' }} value="prefix">Prefix</option>
                                                    <option {{ $settings->default_currency_position == 'suffix' ? 'selected' : '' }} value="suffix">Suffix</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="notification_email">Notification Email <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="notification_email" value="{{ $settings->notification_email }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="company_address">@lang('Company Address') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_address" value="{{ $settings->company_address }}">
                                    </div>




                                <div class="form-group">
                                    <label for="footer_text">Footer Text <span class="text-danger">*</span></label>
                                    <textarea rows="3" name="footer_text" class="form-control">{!! $settings->footer_text !!}</textarea>
                                </div>





                                </div>

                                <div class="col-lg-4">



                                    <div class="mt-3 form-group pb-2 border-bottom text-center">


    <?php

if ($settings->site_logo) {
    $site_logo = asset("storage/logo/$settings->site_logo");
}else{
    $site_logo = asset('images/logo.png');
}

?>

<div x-data="{photoName: null, photoPreview: null}" class="form-group">
      <?php
                $field_name = 'site_logo';
                $field_lable = __($field_name);
                $label = Label_Case($field_lable);
                $field_placeholder = $label;
                $required = '';
                ?>
 <input type="file" name="{{ $field_name }}" accept="image/*" class="hidden" x-ref="photo" x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
    ">

     <label for="Image" class="block text-gray-700 text-sm font-bold mb-2 text-center">{{ $label }}</label>

    <div class="text-center">
            <div class="mt-2" x-show="! photoPreview">
            <img src="{{$site_logo}}" class="w-40 h-40 m-auto rounded-full shadow">
        </div>
        <div class="mt-2" x-show="photoPreview" style="display: none;">
            <span class="block w-40 h-40 rounded-full m-auto shadow" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
            </span>
        </div>
        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2 ml-3" x-on:click.prevent="$refs.photo.click()">
          @lang('Select Image')
        </button>
    </div>

@if ($errors->has($field_name))
    <span class="invalid feedback"role="alert">
        <small class="text-danger">{{ $errors->first($field_name) }}.</small
        class="text-danger">
    </span>
    @endif
</div>

                                </div>
                                    <div class="mt-3 form-group pb-2 border-bottom text-center">

                                        <?php

                                    if ($settings->small_logo) {
                                        $small_logo = asset("storage/logo/$settings->small_logo");
                                    }else{
                                        $small_logo = asset('images/logo.png');
                                    }

                                    ?>


<div x-data="{photoName: null, photoPreview: null}" class="form-group">
      <?php
                $field_name = 'small_logo';
                $field_lable = __($field_name);
                $label = Label_Case($field_lable);
                $field_placeholder = $label;
                $required = '';
                ?>
 <input type="file" name="{{ $field_name }}" accept="image/*" class="hidden" x-ref="photo" x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
    ">

     <label for="Image" class="block text-gray-700 text-sm font-bold mb-2 text-center">{{ $label }}</label>

    <div class="text-center">
            <div class="mt-2" x-show="! photoPreview">
            <img src="{{$small_logo}}" class="w-40 h-40 m-auto rounded-full shadow">
        </div>
        <div class="mt-2" x-show="photoPreview" style="display: none;">
            <span class="block w-40 h-40 rounded-full m-auto shadow" x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'" style="background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url('null');">
            </span>
        </div>
        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2 ml-3" x-on:click.prevent="$refs.photo.click()">
          @lang('Select Image')
        </button>
    </div>

@if ($errors->has($field_name))
    <span class="invalid feedback"role="alert">
        <small class="text-danger">{{ $errors->first($field_name) }}.</small
        class="text-danger">
    </span>
    @endif
</div>








                                </div>


                            </div>
                        </div>




                        {{-- {!! settings()->site_logo !!} --}}


<div class="container mx-auto">
  <div class="flex flex-row grid grid-cols-4 gap-1">
     <div class="form-group">
        <label for="notification_email">Bg Colour <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar" value="{{ $settings->bg_sidebar }}" required>
    </div>
    <div class="form-group">
        <label for="notification_email">Bg sidebar Hover <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar_hover" value="{{ $settings->bg_sidebar_hover }}" required>
    </div>
  <div class="form-group">
        <label for="notification_email">Bg Sidebar Aktif <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar_aktif" value="{{ $settings->bg_sidebar_aktif }}" required>
    </div>

<div class="form-group">
        <label for="notification_email">Bg Sidebar Link <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar_link" value="{{ $settings->bg_sidebar_link }}" required>
    </div>


<div class="form-group">
        <label for="notification_email">Bg Sidebar Link hover <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="bg_sidebar_link_hover" value="{{ $settings->bg_sidebar_link_hover }}" required>
    </div>


<div class="form-group">
        <label for="notification_email">Link Color <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="link_color" value="{{ $settings->link_color }}" required>
    </div>
<div class="form-group">
        <label for="notification_email">Link hover <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="link_hover" value="{{ $settings->link_hover }}" required>
    </div>


<div class="form-group">
        <label for="notification_email">Header bg <span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="header_color" value="{{ $settings->header_color }}" required>
    </div>


<div class="form-group">
        <label for="notification_email">Btn Color<span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="btn_color" value="{{ $settings->btn_color }}" required>
    </div>

    <div class="form-group">
        <label for="notification_email">Btn Cancel<span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="btn_color" value="{{ $settings->btn_cancel }}" required>
    </div>

    <div class="form-group">
        <label for="notification_email">Btn Success<span class="text-danger">*</span></label>
        <input type="color" class="form-control" name="btn_color" value="{{ $settings->btn_sukses }}" required>
    </div>




  </div>
</div>

<div class="w-full flex mx-auto justify-between">
<div></div>

<div class="form-group mb-0 justify-end">
    <button type="submit"
    style="background-color: {{settings()->btn_color}} !important;"
    class="btn btn-primary"><i class="bi bi-check"></i> Save Changes</button>
</div>
</div>





                    </form>


                </div>
            </div>
        </div>



   {{--      <div class="col-lg-12">
            @if (session()->has('settings_smtp_message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    <span>{{ session('settings_smtp_message') }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            @endif
            <div class="card">
                <div
                    style="background-color: {{settings()->header_color}} !important;"
                    class="card-header bg-primary text-white">
                    <h5 class="mb-0">Mail Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('settings.smtp.update') }}" method="POST">
                        @csrf
                        @method('patch')
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_mailer">MAIL_MAILER <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="mail_mailer" value="{{ env('MAIL_MAILER') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_host">MAIL_HOST <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="mail_host" value="{{ env('MAIL_HOST') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_port">MAIL_PORT <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="mail_port" value="{{ env('MAIL_PORT') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_mailer">MAIL_MAILER</label>
                                    <input type="text" class="form-control" name="mail_mailer" value="{{ env('MAIL_MAILER') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_username">MAIL_USERNAME</label>
                                    <input type="text" class="form-control" name="mail_username" value="{{ env('MAIL_USERNAME') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="mail_password">MAIL_PASSWORD</label>
                                    <input type="password" class="form-control" name="mail_password" value="{{ env('MAIL_PASSWORD') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="mail_encryption">MAIL_ENCRYPTION</label>
                                    <input type="text" class="form-control" name="mail_encryption" value="{{ env('MAIL_ENCRYPTION') }}">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="mail_from_address">MAIL_FROM_ADDRESS</label>
                                    <input type="email" class="form-control" name="mail_from_address" value="{{ env('MAIL_FROM_ADDRESS') }}">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="mail_from_name">MAIL_FROM_NAME <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="mail_from_name" value="{{ env('MAIL_FROM_NAME') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit"
 style="background-color: {{settings()->btn_color}} !important;"

                            class="btn btn-primary"><i class="bi bi-check"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
 --}}







    </div>
</div>
@endsection
@push('page_js')
@endpush
@push('page_css')
@endpush