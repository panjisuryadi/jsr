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
                                    <div class="form-group">
                                        <label for="company_phone">@lang('Company Phone')  <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_phone" value="{{ $settings->company_phone }}" required>
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
                                </div>

                                <div class="col-lg-4">
                                    <div class="mt-3 form-group pb-2 border-bottom text-center">
                                        <label for="image">Logo <span class="text-danger">*</span></label>
                                        <div class="flex flex-col relative overflow-hidden mt-3 gap-4 rounded-2xl">
                                            <img id="default_1" style="height: 90px !important;"
                                            src="<?php echo asset("storage/logo/$settings->site_logo")?>"
                                            class="h-full w-full">
                                            <img id="preview_1" src="" class="h-full w-full d-none">
                                            <div class="absolute bottom-4 flex items-center justify-center w-full">
                                                <input id="file" type="file" name="site_logo" onchange="previewFile(this,1);" name="site_logo" data-max-file-size="500KB">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                    <div class="mt-3 form-group pb-2 border-bottom text-center">
                                        <label for="image">Icon <span class="text-danger">*</span></label>
                                        <div class="flex flex-col relative overflow-hidden mt-3 gap-4">
                                            <img id="default_1" style="height: 90px !important;"
                                            src="<?php echo asset("storage/logo/$settings->small_logo")?>"
                                            class="h-full w-full">
                                            <img id="preview_1" src="" class="h-full w-full d-none">
                                            <div class="absolute bottom-4 flex items-center justify-center w-full">
                                                <input id="file" type="file" name="small_logo" onchange="previewFile(this,1);" name="small_logo" data-max-file-size="500KB">
                                            </div>
                                        </label>
                                    </div>
                                </div>









                                <div class="form-group mt-2">
                                    <label for="footer_text">Footer Text <span class="text-danger">*</span></label>
                                    <textarea rows="3" name="footer_text" class="form-control">{!! $settings->footer_text !!}</textarea>
                                </div>

                            </div>
                        </div>




                        {{-- {!! settings()->site_logo !!} --}}


<div class="grid grid-cols-4 gap-4">

</div>

{{--  'bg_sidebar' => '#d8d4d4',
            'bg_sidebar_hover' => '#5a6893',
            'bg_sidebar_aktif' => '#ffffff',
            'bg_sidebar_link' => '#2a2a2a',
            'bg_sidebar_link_hover' => '#fff',
            'link_color' => '#ffffff',
            'link_hover' => '#ffffff',
            'header_color' => '#ffffff',
            'btn_color' => '#ffffff', --}}

<div class="container mx-auto">
  <div class="grid grid-cols-4 gap-2">
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