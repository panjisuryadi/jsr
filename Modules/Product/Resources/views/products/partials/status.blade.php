<div class="flex row justify-center items-center">
{{-- {{$data->status}} --}}
@if($data->status == 2)
<a id="Approve" href="{{ route('products.transfer.approve', $data->id) }}" class="btn btn-outline-warning btn-sm"> Need Approve
</a>
@elseif($data->status == 3)
<button class="btn btn-outline-success px  btn-sm">Approved</button>

@elseif($data->status == 4)
<button class="btn btn-outline-danger px  btn-sm">Rejected</button>

@elseif($data->status == 1)
<button class="btn btn-success px btn-sm">Purchase</button>

@elseif($data->status == 0)
<button class="btn btn-info px  btn-sm p-1 text-xs">Ready</button>
@endif

</div>
