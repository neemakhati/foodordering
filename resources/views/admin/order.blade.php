<x-app-layout>

</x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.admincss')
</head>
<body>
    <div class="container-scroller">
        @include('admin.navbar')
        <div style="margin: 100px; width: 2550px;">
            <table style="border-collapse: collapse; width: 100%; border: 1px solid #ddd; background-color: #333; color: #fff; text-align: center;">
                <thead>
                    <tr>
                        <th style="padding: 12px; background-color: #222; border-bottom: 1px solid #ddd;">Order ID</th>
                        <th style="padding: 12px; background-color: #222; border-bottom: 1px solid #ddd;">Username</th>
                        <th style="padding: 12px; background-color: #222; border-bottom: 1px solid #ddd;">Phone</th>
                        <th style="padding: 12px; background-color: #222; border-bottom: 1px solid #ddd;">Address</th>
                        <th style="padding: 12px; background-color: #222; border-bottom: 1px solid #ddd;">Food Details</th>
                        <th style="padding: 12px; background-color: #222; border-bottom: 1px solid #ddd;">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $order)
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $order->id }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $order->username }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $order->phone }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $order->address }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid #ddd;">
                            <ul style="list-style: none; padding: 10px;">
                                @foreach (json_decode($order->food_details) as $foodDetail)
                                <li style="margin-bottom: 6px;">Name: {{ $foodDetail->name }}<br>Price: {{ $foodDetail->price }}<br>Quantity: {{ $foodDetail->quantity }}</li>
                                @endforeach
                            </ul>
                        </td>

                        <td style="padding: 12px; border-bottom: 1px solid #ddd;">{{ $order->total_price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('admin.adminscript')
</body>
</html>
