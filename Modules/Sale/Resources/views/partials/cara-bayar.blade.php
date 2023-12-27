<div class="items-center justify-items-center text-center">
@if ($data->tipe_bayar == 'cicilan')
<a 
class="btn btn-sm btn-info" 
id="Show" 
href="{{ route('sales.show_cicilan', $data->id) }}">
&nbsp;@lang('Cicilan')
</a>
@elseif ($data->status == 'total')
    <span class="badge badge-primary">
        {{ $data->status }}
    </span>
@else
    @foreach ($data->salePayments as $item)
        <span class="badge badge-success">
            {{ $item->payment_method }}
        </span>
    @endforeach
@endif
</div>