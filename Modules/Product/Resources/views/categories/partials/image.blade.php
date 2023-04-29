<div class="p-0">
<?php

if ($data->image) {
            $logo = asset("storage/uploads/" .$data->image);
        }else{
            $logo = asset('images/fallback_product_image.png');
        }

?>
 <img src="{{ $logo }}" alt="background"
                class="rounded-xl h-30 bg-cover">
 </div>