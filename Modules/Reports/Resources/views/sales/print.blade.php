<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>{{ $filename }}</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
        }

        h4,
        h5 {
            margin: 5px;
        }

        .header {
            text-align: center;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* Memberikan tinggi sebesar viewport height untuk membuatnya vertikal di tengah */
            margin-bottom: 20px;
        }

        .img-container {
            position: absolute;
            top: 0;
            left: 37%;
            align-items: center;
            max-width: 200px;
        }

        .img {
            width: 100%;
            height: auto;
            margin-left: auto;
        }

        .text {
            margin-top: 120px;
        }

        .nota-title,
        .nota-subtitle {
            text-align: center;
        }

        .nota-title {
            text-transform: uppercase;
        }

        .penerima {
            float: right;
            margin-top: 150px;
            margin-right: 50px;
            font-weight: bold;
        }

        .mb-5 {
            margin-bottom: 5rem;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="img-container">
            <img class="img" src="{{public_path('images/logo.png')}}" alt="Image">
        </div>
        <div class="text">
            <h4>JSR DIAMOND & JEWERLY</h4>
            Jl. Kamboja Gg. Tewaz V No. 25 Tanjung Karang Pusat Telp. 0813-6994-6343
            <br>
            <h5>Bandar Lampung</h5>
        </div>
    </header>
    <hr>
    <table class="table table-bordered table-striped text-center mb-0">

        <thead>
            <tr>
                <th colspan="6">
                    <h3 class="text-center font-bold">LAPORAN PENJUALAN</h3>
                    <h4 class="text-center font-bold">Periode {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }} </h4>
                </th>
            </tr>
            <tr>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Nama Kustomer</th>
                <th>Status</th>
                <th>Total</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
        @forelse($sales as $sale)
            <tr>
                <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</td>
                <td>{{ $sale->reference }}</td>
                <td>{{ $sale->customer_name }}</td>
                <td>
                    @if ($sale->status == 'Pending')
                        <span class="badge badge-info">
                    {{ $sale->status }}
                </span>
                    @elseif ($sale->status == 'Shipped')
                        <span class="badge badge-primary">
                    {{ $sale->status }}
                </span>
                    @else
                        <span class="badge badge-success">
                    {{ $sale->status }}
                </span>
                    @endif
                </td>
                <td>{{ format_uang($sale->total_amount) }}</td>
                <td>
                    @if ($sale->payment_status == 'Partial')
                        <span class="badge badge-warning">
                    {{ $sale->payment_status }}
                </span>
                    @elseif ($sale->payment_status == 'Paid')
                        <span class="badge badge-success">
                    {{ $sale->payment_status }}
                </span>
                    @else
                        <span class="badge badge-danger">
                    {{ $sale->payment_status }}
                </span>
                    @endif

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <span class="text-danger">No Sales Data Available!</span>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</body>

</html>