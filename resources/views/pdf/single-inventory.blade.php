<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color:rgb(0, 0, 0);
            margin-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .field {
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
            color:rgb(37, 95, 194);
        }
        .value {
            color: #2d3748;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #718096;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inventory Details</h1>
        <p>Generated on: {{ $date }}</p>
    </div>

    <div class="section">
        <div class="section-title">General Information</div>
        <div class="grid">
            <div class="field">
                <span class="label">ID Tag:</span>
                <span class="value">{{ $inventory->id_tag }}</span>
            </div>
            <div class="field">
                <span class="label">Purchase Date:</span>
                <span class="value">{{ $inventory->date }}</span>
            </div>
            <div class="field">
                <span class="label">Purchase Order No:</span>
                <span class="value">{{ $inventory->purchase_order_no }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Supplier Information</div>
        <div class="grid">
            <div class="field">
                <span class="label">Supplier Name:</span>
                <span class="value">{{ $inventory->supplier_name }}</span>
            </div>
            <div class="field">
                <span class="label">Email:</span>
                <span class="value">{{ $inventory->supplier_email }}</span>
            </div>
            <div class="field">
                <span class="label">Address:</span>
                <span class="value">{{ $inventory->supplier_address }}</span>
            </div>
            <div class="field">
                <span class="label">Contact No:</span>
                <span class="value">{{ $inventory->supplier_contactno }}</span>
            </div>
            <div class="field">
                <span class="label">Fax No:</span>
                <span class="value">{{ $inventory->supplier_faxno }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Asset Information</div>
        <div class="grid">
            <div class="field">
                <span class="label">Department:</span>
                <span class="value">{{ $inventory->department->name }}</span>
            </div>
            <div class="field">
                <span class="label">Asset Location:</span>
                <span class="value">{{ $inventory->asset_location }}</span>
            </div>
            <div class="field">
                <span class="label">Asset To:</span>
                <span class="value">{{ $inventory->asset_to }}</span>
            </div>
            <div class="field">
                <span class="label">Asset Code:</span>
                <span class="value">{{ $inventory->asset_code }}</span>
            </div>
            <div class="field">
                <span class="label">Category:</span>
                <span class="value">{{ $inventory->asset_cat }}</span>
            </div>
            <div class="field">
                <span class="label">Asset Type:</span>
                <span class="value">{{ $inventory->asset_type }}</span>
            </div>
            <div class="field">
                <span class="label">Item Location:</span>
                <span class="value">{{ $inventory->item_location }}</span>
            </div>
            <div class="field">
                <span class="label">Item:</span>
                <span class="value">{{ $inventory->item }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Additional Information</div>
        <div class="grid">
            <div class="field">
                <span class="label">Serial Number:</span>
                <span class="value">{{ $inventory->serial_num }}</span>
            </div>
            <div class="field">
                <span class="label">Microsoft Office:</span>
                <span class="value">{{ $inventory->microsoft_office }}</span>
            </div>
            <div class="field">
                <span class="label">Tel Number:</span>
                <span class="value">{{ $inventory->tel_number }}</span>
            </div>
            <div class="field">
                <span class="label">NOS:</span>
                <span class="value">{{ $inventory->nos }}</span>
            </div>
            <div class="field">
                <span class="label">Amount (RM):</span>
                <span class="value">{{ number_format($inventory->amount, 2) }}</span>
            </div>
            <div class="field">
                <span class="label">Description:</span>
                <span class="value">{{ $inventory->description }}</span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>This document was generated from the Inventory Management System</p>
    </div>
</body>
</html> 