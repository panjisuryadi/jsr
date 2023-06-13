<?php
  $location = $data->productlocation;
   ;?>
<ul>
    @forelse($location as $item)
  <li class="text-body-color mb-1 font-semibold flex text-xs" style="font-size: 0.8rem !important;">
{{--     <span class="text-primary mr-2 rounded-full text-base">
    >
    </span> --}}
  {{ @$item->location->name }}
  </li>
 @empty
  <li class="text-body-color text-danger mb-1 font-semibold flex text-xs" style="font-size: 0.8rem !important;">
 Unkown</li>
@endforelse

</ul>