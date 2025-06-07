
{{-- {{$detail}} --}}

{{-- {!! \Milon\Barcode\Facades\DNS1DFacade::getBarCodeSVG($detail->product_code, $detail->product_barcode_symbology, 2, 110) !!} --}}


  <div class="flex  flex-row justify-center">
  <div class="justify-center items-center px-2 py-3 rounded-lg">
    <div class="row m-1"  id="qrcode_image">
      <div class="col-6">
        <div class="justify-center text-center items-center img-responsive img-fluid">
          {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG($detail->product_code, 'QRCODE', 15, 15) !!}
        </div>
      </div>
      <div class="col-6 flex justify-center items-center"> <!-- 👈 Make this a flex container -->
    <div class="py-2 text-center font-semibold uppercase text-gray-600 no-underline text-lg hover:text-red-600 leading-tight" style="font-size: 55pt;">
      <p class=""><strong>{{ $detail->product_code }}</strong></p>
      <p class=""><strong>{{ $detail->berat_emas }} gr</strong></p>
      <p class=""><strong>{{ $detail->karat->name }}</strong></p>
    </div>
</div>
    </div>
    <div class="py-0 justify-center text-center items-center mt-5">
            <!-- <a target="_blank" href="{{ route('products.getPdf', $detail->id) }}" class="btn btn-danger btn-sm">
              <i class="bi bi-printer"></i>&nbsp;Cetak Barcode
            </a> -->
              <button onclick="printQRCode()" class="btn btn-sm btn-info">Print QR Code</button>
          </div>
            

            
            

            

        </div>
        </div>

        <script>
  function printQRCodeold() {
    var printContents = document.getElementById('qrcode_image').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
    location.reload();  // Reload page to restore event handlers if needed
  }

  function printQRCode() {
  const content = document.getElementById('qrcode_image').innerHTML;
  const printWindow = window.open('', '_blank', 'width=600,height=400');

  printWindow.document.write(`
    <html>
      <head>
        <title>Print QR Code</title>
        <style>
          @media print {
            body {
              margin: 0;
              padding: 0;
              display: flex;
              justify-content: center;
              align-items: center;
              height: 100vh;
            }
          }
        </style>
      </head>
      <body>
        ${content}
        <script>
          window.onload = function() {
            window.print();
            window.onafterprint = function() {
              window.close();
            };
          };
        <\/script>
      </body>
    </html>
  `);

  printWindow.document.close(); // Needed for some browsers to start rendering
}

</script>




