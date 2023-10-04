<div class="text-center">
@can('edit_'.$module_name.'')
    <a href="{{ route(''.$module_name.'.status', $data->id) }}"
    id="Status"
    data-toggle="tooltip"
     class="btn btn-outline-success btn-sm">
       {{$data->status}}
    </a>
@endcan

</div>