<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fb5849;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .order-details {
            background-color: #fff;
            color: #000;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .total-amount {
            font-size: 24px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Your Order Details</h1>
    <div class="order-details">
        
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Address:</strong> {{ $order->address }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <h2>Food Details:</h2>
        <ul>
            @foreach (json_decode($order->food_details) as $food)
                <li>{{ $food->name }} - ${{ $food->price }} (Quantity: {{ $food->quantity }})</li>
            @endforeach
        </ul>
    </div>
    <div class="total-amount">
        <strong>Total Amount:</strong> ${{ $order->total_price }}
    </div>
</body>
</html>
