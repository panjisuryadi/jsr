 <div class="flex row justify-center items-center">
@can('show_product_transfer')
<a href="{{ route('products.view_qrcode', encode_id($data->id)) }}" id="QrCode" class="btn btn-outline-info btn-sm">
  <i class="bi bi-upc"></i> Qr Code
</a>
@endcan
</div>
