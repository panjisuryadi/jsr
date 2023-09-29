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
   @page {
/*          size: 9.5cm 3.0cm;*/
          margin: 0;
        }
  </style>
<style>
.borderless td, .borderless th {
    border: none;
}
div#kanan {
  transform: rotate(180deg);
}
.tf {
  transform: rotate(180deg);
}
</style>
</head>
<body>
<table class="table borderless">

      <tr style="border:none !important;">

        <td style="width:40%;border:none !important;text-align: left;">
<div style="relative">
<div style="position:absolute; top:1.8rem;font-size: 0.9rem;left:5.3rem;">
 <img width="57" src="data:image/png;base64, {!! $barcode !!}">   
</div>
<div style="position:absolute; bottom:1rem;left:3.6rem;">
  <div style="font-size: 0.9rem;">
    {{$product->product_name}}
  </div>
  <div style="font-size: 2rem;">
{{$product->product_item[0]->berat_total}} Gr
</div>
<div style="font-size: 0.9rem;">
  {{$product->product_code}}
</div>
</div>
  </div>
        </td>
<td style="border:none !important;">
 <div style="relative">
<div class="tf" style="position:absolute; top:1rem;right:3.7rem;">
<div style="font-size: 0.9rem;">
    {{$product->product_name}}
  </div>
  <div style="font-size: 2rem;">
{{$product->product_item[0]->berat_total}} Gr
</div>
<div style="font-size: 0.9rem;">
  {{$product->product_code}}
</div>
</div>

<div style="position:absolute; bottom:1.8rem;right:6.3rem;">
  <img class="tf" width="57" src="data:image/png;base64, {!! $barcode !!}">   
</div>

</div>   
    </td>
      
      </tr>
    
  </table>


</body>
</html>
