
<span class="badge badge-{{ $data->status == 'dp' ? 'warning' : ($data->status == 'failed' ? 'danger' : 'success') }}">
    {{ empty($data->status) ? 'completed' : $data->status }}
</span>