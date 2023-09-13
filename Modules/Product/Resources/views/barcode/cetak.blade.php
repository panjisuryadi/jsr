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
          size: 24cm 8.7cm;
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
</style>
</head>
<body>
<table style="width:100%;" class="table borderless">

      <tr style="border:none !important;">

        <td style="width:40%;border:none !important;text-align: left;">

     <div style="position: relative;">
      <div style="position: absolute;
         top: 4rem;left:8rem;" class="text-center justify-center items-center">

        <img src="data:image/png;base64, {!! $barcode !!}">

       </div>
          
           
         <div class="justify-center text-center" style="margin-top:5rem; 
         font-size: 20px; color: #6d6c6c;font-weight: bold;position: absolute;
         bottom: 6rem;left:3rem;">
                   {{$product->product_code}}
               </div>

         </div>
     
        </td>
        <td style="width:50%; border:none !important;">

      <div  style="position:relative; transform: rotate(180deg);">
              
                <div style="margin-bottom:12rem;" class="text-center justify-center items-center">
                    <img src="data:image/png;base64, {!! $barcode !!}">
                </div>


           <div style="margin-top:12rem;" class="justify-center text-center" style="font-size: 20px;color: #6d6c6c;font-weight: bold;">
                   {{$product->product_code}}
            </div>



       

      </div>

    </td>
      
      </tr>
    
  </table>


</body>
</html>
