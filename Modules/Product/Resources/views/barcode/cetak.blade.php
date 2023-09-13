<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barcodes</title>

    <link rel="stylesheet" href="{{ public_path('css/backend.css') }}">
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
  
<style>
.borderless td, .borderless th {
    border: none;
}
div#kanan {
  transform: rotate(180deg);
}
</style>
</head>
<body>
<div class="container">


<table  style="border: 1px solid #dddddd;border-style: dashed;" class="table borderless">

      <tr style="border:none !important;">
        <td style="border:none !important;text-align: left;">

         <div class="justify-center text-center">
       
      <div class="text-center justify-center items-center py-5">
           
  {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG($product->product_code,'QRCODE', 6, 6) !!}



       </div>
          
           
                <div class="justify-center text-center" style="font-size: 24px;color: #000;font-weight: bold;">
                   {{$product->product_code}}</div>
            </div>




        </td>
        <td style="border:none !important;">

         <div id="kanan" style="transform: rotate(180deg);" class="justify-right text-right">
       
       <div class="text-center justify-center items-center py-5">
           
  {!! \Milon\Barcode\Facades\DNS2DFacade::getBarCodeSVG($product->product_code,'QRCODE', 6, 6) !!}



       </div>
          
           
                <div class="justify-center text-center" style="transform: rotate(180deg); font-size: 24px;color: #000;font-weight: bold;">
                   {{$product->product_code}}</div>
            </div>


    </td>
      
      </tr>
    
  </table>

</div>
</body>
</html>
