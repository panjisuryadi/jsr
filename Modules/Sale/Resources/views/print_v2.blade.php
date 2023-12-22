<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice | JSR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }


        @page {
            size: 105mm 148.5mm; /* A4 size in millimeters */
            margin: 3mm; /* 20mm margin for all sides */
        }

        .invoice {
            width: 100%;
            margin: 0px auto;

            padding: 6px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            color: red; /* Change text color to red */
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            color: red; /* Change text color to red */
        }
        .invoice-details p {
            margin: 0;
        }
        .invoice-items {
            margin-top: 0px;

        }  

        .fh {
           font-size: 7pt !important;
           line-height: 1;
           text-align: center;

        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
.table1 table {
            width: 100%;
            border-collapse: collapse;
        }

  .table1 th, td {
            border: none;

        }
  
        th, td {
            border: 1px solid red; /* Change border color to red */
            padding: 2px;
            text-align: left;
            font-size: 7pt !important;
            color: red; /* Change text color to red */
        }
        th{
            text-transform: uppercase;

        }
        .total {
            margin-top: 2px;
            text-align: right;
            color: red; /* Change text color to red */
        }
    </style>
</head>
<body>
    <div class="invoice">

<div class="invoice-items">

<table class="table1" style='width:100%; border: none !important; font-size:13pt; font-family:calibri; border-collapse: collapse;' border="0">
    <td class="table1" width='60%' align='left' style='border: none !important;padding-right:60px; vertical-align:top'>
        <span style='font-size:16pt'><b>{{ settings()->company_name }}</b></span></br>
         {{ settings()->company_email }}, {{ settings()->company_phone }}
                <br>{{ settings()->company_address }}
    </td>
    <td style='border: none !important;vertical-align:top' width='40%' align='left'>
        <br>
        Invoice: {{ $sale->reference }}</br>
        Tanggal : {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</br>
        Kostumer: {{ $sale->customer_name }}</br>
        Alamat :  - </br>
    </td>
</table>
<br>
<table class="invoice-items">
    <thead>
        <tr >
            <th style="width:5%;" class ="fh text-center">No</th>
            <th style="width:10%;" class ="fh text-center">Gambar</th>
            <th style="width:5%;" class ="fh text-center">Jumlah</th>
            <th class ="fh text-center">barang</th>
            <th class ="fh text-center">kode</th>
            <th class ="fh text-center">berat <span style="font-size:4pt;">(gr)</span></th>
            <th class ="fh text-center">Harga</th>
        </tr>
    </thead>
    <tbody>
        @php
        $no = 1;
        $totalPrice = 0;
        $totalQty = 0;
        $total = 0;
        @endphp
        @forelse ($sale->saleDetails as $saleDetail)
        <tr>

            <td>{{ $no++ }}</td>


<td style="text-align:center;vertical-align:bottom">
    <?php
    
    //$img = public_path('images/fallback_product_image.png')
    $image = $saleDetail->product->images;
    if (empty($image)) {
        $imagePath = public_path('images/fallback_product_image.png');
     } else {
        $imagePath = public_path('storage/uploads/'.$image.'');
     }

    
    ?>
     <img src="{{ $imagePath }}" order="0" width="40"/>
    
    
</td>

                <td style="text-align:center;vertical-align:bottom">
               
                    {{ @$saleDetail->quantity }}

                </td> 

                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product->product_name }} 
                </td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product_code }}</td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->unit_price }}</td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ format_currency($saleDetail->price) }}
                </td>

        </tr>
        ​
        @php
        $totalPrice += $saleDetail->price;
        $totalQty += $saleDetail->quantity;
        $total += ($saleDetail->price * $saleDetail->quantity);
        @endphp
        @empty
        <tr>
            <td colspan="5" class="text-center">Tidak ada data</td>
        </tr>
        @endforelse


    </tbody>
    <tfoot>
        <tr>
            <td colspan = '6'><div style='text-align:right'>Qty : </div></td>
            <td style='text-align:right'>{{ number_format($totalQty) }} Item</td>
        </tr>

        <tr>
            <td colspan = '6'><div style='text-align:right'>Total : </div></td>
            <td style='text-align:right'>Rp {{ number_format($total) }}</td>
        </tr>

        <tr>
            <td colspan = '6'><div style='text-align:right'>Diskon : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->discount_amount) }}</td>
        </tr>

        <tr>
            <td colspan = '6'><div style='text-align:right'>Grand Total : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->grand_total_amount) }}</td>
        </tr>


    </tfoot>
</table>
<hr>

<div style="padding: 2px;color: red !important;">
<div style="font-weight: bold;font-size: 9pt;" class="bold">CATATAN</div>

<ol style="font-size:7pt;">
  <li>Mas dan Berat Barang telah di timbang dan disaksikan pembeli</li>
  <li>Barang ini dapat dijual kembali dengan potongan yang ditentukan</li>
  <li>Barang yang rusak terkena <strong>potongan hingga 30%</strong></li>
  <li>Bila dijual kembali harap membawa Surat</li>
</ol>

</div>
        <table style='width:100%!important; font-size:11pt;' cellspacing='2'>
            <tr>
                <td style="border: none !important;text-align: center;" align='center'>
                    Diterima Oleh,
                </br></br>
                </br></br>
                </br></br>
                <u>(.............................................)</u>
                </td>
                <td style='border: none !important; padding:5px; text-align:left; width:30%'></td>
                <td style="text-align: center; border: none !important;" align='center'>Hormat Kami,<br>
                <span style='font-size:9pt'><b>{{ settings()->company_name }}</b></span></br>

                </br>
                </br></br>
                </br></br>
                <u>(..............................................)</u>
                </td>
            </tr>
        </table>






        </div>
























    </div>






</body>
</html>






