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
            width: 80%;
            margin: 20px auto;
            border: 1px solid red; /* Change border color to red */
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
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
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid red; /* Change border color to red */
            padding: 8px;
            text-align: left;
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

        <div class="invoice-details">
            <p>Invoice #: 12345</p>
            <p>Date: 2023-10-19</p>
        </div>
        <div class="invoice-details">
            <p>Bill To:</p>
            <p>Ship To:</p>
        </div>
        <div class="invoice-items">
            <table>
                <thead>
                    <tr>
                        <th>banyaknya</th>
                        <th>nama barang</th>
                        <th>kode</th>
                        <th>berat (gr)</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>

 @foreach($sale->saleDetails as $saleDetail)
                <tr>
                    <td colspan="2">
                        {{ $saleDetail->product->product_name }}
                        ({{ $saleDetail->quantity }} x {{ format_currency($saleDetail->price) }})
                    </td>
                    <td style="text-align:right;vertical-align:bottom">{{ format_currency($saleDetail->sub_total) }}</td>
                </tr>
            @endforeach



                </tbody>
            </table>
        </div>
        <div class="total">
            <p>Total: $150.00</p>
        </div>
    </div>
</body>
</html>
