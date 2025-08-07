<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        .totals-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    font-size: 16px;
}

.totals-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.totals-table tr:last-child td {
    border-bottom: none;
}

.total-amount td {
    font-size: 18px;
    font-weight: bold;
    color: #000;
    background-color: #f7f7f7;
}

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f3f3f3;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 60px;
            color: rgba(0, 0, 0, 0.05);
            z-index: 0;
            white-space: nowrap;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        .logo img {
            max-width: 120px;
        }
        .company-details {
            text-align: right;
        }
        .company-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .invoice-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-title h1 {
            font-size: 28px;
            color: #444;
            margin: 0;
        }
        .invoice-title p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
        .section {
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        .section h3 {
            font-size: 18px;
            color: #555;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .section p {
            font-size: 14px;
            margin: 5px 0;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }
        table th {
            background-color: #f7f7f7;
            color: #555;
        }
        .totals {
            text-align: left;
            margin-top: 10px;
        }
        .totals p {
         
            font-size: 16px;
            margin: 15px 0;
        }
        .totals p strong {
            color: #000;

        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            .header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .company-details {
                text-align: center;
                margin-top: 10px;
            }
            table th, table td {
                font-size: 12px;
                padding: 8px;
            }
            .totals p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Watermark -->
        <div class="watermark">MY BABE</div>  

        <!-- Header -->
        <div class="header">
            <div class="logo">
               <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/assets/website/images/logo.png'))) }}" alt="My Babe Logo">

            </div>
            <div class="company-details">
                <p><strong>My Babe</strong></p>
                <p>1055 Arthur Ave, Elk Groot</p>
                <p>67, New Palmas, South Carolina</p>
            </div>
        </div>

        <!-- Invoice Title -->
        <div class="invoice-title">
            <h1>Invoice</h1>
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $ordered_date }}</p>
            <p><strong>Delivery Date:</strong> {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</p>
        </div>

        <!-- Shipping Address -->
        <div class="section">
            <h3>Shipping Address</h3>
            <p>{{ $order->order_address }}</p>
        </div>

        <!-- Product Details -->
        <div class="section">
            <h3>Product Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Price (IQD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->product->product_name }}</td>
                        <td>{{ $cartItem->product->sku }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>{{ number_format($cartItem->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
       <!-- Totals Section -->
<div class="section totals">
    <table class="totals-table">
        <tr>
            <td>Subtotal:</td>
            <td>IQD {{ number_format($order->subtotal_price, 2) }}</td>
        </tr>
        <tr>
            <td>Discount:</td>
            <td>- IQD {{ number_format($order->total_discount, 2) }}</td>
        </tr>
        <tr>
            <td>Delivery Fees:</td>
            <td>IQD {{ number_format($order->delivery_fee, 2) }}</td>
        </tr>
        <tr>
            <td>Coupon Discount:</td>
            <td>- IQD {{ number_format($order->coupon_discount, 2) }}</td>
        </tr>
        <tr>
            <td>Product Discount:</td>
            <td>- IQD {{ number_format($order->total_discount, 2) }}</td>
        </tr>
        <tr class="total-amount">
            <td><strong>Total Amount:</strong></td>
            <td><strong>IQD {{ number_format($order->grand_total, 2) }}</strong></td>
        </tr>
    </table>
</div>

    </div>
</body>
</html>
