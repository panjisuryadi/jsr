<div>
    <div class="card border-0 py-0">
        <div class="card-body px-3 py-1">
            <livewire:pos.filter :categories="$categories"/>
                <div class="row position-relative">
                    <div wire:loading.flex class="col-12 position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    @forelse($products as $product)

                    {{-- {{$product->product_item[0]->karat->penentuanHarga->harga_emas}} --}}

                    <div wire:click.prevent="selectProduct({{ $product }})" class="col-lg-3 col-md-6 mb-2" style="cursor: pointer;">
                        <div
                            class="h-40 relative overflow-hidden rounded-lg shadow transition hover:shadow-lg"
                            >
                            <img
                            src="{{ $product->getFirstMediaUrl('images') }}"
                            class="absolute inset-0 h-full w-full object-cover"
                            />
                            <span style="font-size:0.7rem;" 
                                class="absolute top-2 leading-5 left-1 inline-flex items-center justify-center rounded-lg bg-red-400 px-1 py-0.2 text-red-200"
                                >
                                {{ @$product->product_item[0]->karat->name }}
                            </span>
                            <div
                                class="absolute bottom-3 leading-5 left-2 bg-gradient-to-t from-gray-900/50 to-gray-900/25"
                                >
                                <div class="px-1 p-2 sm:p-4">
                                    <span style="font-size:0.7rem;" class="block text-gray-600"> {{ @$product->category->category_name }} 
                                    </span>
                                    
                                    <h3 class="leading-5 font-semibold hover:text-red-400 mt-0.5 text-lg text-gray-800">
                                    {{ $product->product_name }}
                                    </h3>
                                <div class="text-red-400">
                              {{@format_currency($product->product_item[0]->karat->penentuanHarga->harga_emas)}}
                                 </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">
                            Produk tidak ada...
                        </div>
                    </div>
                    @endforelse
                </div>
                <div @class(['mt-3' => $products->hasPages()])>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>