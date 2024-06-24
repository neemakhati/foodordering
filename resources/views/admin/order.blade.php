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
        .pagination {
            display: flex;
            justify-content: center;
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination li a, .pagination li span {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            background-color: #d5bcbc;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .pagination li a:hover {
            background-color: #9c7b7b;
        }
        .pagination li.disabled span {
            color: #999;
            background-color: #f5f5f5;
            border-color: #ddd;
            cursor: not-allowed;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.0/dist/echo.iife.min.js"></script>
</head>
<body>
<div class="container-scroller">
    @include('admin.navbar')
    @include('notifyorder')
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
                    <td>{{ $index + 1 + ($data->currentPage() - 1) * $data->perPage() }}</td>
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

        <div class="pagination-wrapper">
            @if ($data->hasPages())
                <nav>
                    <ul class="pagination">

                        @if ($data->onFirstPage())
                            <li class="disabled" aria-disabled="true">
                                <span>Previous</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $data->previousPageUrl() }}" rel="prev">Previous</a>
                            </li>
                        @endif

                        @if ($data->hasMorePages())
                            <li>
                                <a href="{{ $data->nextPageUrl() }}" rel="next">Next</a>
                            </li>
                        @else
                            <li class="disabled" aria-disabled="true">
                                <span>Next</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        </div>
    </div>
</div>

@include('admin.adminscript')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>

    Pusher.logToConsole = true;

    var pusher = new Pusher('e7ec3d9de66764ab96b1', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel.');
    Echo.private('my-channel.' + this.order)
        .listen('OrderPlaced', (e) => {
            console.log("hi we r in");
        });
    channel.bind('my-event', function(data) {
        // alert(JSON.stringify(data));
        console.log(data);
        var notificationHtml = '<div class="notification">' +
            '<p>New order placed: Order ID ' + data.order.id + '</p>' +
            '<p>Username: ' + data.order.username + '</p>' +
            '</div>';

        $('#orderNotifications').prepend(notificationHtml);
    });

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.0/dist/echo.iife.min.js"></script>


</body>
</html>
