<div class="items-center justify-items-center text-center">

<!-- Example single danger button -->
<div class="w-full btn-group">
  <button type="button" class="px-5 btn-sm btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Aksi
  </button>
  <div class="dropdown-menu">
     <a href="{{ route($module_name.'.print', $data->id) }}" class="dropdown-item" target="_blank">
        <i class="bi bi-printer"></i> &nbsp;@lang('Print')
    </a>
      @can('delete_'.$module_name.'s')
        <button id="delete" class="dropdown-item px-2 ml-2 hover:no-underline" onclick="
                event.preventDefault();
                if (confirm('Are you sure? It will delete the data permanently!')) {
                document.getElementById('destroy{{ $data->id }}').submit()
                }
                ">
            <i class="bi bi-trash"></i>&nbsp;@lang('Delete')
            <form id="destroy{{ $data->id }}" class="d-none" action="{{ route(''.$module_name.'.destroy', $data->id) }}" method="POST">
                @csrf
                @method('delete')
            </form>
        </button>
        @endcan
  </div>
</div>
</div>