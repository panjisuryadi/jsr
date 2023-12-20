<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice {
            width: 100%;
            margin: 0px auto;

            padding: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
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
            padding: 8px;
            text-align: left;
            font-size: 11pt !important;
            color: red; /* Change text color to red */
        }
        th{
            text-transform: uppercase;
        }
        .total {
            margin-top: 20px;
            text-align: right;
            color: red; /* Change text color to red */
        }
    </style>
</head>
<body>
    <div class="invoice">

<div class="invoice-items">

<table class="table1" style='width:100%; border: none !important; font-size:14pt; font-family:calibri; border-collapse: collapse;' border="0">
    <td class="table1" width='60%' align='left' style='border: none !important;padding-right:80px; vertical-align:top'>
        <span style='font-size:22pt'><b>{{ settings()->company_name }}</b></span></br>
         {{ settings()->company_email }}, {{ settings()->company_phone }}
                <br>{{ settings()->company_address }}
    </td>
    <td style='border: none !important;vertical-align:top' width='40%' align='left'>
        Invoice: {{ $sale->reference }}</br>
        Tanggal : {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</br>
        Kostumer: {{ $sale->customer_name }}</br>
        Alamat :  - </br>
    </td>
</table>
<p></p>
<table class="invoice-items">
    <thead>
        <tr>
            <th style="width:5%;" class ="text-center">#</th>
            <th style="width:5%;" class ="text-center">banyak nya</th>
            <th class ="text-center">nama barang</th>
            <th class ="text-center">kode</th>
            <th class ="text-center">berat (gr)</th>
            <th class ="text-center">Harga</th>
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
                    {{ $saleDetail->quantity }}</td>
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
            <td colspan = '5'><div style='text-align:right'>Qty : </div></td>
            <td style='text-align:right'>{{ number_format($totalQty) }} Item</td>
        </tr>

        <tr>
            <td colspan = '5'><div style='text-align:right'>Diskon : </div></td>
            <td style='text-align:right'>Rp {{ number_format($sale->dicount_amount) }}</td>
        </tr>

        <tr>
            <td colspan = '5'><div style='text-align:right'>Total : </div></td>
            <td style='text-align:right'>Rp {{ number_format($total) }}</td>
        </tr>


    </tfoot>
</table>
<hr>

<div style="padding: 2px;color: red !important;">
<p style="font-weight: bold;" class="bold">CATATAN</p>

<ol>
  <li>Mas dan Berat Barang telah di timbang dan disaksikan pembeli</li>
  <li>Barang ini dapat dijual kembali dengan potongan yang ditentukan</li>
  <li>Barang yang rusak terkena <strong>potongan hingga 30%</strong></li>
  <li>Bila dijual kembali harap membawa Surat</li>


</ol>

</div>
        <table style='width:100%!important; font-size:12pt;' cellspacing='2'>
            <tr>
                <td style="border: none !important;text-align: center;" align='center'>
                    Diterima Oleh,
                </br></br>
                </br></br>
                </br></br>
                <u>(..................................................)</u>
                </td>
                <td style='border: none !important; padding:5px; text-align:left; width:30%'></td>
                <td style="text-align: center; border: none !important;" align='center'>Hormat Kami,<br>
                <span style='font-size:12pt'><b>{{ settings()->company_name }}</b></span></br>

                </br>
                </br></br>
                </br></br>
                <u>(...................................................)</u>
                </td>
            </tr>
        </table>






        </div>
























    </div>






</body>
</html>






