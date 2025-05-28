<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Item Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
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
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .item-details {
            margin: 20px 0;
        }
        .item-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .item-details th, .item-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .item-details th {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 30%;
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
        <h1>Inventory Item Details</h1>
        <p>Generated on: {{ $date }}</p>
    </div>

    <div class="section">
        <div class="section-title">General Information</div>
        <div class="item-details">
            <table>
                <tr>
                    <th>ID Tag</th>
                    <td>{{ $inventory->id_tag }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $inventory->date ?? 'No Date' }}</td>
                </tr>
                <tr>
                    <th>Purchase Order No</th>
                    <td>{{ $inventory->purchase_order_no }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Supplier Information</div>
        <div class="item-details">
            <table>
                <tr>
                    <th>Supplier Name</th>
                    <td>{{ $inventory->supplier_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $inventory->supplier_email }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $inventory->supplier_address }}</td>
                </tr>
                <tr>
                    <th>Contact No</th>
                    <td>{{ $inventory->supplier_contactno }}</td>
                </tr>
                <tr>
                    <th>Fax No</th>
                    <td>{{ $inventory->supplier_faxno }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Asset Information</div>
        <div class="item-details">
            <table>
                <tr>
                    <th>Department</th>
                    <td>{{ $inventory->department->name }}</td>
                </tr>
                <tr>
                    <th>Asset Location</th>
                    <td>{{ $inventory->asset_location }}</td>
                </tr>
                <tr>
                    <th>Asset To</th>
                    <td>{{ $inventory->asset_to }}</td>
                </tr>
                <tr>
                    <th>Asset Code</th>
                    <td>{{ $inventory->asset_code }}</td>
                </tr>
                <tr>
                    <th>Asset Category</th>
                    <td>{{ $inventory->asset_cat }}</td>
                </tr>
                <tr>
                    <th>Asset Type</th>
                    <td>{{ $inventory->asset_type }}</td>
                </tr>
                <tr>
                    <th>Item Location</th>
                    <td>{{ $inventory->item_location }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Item Details</div>
        <div class="item-details">
            <table>
                <tr>
                    <th>Item</th>
                    <td>{{ $inventory->item }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $inventory->description }}</td>
                </tr>
                <tr>
                    <th>Serial Number</th>
                    <td>{{ $inventory->serial_num }}</td>
                </tr>
                <tr>
                    <th>Microsoft Office</th>
                    <td>{{ $inventory->microsoft_office }}</td>
                </tr>
                <tr>
                    <th>Tel Number</th>
                    <td>{{ $inventory->tel_number }}</td>
                </tr>
                <tr>
                    <th>NOS</th>
                    <td>{{ $inventory->nos }}</td>
                </tr>
                <tr>
                    <th>Amount (RM)</th>
                    <td>{{ number_format($inventory->amount, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>This document was generated from the Inventory Management System</p>
    </div>
</body>
</html> 