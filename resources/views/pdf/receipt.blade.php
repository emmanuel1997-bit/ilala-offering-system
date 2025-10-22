

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <title>{{ now()->format('Y-m-d') }}</title>
    <link rel="icon" href="{{ asset('storage/images/steward.png') }}" type="image/png">
    <style>
        @page { size: A4; margin: 8mm; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .page { width: 100%; height: 100%; box-sizing: border-box; }
        .receipt {
            border: 1px solid #000;
            padding: 8px;
            margin-bottom: 10px;
            page-break-after: always; /* ensures each stewardship starts on a new page */
        }
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
        .header-text h2 { margin: 0; font-size: 12px; font-weight: bold; }
        .header-text h3 { margin: 2px 0; font-size: 10px; }
        .header-text p { margin: 1px 0; font-size: 9px; }

        .content { display: table; width: 100%; }
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

        .right-section { width: 48%; }
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
        .table th { background-color: #f9f9f9; }

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

        strong { font-weight: bold; }
        .receipt * { max-width: 100%; box-sizing: border-box; }
    </style>
</head>
<body>

<div class="page">

    @foreach ($payload['stewardship'] as $stewardship)

        @php
            $member = $stewardship['member'];
            $transactions = $stewardship['transactions'];
            $types = $payload['contributionTypes'];

            $conferenceItems = [];
            $churchItems = [];
            $conferenceTotal = 0;
            $churchTotal = 0;

            foreach ($transactions as $t) {
                $type = collect($types)->firstWhere('id', $t['contribution_type_id']);
                $amount = (float)$t['amount'];
                $confAmount = $amount * ($type['conference_percentage'] / 100);
                $churchAmount = $amount * ($type['church_percentage'] / 100);

                if ($confAmount > 0) {
                    $conferenceItems[] = ['name' => $type['contribution_name'], 'amount' => $confAmount];
                    $conferenceTotal += $confAmount;
                }

                if ($churchAmount > 0) {
                    $churchItems[] = ['name' => $type['contribution_name'], 'amount' => $churchAmount];
                    $churchTotal += $churchAmount;
                }
            }

            $grandTotal = $conferenceTotal + $churchTotal;
            $totalWords = ucfirst(trim(\App\Helpers\NumberToWords::convert($grandTotal))) . ' tu';
        @endphp

        <div class="receipt">
            <!-- Header -->
            <div class="header">
                <img src="{{ public_path('images/sda.jpg') }}" alt="SDA Logo">
                <div class="header-text">
                    <h2>Kanisa la Waadventista Wasabato</h2>
                    <h3>Indian Ocean Field</h3>
                    <p>P.O. Box 36318</p>
                    <p><strong>STAKABADHI No:</strong> {{ $stewardship['id'] }}</p>
                </div>
            </div>

            <!-- Body -->
            <div class="content">
                <!-- Left Info -->
                <div class="left-section">
                    <p><strong>Nimepokea toka kwa:</strong> {{ $member['full_name'] }}</p>
                    <p><strong>Kanisa la:</strong> — </p>
                    <p><strong>Jumla ya fedha kwa maneno:</strong></p>
                    <p>{{ $totalWords }}</p>
                    <div class="signature">
                        <p><strong>Sahihi:</strong></p>
                        <img src="{{ public_path('images/signature.png') }}" alt="Signature" style="width:60px;">
                        <p><strong>Tarehe:</strong> {{ \Carbon\Carbon::parse($stewardship['created_at'])->format('Y-m-d') }}</p>
                    </div>
                </div>

                <!-- Right Table -->
                <div class="right-section">
                    <table class="table">
                        <thead>
                            <tr><th colspan="2">Fedha za I.O.F (Sehemu ya Konferensi - A)</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($conferenceItems as $row)
                                <tr>
                                    <td>{{ ucfirst($row['name']) }}</td>
                                    <td style="text-align:right">{{ number_format($row['amount'], 0) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>Jumla Fedha ya I.O.F - A</th>
                                <th style="text-align:right">{{ number_format($conferenceTotal, 0) }}</th>
                            </tr>

                            <tr><th colspan="2">Fedha za Kanisa (Sehemu ya Kanisa - B)</th></tr>
                            @foreach ($churchItems as $row)
                                <tr>
                                    <td>{{ ucfirst($row['name']) }}</td>
                                    <td style="text-align:right">{{ number_format($row['amount'], 0) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>Jumla Fedha ya Kanisa - B</th>
                                <th style="text-align:right">{{ number_format($churchTotal, 0) }}</th>
                            </tr>

                            <tr>
                                <th>Jumla ya Fedha Zote (A + B)</th>
                                <th style="text-align:right">{{ number_format($grandTotal, 0) }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>

</body>
</html>


