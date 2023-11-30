<div class="items-center justify-items-center text-center">
@if ($data->lock == 1)
    <span class="badge badge-primary">
        Aktif
    </span>
@else
    <span class="badge badge-success">
      Non Aktif
    </span>
@endif
</div>