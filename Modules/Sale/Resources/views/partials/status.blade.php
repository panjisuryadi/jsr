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
    <span class="badge badge-success">
        Tunai
    </span>
@endif
</div>