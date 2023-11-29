<div class="p-0 object-center">
<?php

      if ($data->getFirstMediaUrl('images')) {
            $logo = $data->getFirstMediaUrl('images');
        }else{
            $logo = asset('images/fallback_product_image.png');
        }

?>
 <img src="{{ $logo }}" alt="background"
                class="rounded-xl h-12 bg-cover mx-auto">
 </div>