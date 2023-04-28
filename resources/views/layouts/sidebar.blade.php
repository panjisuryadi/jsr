<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show
{{ request()->routeIs('app.pos.*')  ||  request()->routeIs('adjustments.*') ? 'c-sidebar-minimized' : '' }}" id="sidebar">
    <div class="c-sidebar-brand d-md-down-none">
        <a href="{{ route('home') }}">
            <img class="h-16 px-2 c-sidebar-brand-full"
            src="<?php echo asset("storage/logo/".settings()->site_logo)?>" alt="Site Logo">
            <img class="h-10 px-2 c-sidebar-brand-minimized" src="<?php echo asset("storage/logo/".settings()->small_logo)?>" alt="Site Logo">
        </a>
    </div>

{{--     <div class="c-sidebar-brand d-md-down-none">
        <a href="{{ route('home') }}">
            @if (file_exists(asset("storage/logo/".settings()->site_logo)))
            <img class="h-16 px-2 c-sidebar-brand-full"
            src="<?php echo asset("storage/logo/".settings()->site_logo)?>" alt="Site Logo">
            <img class="h-10 px-2 c-sidebar-brand-minimized" src="<?php echo asset("storage/logo/".settings()->small_logo)?>" alt="Site Logo">
            @else
            <img class="h-16 px-2 c-sidebar-brand-full"
            src="{{ asset('images/logo.png') }}" alt="Site Logo">
            <img class="h-10 px-2 c-sidebar-brand-minimized" src="{{ asset('images/icon.png') }}" alt="Site Logo">
            @endif
        </a>
    </div> --}}


    <ul class="c-sidebar-nav">
        @include('layouts.menu')
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 692px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 369px;"></div>
        </div>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
