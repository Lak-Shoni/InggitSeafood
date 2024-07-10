<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .company-details,
        .customer-details {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .invoice-info div {
            flex: 1;
            padding: 10px;
            text-align: center;
        }

        .invoice-info div:not(:last-child) {
            border-right: 1px solid #ddd;
        }

        .invoice-info span {
            display: block;
            margin-bottom: 5px;
        }

        .invoice-info .label {
            font-weight: bold;
            color: #555;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th,
        .items-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .items-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #333;
        }

        .items-table td {
            background-color: #fff;
        }

        .items-table .center {
            text-align: center;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }

        @media print {
            .header,
            .footer {
                display: none;
            }

            .invoice-container {
                border: none;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <h2>Invoice</h2>
        </div>
        <div class="company-details">
            <p><strong>Company Info</strong></p>
            <p>Street, City</p>
            <p>Zip Code</p>
            <p>State, Country</p>
            <p>Phone: 111-111-111</p>
        </div>
        <div class="invoice-info">
            <div>
                <span class="label">Invoice:</span>
                <span class="value">#{{ $order->order_code }}</span>
            </div>
            <div>
                <span class="label">Date:</span>
                <span class="value">{{ $order->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
        <div class="customer-details">
            <p><strong>Customer Info</strong></p>
            <p>{{ $user->nama }}</p>
            <p>{{ $order->address }}</p>
            <p>{{ $user->no_telpon }}</p>
        </div>
        <h4>Items</h4>
        <table class="items-table">
            <thead>
                <tr>
                    <th class="center">#</th>
                    <th>Item</th>
                    <th class="hidden-xs">Quantity</th>
                    <th class="hidden-480">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carts as $index => $cart)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td>{{ $cart->paket->nama_paket }}</td>
                        <td class="hidden-xs">{{ $cart->quantity }}</td>
                        <td>{{ 'Rp ' . number_format($cart->total_per_item, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total">
            Total amount: Rp. {{ number_format($order->total_price, 2, ',', '.') }}
        </div>
        <div class="footer">
            Thank you for choosing our services. We believe you will be satisfied with our services.
        </div>
    </div>
</body>

</html>
