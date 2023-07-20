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

        <div class="table-responsive position-relative">
            <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <table class="table table-bordered">
                <thead  style="background-color: {{settings()->header_color}} !important;" class="text-white p-1">
                <tr>
                    <th class="align-middle">Product</th>
                    <th class="align-middle">Net Unit Price</th>
                    <th class="align-middle text-center">Berat</th>
                    <th class="align-middle">Stock</th>
                    <th class="align-middle">Quantity</th>
                 
                    <th class="align-middle">Sub Total</th>
                    <!-- <th class="align-middle">Penyimpanan</th> -->
                    <th class="align-middle">Action</th>
                </tr>
                </thead>
                <tbody>


                    @if($cart_items->isNotEmpty())
                        @foreach($cart_items as $cart_item)

                            <tr>
                                <td class="align-middle">
                                    {{ $cart_item->name }} <br>

 

                                    {{-- <span class="badge badge-success">
                                        {{ $cart_item->options->code }}
                                    </span>
                                    @include('livewire.includes.product-cart-modal') --}}
                                </td>

                                <td class="align-middle">{{ format_currency($cart_item->options->unit_price) }}</td>  

                                <td class="align-middle text-center font-semibold">
                                  {{ $cart_item->options->product_item }}
                                </td>

                                <td class="align-middle text-center">
                                    <span class="badge badge-info">{{ $cart_item->options->stock . ' ' . $cart_item->options->unit }}</span>
                                </td>

                                <td class="align-middle">
                                    @include('livewire.includes.product-cart-quantity')
                                </td>


                                <td class="align-middle">
                                    {{ format_currency($cart_item->options->sub_total) }}
                                </td>

                                <!-- <td class="align-middle">
                                </td> -->

                                <td class="align-middle text-center">
                                    <a href="#" wire:click.prevent="removeItem('{{ $cart_item->rowId }}')">
                                        <i class="bi bi-x-circle font-2xl text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">
                        <span class="text-danger">
                           @lang('Please search & select products!')
                        </span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-md-end">
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Order Tax ({{ $global_tax }}%)</th>
                        <td>(+) {{ format_currency(Cart::instance($cart_instance)->tax()) }}</td>
                    </tr>

                    <tr>
                        <th>Grand Total</th>
                        @php
                            $total_with_shipping = Cart::instance($cart_instance)->total() + (float) $shipping
                        @endphp
                        <th>
                            (=) {{ format_currency($total_with_shipping) }}
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <input type="hidden" name="total_amount" id="total_amount" value="{{ $total_with_shipping }}">
     <input wire:model.lazy="shipping" type="hidden" class="form-control" name="shipping_amount" min="0" value="0" required step="0.01">

    <div class="form-row">
        <div class="col-lg-6">

            <input type="hidden" class="form-control" name="discount_percentage" min="0" max="100" value="{{ $global_discount }}" required>
            <input type="hidden" class="form-control" name="tax_percentage" min="0" max="100" value="{{ $global_tax }}" required>
        </div>

    </div>
</div>
