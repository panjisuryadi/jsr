<div class="grid grid-cols-2 gap-2 m-2">
    
    <div class="px-2">
        
        <table class="table table-striped mb-0">
             <tr>
                <th>Cabang</th>
                <td>{{ $product->cabang->code }} | {{ $product->cabang->name }}</td>
            </tr>
            <tr>
                <th>Product Code</th>
                <td>{{ $product->product_code }}</td>
            </tr>
            <tr>
                <th>Barcode Symbology</th>
                <td>{{ $product->product_barcode_symbology }}</td>
            </tr> 

            
            <tr>
                <th>Name</th>
                <td>{{ $product->product_name }}</td>
            </tr>
            <tr>
                <th>Category</th>
                <td>{{ $product->category->category_name }}</td>
            </tr>
            
      
            
            
            <tr>
                <th>Note</th>
                <td>{{ $product->product_note ?? 'N/A' }}</td>
            </tr>
        </table>

    </div>
    <div class="px-2">
        
        <div class="justify-center text-center items-center">
            {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG($product->product_code,'QRCODE', 12, 12) !!}
        </div>
    </div>
</div>