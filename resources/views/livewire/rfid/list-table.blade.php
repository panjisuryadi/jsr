<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    <span>{{ session('message') }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        @endif
{{--
<h1 class="text-primary">{{ $add_produk; }}</h1> --}}

        <div style="height: 500px !important;" class="table-responsive position-relative border-left relative h-full">
            <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

{{-- {{ $product->getFirstMediaUrl('images') }} --}}
<div class="px-3">
    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
        @if($cart_items->isNotEmpty())
        @foreach($cart_items as $cart_item)

{{-- {{ $cart_items }} --}}

        <li class="py-3 sm:py-4">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" src="{{ url('images/fallback_product_image.png') }}" alt="Neil image">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        {{ $cart_item->name }}
                    </p>
                    <p class="text-xs text-gray-500 truncate dark:text-gray-500">
                         {{ $cart_item->options->code }}  |  <span class="text-blue-400">{{ $cart_item->options->rfid }}</span>
                    </p>
                </div>
                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                   <a href="#" wire:click.prevent="removeItem('{{ $cart_item->rowId }}')">
                                        <i class="bi bi-x-circle font-2xl text-danger"></i>
                                    </a>
                </div>
            </div>



        </li>
        @endforeach





        @else

        <span class="text-danger">
            @lang('Please search & select products!')
        </span>

        @endif

    </ul>

</div>
 @php
 $total_with_shipping = Cart::instance($cart_instance)->count()
 @endphp
<div class="absolute bottom-0 right-0 px-2 flex flex-row justify-between">
    <div></div>
    <div class="text-right">
        <p class="text-2xl font-bold"> {{ $total_with_shipping }}</p>
        <p class="text-xxsm text-gray-400">Total.</p>
    </div>
</div>
        </div>
    </div>



</div>
