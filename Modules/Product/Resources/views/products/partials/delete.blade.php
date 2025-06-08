@can('delete_products')
<button id="delete" class="btn btn-outline-danger btn-sm" onclick="
    event.preventDefault();
    if (confirm('Are you sure? It will delete the data permanently!')) {
        document.getElementById('destroy{{ $data->id }}').submit()
    }
    ">
    <i class="bi bi-trash"></i>&nbsp;
    <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('products.delete', $data->id) }}" method="POST">
        @csrf
        @method('delete')
    </form>
</button>
@endcan