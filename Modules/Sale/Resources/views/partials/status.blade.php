
<span class="badge badge-{{ $data->dp_payment ? 'warning' : 'success' }}">
    {{ empty($data->status) ? 'completed' : $data->status }}
</span>