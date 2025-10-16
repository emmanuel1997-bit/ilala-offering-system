<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> {{ now()->format('Y-m-d ') }}</title>
     <link rel="icon" href="{{ asset('storage/images/steward.png') }}" type="image/png">
    
    <style>
        @page {
            size: A4;
            margin: 8mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
            height: 100%;
            box-sizing: border-box;
        }

        .receipt {
            border: 1px solid #000;
            padding: 8px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        /* HEADER using table layout for DomPDF compatibility */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }
        .header img {
            display: table-cell;
            width: 42px;
            height: 42px;
            object-fit: contain;
        }
        .header-text {
            display: table-cell;
            vertical-align: top;
            padding-left: 8px;
        }
        .header-text h2 {
            margin: 0;
            font-size: 12px;
            font-weight: bold;
        }
        .header-text h3 {
            margin: 2px 0;
            font-size: 10px;
        }
        .header-text p {
            margin: 1px 0;
            font-size: 9px;
        }

        /* CONTENT SECTION */
        .content {
            display: table;
            width: 100%;
        }
        .left-section, .right-section {
            display: table-cell;
            vertical-align: top;
        }
        .left-section {
            width: 52%;
            padding-right: 6px;
            line-height: 1.2;
        }
        .left-section p {
            margin: 2px 0;
            font-size: 10px;
            word-wrap: break-word;
        }

        .right-section {
            width: 48%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        .table, .table td, .table th {
            border: 1px solid #000;
        }
        .table td, .table th {
            padding: 2px 4px;
            text-align: left;
            vertical-align: middle;
            word-break: break-word;
        }
        .table th {
            background-color: #f9f9f9;
        }

        /* FOOTER SIGNATURE */
        .signature {
            display: table;
            width: 100%;
            margin-top: 6px;
            font-size: 9px;
        }
        .signature p {
            display: table-cell;
            width: 50%;
        }

        strong {
            font-weight: bold;
        }

        .receipt * {
            max-width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<div class="page">
    @for ($i = 0; $i < 8; $i++)
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <img src="{{ public_path('images/sda.jpg') }}" alt="SDA Logo">
            <div class="header-text">
                <h2>Seventh-day Adventist Church</h2>
                <h3>Indian Ocean Trial Field</h3>
                <p>P.O. Box 36318</p>
                <p><strong>STAKABADHI No:</strong> {{ $receipt['number'] }}</p>
            </div>
        </div>

        <!-- Body -->
        <div class="content">
            <!-- Left Info -->
            <div class="left-section">
                <p><strong>Nimepokea toka kwa:</strong> {{ $receipt['name'] }}</p>
                <p><strong>Kanisa la:</strong> {{ $receipt['church'] }}</p>
                <p><strong>Jumla ya fedha kwa maneno:</strong></p>
                <p>{{ $receipt['amount_words'] }}</p>
                <div class="signature">
                    <p><strong>Sahihi:</strong></p>     <img src="{{ public_path('images/signature.png') }}" alt="SDA Logo">
                    <p><strong>Tarehe:</strong> {{ now()->format('Y-m-d') }}</p>
                </div>
            </div>

            <!-- Right Table -->
            <div class="right-section">
                <table class="table">
                    <tr>
                        <td>Zaka</td>
                        <td style="text-align:right">{{ number_format($receipt['zaka'], 0) }}</td>
                    </tr>
                    <tr>
                        <td>Sadaka ya Pamoja I.O.F (58%)</td>
                        <td style="text-align:right">{{ number_format($receipt['sadaka_pamoja_iof'], 0) }}</td>
                    </tr>
                    <tr>
                        <td>Sadaka ya Kambi</td>
                        <td style="text-align:right">{{ number_format($receipt['sadaka_kambi'], 0) }}</td>
                    </tr>
                    <tr>
                        <th>Jumla Fedha ya I.O.F - A</th>
                        <th style="text-align:right">
                            {{ number_format($receipt['zaka'] + $receipt['sadaka_pamoja_iof'] + $receipt['sadaka_kambi'], 0) }}
                        </th>
                    </tr>
                    <tr>
                        <td>Sadaka ya Pamoja Kanisani (42%)</td>
                        <td style="text-align:right">{{ number_format($receipt['sadaka_pamoja_kanisani'], 0) }}</td>
                    </tr>
                    <tr>
                        <td>Sadaka ya Majengo ya Kanisa</td>
                        <td style="text-align:right">{{ number_format($receipt['sadaka_majengo'], 0) }}</td>
                    </tr>
                    <tr>
                        <th>Jumla Fedha ya Kanisa - B</th>
                        <th style="text-align:right">
                            {{ number_format($receipt['sadaka_pamoja_kanisani'] + $receipt['sadaka_majengo'], 0) }}
                        </th>
                    </tr>
                    <tr>
                        <th>Jumla ya Fedha zote (A + B)</th>
                        <th style="text-align:right">
                            {{ number_format(
                                $receipt['zaka'] + $receipt['sadaka_pamoja_iof'] + $receipt['sadaka_kambi'] +
                                $receipt['sadaka_pamoja_kanisani'] + $receipt['sadaka_majengo'], 0
                            ) }}
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endfor
</div>

</body>
</html>
