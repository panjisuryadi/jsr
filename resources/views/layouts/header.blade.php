<button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
    <i class="bi bi-list" style="font-size: 2rem;"></i>
</button>

<button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
    <i class="bi bi-list" style="font-size: 2rem;"></i>
</button>
<ul class="c-header-nav d-md-down-none">
        <li class="c-header-nav-item px-3 ">
            <a class="c-header-nav-link" href="#" target="_blank">
                <i class="c-icon cil-external-link relative"></i>&nbsp;
             {!! settings()->company_name !!}

            </a>
        </li>
        <li><x-library.widget /></li>
    </ul>
<ul class="c-header-nav ml-auto">



</ul>

<ul class="c-header-nav ml-auto mr-4">
    @can('create_pos_sales')
    <li class="c-header-nav-item mr-0">
        <a class="c-header-nav-link {{ request()->routeIs('app.pos.index') ? 'disabled' : '' }}"
          data-toggle="tooltip" data-placement="bottom" title="@lang('Hokkie POS')"
         href="{{ route('app.pos.index') }}">
     <img class="w-7 mb-1" src="{{  asset('images/icon/cart.svg') }}">
            {{-- <i class="bi bi-cart mr-1"></i> @lang('POS') --}}
        </a>
    </li>
    @endcan

  <li class="c-header-nav-item dropdown d-md-down-none">
           <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button"
title="@lang('Informasi Harga Emas')"
           aria-haspopup="true" aria-expanded="false">
         <img class="w-6 mb-1" src="{{  asset('images/icon/info.svg') }}">
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
            <div class="dropdown-header bg-light">
                <strong>Update Harga Emas</strong>
            </div>


         <iframe src="https://harga-emas.org/widget/widget.php?v_widget_type=current_gold_price&v_height=260"></iframe>
        </div>
    </li>
    @can('show_notifications')
    <li class="c-header-nav-item dropdown d-md-down-none mr-2">
        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button"
          title="@lang('Informasi Stok')"
         aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-bell" style="font-size: 20px;"></i>
            <span class="badge badge-pill badge-danger">
            @php
                $low_quantity_products = \Modules\Product\Entities\Product::select('id', 'product_quantity', 'product_stock_alert', 'product_code')->whereColumn('product_quantity', '<=', 'product_stock_alert')->get();
                echo $low_quantity_products->count();
            @endphp
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
            <div class="dropdown-header bg-light">
                <strong>{{ $low_quantity_products->count() }} Notifications</strong>
            </div>
            @forelse($low_quantity_products as $product)
                <a class="dropdown-item" href="{{ route('products.show', $product->id) }}">
        <i class="bi bi-hash mr-1 text-danger"></i> <span class="small text-muted">
         @lang('Product'): <strong>{{ $product->product_code }}</strong>
                @lang('is low in quantity!')</span>
                </a>
            @empty
                <a class="dropdown-item" href="#">
                    <i class="bi bi-app-indicator mr-2 text-danger"></i> No notifications available.
                </a>
            @endforelse
        </div>
    </li>
    @endcan

<li class="c-header-nav-item dropdown d-md-down-none mr-0">
        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button"
 title="@lang('Change language')"
        aria-haspopup="true" aria-expanded="false">
         <img class="w-6" src="{{  asset('images/icon/lang.svg') }}">&nbsp;
<span class="badge badge-pill badge-primary">
         {{strtoupper(App::getLocale())}}
</span>

        </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
                <div class="dropdown-header bg-light">
                    <strong>@lang('Change language')</strong>
                </div>
                <a class="dropdown-item" href="{{route("language.switch", "id")}}">
                   Indonesia (ID)
                </a>
                <a class="dropdown-item" href="{{route("language.switch", "en")}}">
                    English (EN)
                </a>


            </div>
    </li>



    <li class="c-header-nav-item dropdown">
        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button"
           aria-haspopup="true" title="Informasi Akun" aria-expanded="false">
            <div class="c-avatar mr-2">
                <img class="w-7 h-7 c-avatar rounded-circle" src="{{ auth()->user()->getFirstMediaUrl('avatars') }}" alt="Profile Image">
            </div>
            <div class="d-flex flex-column">
                <span class="font-weight-bold py-0">{{ auth()->user()->name }}</span>
                <span style="font-size: 0.7rem !important;" class="text-gray-500 text-xs">Online <i class="bi bi-circle-fill text-success"
                 style="font-size: 0.7rem !important;"></i></span>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right pt-0">
            <div class="dropdown-header bg-light py-2"><strong>Account</strong>

            </div>

            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="mfe-2  bi bi-person" style="font-size: 1.2rem;"></i> Profile
            </a>
            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mfe-2  bi bi-box-arrow-left" style="font-size: 1.2rem;"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>


<li class="c-header-nav-item dropdown d-md-down-none ml-1">
        <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button"
 title="@lang('Hokkie Apps')"
        aria-haspopup="true" aria-expanded="false">
        <i class="bi bi-grid-3x3-gap-fill text-xl"></i>
        </a>
            <div style="width: 260px !important;" class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
                <div class="dropdown-header bg-light">
                    <strong>@lang('List Hokkie Apps')</strong>
                </div>
             <x-library.menu />


            </div>
    </li>


</ul>
