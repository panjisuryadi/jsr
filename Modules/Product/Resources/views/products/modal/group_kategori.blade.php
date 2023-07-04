<div class=" px-3 py-2 grid grid-cols-3 gap-4 m-2 text-center no-underline">
    @foreach($listcategory as $category)
{{-- {{ $category }} --}}
    <div class="no-underline cursor-pointer p-2 w-full">
           <a class="w-full no-underline hover:no-underline" id="openModalKategori"
     href="{{ route('products.add_products_modal_categories',$category->id) }}" >
        <div class="justify-center items-center border-2 border-yellow-500 bg-white  px-2 py-3 rounded-lg transform transition duration-500 hover:scale-110">
            <div class="justify-center text-center items-center">
                <?php
                if ($category->image) {
                $image = asset(imageUrl() . $category->image);
                }else{
                $image = asset('images/logo.png');
                }
                ?>
                <img id="default_1" src="{{ $image }}" alt="images"
                class="h-16 w-16 object-contain mx-auto"/>
            </div>
            <div
            class="font-semibold text-gray-600 no-underline hover:text-red-600 leading-tight">
            {{ $category->category_name }}
            </div>
        </div>
        </a>
    </div>


    @endforeach
</div>