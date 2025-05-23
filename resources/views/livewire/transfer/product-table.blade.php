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

    <div class="table-responsive">
        <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <table class="table table-sm table-bordered">
            <thead>
            <tr class="align-middle">
                <th class="align-middle">No</th>
                <th class="align-middle">@lang('Product Name')</th>
                <th class="align-middle">Stock Data</th>
                <th class="align-middle">@lang('Stock Move')</th>
                <th class="align-middle">@lang('Location')</th>
                <th class="align-middle">@lang('Action')</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($products))
                @foreach($products as $key => $product)
                    <tr>
                        <td class="align-middle">{{ $key + 1 }}</td>
                        <td class="align-middle">{{ $product['product_name'] ?? $product['product']['product_name'] }} {{ $product['product_code'] ?? $product['product']['product_code'] }}</td>
                        <td class="align-middle text-center">
                            <span class="badge badge-info">
                                {{ $product['product_quantity'] ?? $product['stock'] }} {{ $product['product_unit'] ?? $product['product']['product_unit'] }}
                            </span>
                        </td>
                        <input type="hidden" name="product_ids[]" value="{{ $product['product']['id'] ?? $product['id'] }}">
                        <input type="hidden" name="location_id[]" value="{{ $product['location_id'] }}">
                        <td class="align-middle">
                            <input type="number" name="quantities[]" min="1" class="form-control form-control-sm" value="{{ $product['stock'] ?? 1 }}" max="{{ $product['stock'] ?? 1 }}">
                        </td>
                        <td class="align-middle">
                            @include('partial.location',['location_id' => $product['location_id']])
                        </td>
                        <td class="align-middle text-center">
                            <button type="button" class="btn btn-danger" wire:click="removeProduct({{ $key }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">
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
