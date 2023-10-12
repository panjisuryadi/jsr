<div class="items-center justify-items-center text-center">
@if ($data->tipe_bayar == 'cicilan')
    <span class="text-center text-dark">
       {{ number_format($data->total_amount) }}
    </span>
@elseif ($data->status == 'total')
    <span class="badge badge-primary">
        {{ $data->status }}
    </span>
@else
    <span class="text-center text-dark">
        {{ number_format($data->total_amount) }}
    </span>
@endif
</div>