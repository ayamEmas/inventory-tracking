<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            color: #333;
        }
        .header p {
            font-size: 12px;
            color: #666;
            margin: 5px 0 0 0;
        }
        .department {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .department h2 {
            font-size: 14px;
            color: #333;
            margin: 0 0 10px 0;
            padding: 5px;
            background-color: #f3f4f6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .qr-cell {
            width: 100px;
            text-align: center;
        }
        .qr-code {
            width: 80px;
            height: 80px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ $date }}</p>
    </div>

    @foreach($groupedInventories as $departmentName => $departmentItems)
        <div class="department">
            <h2>{{ $departmentName }}</h2>
            <table>
                <thead>
                    <tr>
                        <th style="width: 100px">ID Tag</th>
                        <th style="width: 100px">Date</th>
                        <th style="width: 200px">Item</th>
                        <th style="width: 100px">QR Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departmentItems as $inventory)
                        <tr>
                            <td>{{ $inventory->id_tag }}</td>
                            <td>{{ $inventory->date ?? 'No Date' }}</td>
                            <td>{{ $inventory->item }}</td>
                            <td class="qr-cell">
                                <img src="data:image/png;base64,{{ $inventory->qrCode }}" alt="QR Code" class="qr-code">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    <div class="footer">
        <p>This document was generated from the Inventory Management System</p>
        <p>Scan QR codes to view/edit individual items</p>
    </div>
</body>
</html> 