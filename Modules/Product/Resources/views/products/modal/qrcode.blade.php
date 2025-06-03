
{{-- {{$detail}} --}}

{{-- {!! \Milon\Barcode\Facades\DNS1DFacade::getBarCodeSVG($detail->product_code, $detail->product_barcode_symbology, 2, 110) !!} --}}


  <div class="flex  flex-row justify-center">
  <div class="justify-center items-center px-2 py-3 rounded-lg">
            <div class="justify-center text-center items-center img-responsive img-fluid" id="qrcode_image">
 {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG($detail->product_code,'QRCODE', 15, 15) !!}

            </div>

            <div class="py-2 justify-center text-center items-center font-semibold uppercase text-gray-600 no-underline text-lg hover:text-red-600 leading-tight">
            {{$detail->product_code}}
            </div>
            <div class="py-0 justify-center text-center items-center">
           <a target="_blank" href="{{ route('products.getPdf', $detail->id) }}" class="btn btn-danger btn-sm">
                    <i class="bi bi-printer"></i>&nbsp;Cetak Barcode
                </a>
                <button onclick="printQRCode()" class="btn btn-sm btn-info">Print QR Code</button>
            </div>

            

        </div>
        </div>

        <script>
  function printQRCode() {
    var printContents = document.getElementById('qrcode_image').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    location.reload();  // Reload page to restore event handlers if needed
  }
</script>




