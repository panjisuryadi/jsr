<div>
    <div class="card border-0 py-0">
        <div class="card-body px-3 py-1">
            <livewire:pos.filter :categories="$categories"/>
                <div class="grid grid-cols-4 md:gap-0 lg:gap-1 gap-2 md:grid-cols-4 sm:grid-cols-2 lg:grid-cols-4 relative">
                    <div wire:loading.flex class="position-absolute justify-content-center align-items-center" style="top:0;right:0;left:0;bottom:0;background-color: rgba(255,255,255,0.5);z-index: 99;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    @forelse($products as $product)

                    {{-- {{$product->product_item[0]->karat->penentuanHarga->harga_emas}} --}}


                    <div wire:click.prevent="selectProduct({{ $product }})" class="col-lg-3 col-md-6 mb-2" style="cursor: pointer;">

                        <div
                            class="h-40 lg:h-32 md:h-32 relative overflow-hidden rounded-md  hover:shadow-md"
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
                                class="absolute md:bottom-1 bottom-3 md:leading-4 left-2"
                                >
<<<<<<< Updated upstream
                                <div class="px-1 sm:p-4 md:mt-4 lg:p-2">
                                    <span  class="md:text-xs md:leading-4 block text-gray-600"> {{ @$product->category->category_name }} 
=======
                                <div class="px-1 p-2 sm:p-4">
                                    <span style="font-size:0.7rem;" class="block text-gray-600"> {{ @$product->category->category_name }} 
>>>>>>> Stashed changes
                                    </span>
                                    
                                    <h3 class="leading-5 font-semibold hover:text-red-400 mt-0.5 lg:text-sm sm:small md:text-sm md:leading-3 md:leading-4 text-lg text-gray-800">
                                    {{ $product->product_name }}
                                    </h3>
<<<<<<< Updated upstream
                                <div class="lg:text-sm md:small text-red-400">
                              {{@number_format($product->product_item[0]->karat->penentuanHarga->harga_emas)}}
                                 </div>
                                     
=======
                                <div class="text-red-400">
                              {{@format_currency($product->product_item[0]->karat->penentuanHarga->harga_emas)}}
                                 </div>
                                    
>>>>>>> Stashed changes
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