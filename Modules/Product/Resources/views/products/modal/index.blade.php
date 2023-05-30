<div class="flex px-3 py-2 flex-wrap -m-2 text-center">
   @foreach(\Modules\Product\Entities\Category::all() as $category)
     <div  class="cursor-pointer p-2 md:w-1/4 sm:w-1/2 w-full">
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
          <div  style="line-height: 1 !important;" class="leading-tight">
<a id="openModalKategori"
href="{{ route('products.add_products_modal_categories',$category->id) }}" >{{ $category->category_name }}</a>

        </div>
        </div>
      </div>

    @endforeach

 </div>


