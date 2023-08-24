
        <div style="height: 18rem !important;" class="px-4 bg-white col-lg-12">
            {{-- {{ @$detail }} --}}
            <div  class="mx-auto flex flex-wrap">
              @if(isset($produk) && $produk->getFirstMediaUrl('images'))
                  <img alt="ecommerce" class="lg:w-1/2 w-full lg:h-64 h-64 object-cover object-center rounded" src="{{ $produk->getFirstMediaUrl('images') }}">
                @endif

                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                    <h2 class="text-sm title-font text-gray-500 tracking-widest">
                    {{ @$detail->code }}
                    </h2>
                    <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ @$detail->product_name }}</h1>
                    <div class="flex mb-4">
                        <span class="flex items-center">
                            <span class="text-gray-600 ml-1">Berat : {{ @$detail->berat_barang }}</span>
                        </span>

                    </div>
                    <p class="leading-relaxed text-gray-600">Fam locavore kickstarter distillery. Mixtape chillwave tumeric sriracha taximy chia microdosing tilde DIY. XOXO fam indxgo juiceramps cornhole raw denim forage brooklyn. Everyday carry +1 seitan poutine tumeric. Gastropub blue bottle austin listicle pour-over, neutra jean shorts keytar banjo tattooed umami cardigan.</p>
                       <div class="flex">
                    <span class="title-font font-medium text-2xl text-gray-900">
                    {{ number_format($detail->product_price) }}</span>
                    <button class="flex ml-auto text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded">Print Barcode</button>

                </div>

            </div>
        </div>
    </div>
