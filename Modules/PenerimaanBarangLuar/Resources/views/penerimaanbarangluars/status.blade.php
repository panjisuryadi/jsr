<div class="text-center">
@can('edit_'.$module_name.'')
    <a href="{{ route(''.$module_name.'.show', $data->id) }}"
    id="Show"
    data-toggle="tooltip"
     class="btn btn-outline-info btn-sm">
        <i class="bi bi-eye"></i> &nbsp;@lang('Show')
    </a>
@endcan


</div>