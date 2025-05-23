<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Report</title>
    <style>
        table, th, td {
            border: 1px solid #000;
            border-collapse: collapse;
            padding: 8px;
        }
        th {
            background-color: #f5f5f5;
        }
        .nested-table {
            margin-top: 8px;
            width: 100%;
            font-size: 12px;
        }
    </style>
</head>
<body style="font-family: sans-serif; font-size: 14px; color: #333;">

    <h2>Seller Sales Report</h2>

    <p><strong>Period:</strong> {{ $report['start_date'] }} to {{ $report['final_date'] }}</p>

    <p>Here is the full {{ $report['seller']->name }}'s sales report for the selected period:</p>
    <ul>
        <li><strong>Total Sales:</strong> {{ $report['sales_count'] }}</li>
        <li><strong>Total Value:</strong> R$ {{ number_format($report['sales_value'] / 100, 2, ',', '.') }}</li>
        <li><strong>Total Commission:</strong> R$ {{ number_format($report['commission'] / 100, 2, ',', '.') }}</li>
    </ul>
    <table class="nested-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Value</th>
                <th>Commission</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report['sales'] as $sale)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sale['date'])->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($sale['amount'] / 100, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($sale['commission'] / 100, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>