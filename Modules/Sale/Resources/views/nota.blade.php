<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
     <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
             color: red;
            padding: 0;
        }

         @page {
            margin-top: 1pt;
            margin-bottom: 1pt;
         }

        @media print {
             body {margin-top: 50mm; margin-bottom: 50mm; 
                   margin-left: 0mm; margin-right: 50mm}
        }

        .invoice {
            width: 100%;
            margin: 0px auto;

            padding: 12px;
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

        td {
            border: 1px solid red; /* Change border color to red */
            padding: 4px;
            text-align: left;
            font-size: 8pt !important;
            color: red; /* Change text color to red */
        }
        th{
            text-transform: uppercase;
              border: 1px solid red; /* Change border color to red */
            font-size: 8pt !important;
            color: red; /* Change text color to red */
        }
        .total {
            margin-top: 20px;
            text-align: right;
            color: red; /* Change text color to red */
        }
   
        small{font-size:11px;}


    </style>
</head>
<body>

<div style="margin:0 auto">
    <div style="color:red;" id="receipt-data">
        <div class="centered">
            <h2 style="margin-bottom: 5px">{{ settings()->company_name }}</h2>

            <p style="font-size: 14px;line-height: 15px;margin-top: 0">
                {{ settings()->company_email }}, {{ settings()->company_phone }}
                <br>{{ settings()->company_address }}
            </p>
        </div>
        <p style="font-size: 14px;line-height: 15px;margin-top: 0">
            Tanggal: {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}<br>
            Invoice: {{ $sale->reference }}
            <br>
            Customer: {{ $sale->customer_name }}
        </p>


<table style="width:91mm" class="invoice-items">
    <thead>
        <tr>
            <th>#</th>
            <th style="width:10%;">Photo</th>
            <th style="width:5%;">Qty</th>
            <th>Barang</th>
            <th>kode</th>
            <th>berat (gr)</th>
            <th>Harga</th>
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
                     $image = $saleDetail->product->images;
                    if (empty($image)) {
                        $imagePath = public_path('images/fallback_product_image.png');
                     } else {
                        $imagePath = public_path('storage/uploads/'.$image.'');
                     }
                    
                    ?>
                     {{-- {{ $imagePath }} --}}
                  <img width="30" src="{{ $imagePath }}"/>



                </td>

                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->quantity }}</td>


                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product->product_name }} </td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->product_code }}</td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ $saleDetail->unit_price }}</td>
                <td style="text-align:center;vertical-align:bottom">
                    {{ format_currency($saleDetail->price) }}
                </td>

        </tr>

        @php
        $totalPrice += $saleDetail->price;
        $totalQty += $saleDetail->quantity;
        $total += ($saleDetail->price * $saleDetail->quantity);
        @endphp
        @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data</td>
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


    </div>
</div>

</body>
</html>
