
<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.admincss')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #d5bcbc;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #453636;
        }
        tr:hover {
            background-color: #9c7b7b;
        }
        .action-links a {
            color: #e4e9ed;
            text-decoration: none;
            margin-right: 10px;
        }
        .action-links a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
<div class="container-scroller">
    @include('admin.navbar')
    <div style="margin: 100px; width: 2550px;">
        <table>
            <thead>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Food Details</th>
                <th>Total Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $index => $order)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $order->username }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>
                        <ul style="list-style: none; padding: 10px;">
                            @foreach (json_decode($order->food_details) as $foodDetail)
                                <li style="margin-bottom: 6px;">Name: {{ $foodDetail->name }}<br>Price: {{ $foodDetail->price }}<br>Quantity: {{ $foodDetail->quantity }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $order->total_price }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('admin.adminscript')
</body>
</html>
