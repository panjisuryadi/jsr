<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        @page {
            size: A5 landscape; /* A5 paper size in landscape orientation */
            margin: 10mm; /* Small margin for the page */
        }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            width: 100%;
            height: 100%;
            overflow: hidden;
            box-sizing: border-box;
        }

        .invoice {
            width: 100%;
            max-width: 100%;
            /* padding: 15px; */
            background-color: #f9f9f9;
            box-sizing: border-box;
            margin: 0 auto; /* Center the invoice */
        }

        .header {
            display: flex;
            justify-content: space-between; /* Ensure the logo and title are spaced apart */
            align-items: center;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .header img {
            width: 80px; /* Adjust logo size */
        }

        .header h2 {
            flex-grow: 1;
            text-align: center; /* Center the title */
            margin: 0;
        }

        .header p {
            text-align: center;
        }


        
        .header {
            text-align: center; /* Center the content */
            width: 100%;
        }

        .header img {
            display: inline-block; /* Display image inline */
            width: 80px; /* Set the logo size */
            vertical-align: middle; /* Align the logo vertically */
            margin-right: 10px; /* Space between the logo and text */
        }

        .header div {
            display: inline-block; /* Display the text inline */
            vertical-align: middle; /* Align the text vertically */
            text-align: left; /* Align text to the left */
        }

        .header h2, .header p {
            margin: 0;
        }



        /* .invoice-details {
            width: 100%;
            margin-top: 10px;
            font-size: 12px;
            table-layout: fixed;
        }

        .invoice-details td {
            padding: 5px 10px;
            word-wrap: break-word;
        }

        .invoice-details .left {
            width: 50%;
            text-align: left;
        }

        .invoice-details .right {
            width: 50%;
            text-align: right;
        } */




        /* Align Total to the right */
        .total {
            margin-top: 10px;
            margin-right: 30px;
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .invoice-table th, .invoice-table td {
            padding: 6px 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .invoice-table td {
            background-color: #fff;
        }

        .footer p {
            margin-top: 10px;
            font-size: 12px;
        }

        .footer p:last-child {
            margin-top: 15px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @php
    $date = date('d M Y');
    $imagePath = public_path('storage/uploads/logo.png'); // Path to your image
    $imageData = base64_encode(file_get_contents($imagePath));
    $imageSrc = 'data:image/png;base64,' . $imageData;
    @endphp
    @foreach($products as $index => $product)
    <div class="invoice">
        <div class="header">
            <!-- Left side: Logo -->
            <img src="{{ $imageSrc }}" alt="Logo">
            
            <!-- Centered: Toko Emas Cahaya -->
            <h2>Toko Emas Cahaya</h2>
            <p>{{ $product['alamat'] }}</p>
            <p>{{ $product['telp'] }}</p>
        </div>

        <!-- Invoice Details table -->
        <table class="invoice-details">
            <tr>
                <td class="left"><strong>No:</strong> {{ $product['sales_id'] }}</td>
                <td class="right"><strong>Tanggal:</strong> {{ $date }}</td>
            </tr>
            <tr>
                <td class="left"><strong>Penerima:</strong> {{ $product['customer'] }}</td>
                <td class="right"><strong>Alamat:</strong> {{ $product['address'] }}</td>
            </tr>
        </table>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Berat</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $product['desc'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['gram'] }}</td>
                    <td>Rp {{ number_format($product['harga'], 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            <div><strong>Total: </strong>  Rp {{ number_format($product['harga'], 0, ',', '.') }}</div>
        </div>

        <div class="footer">
            <p>Hormat Kami,</p>
            <p>Toko Emas Cahaya</p>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>{{ $product['info'] }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Add page break except after last item --}}
    @if (!$loop->last)
    <div class="page-break"></div>
    @endif
    @endforeach
</body>
</html>
