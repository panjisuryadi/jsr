<div class="flex row justify-center items-center">
@can('access_approve_product')
@if($data->status == 2)
<a id="Approve" href="{{ route('products.transfer.approve', $data->id) }}" class="btn btn-outline-warning btn-sm">
   Need Approve
</a>
@elseif($data->status == 3)
<button class="btn btn-outline-success btn-sm">Approved</button>
@endif

@endcan
</div>
