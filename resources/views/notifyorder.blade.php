<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.admincss')
    <style>
        .bell-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 24px;
            color: #fb5849;
        }
        .bell-icon .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #e14b3b;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 12px;
        }
        .dropdown-menu {
            display: none;
            position: fixed;
            top: 60px;
            right: 20px;
            background-color: #d5bcbc;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 300px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1000;
        }
        .dropdown-menu.active {
            display: block;
        }
        .dropdown-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .dropdown-menu li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }
        .dropdown-menu li:last-child {
            border-bottom: none;
        }
        .read {
            display: none; /* Hide read items */
        }
    </style>
</head>
<body>
<div class="bell-icon">
    <i class="fa fa-bell"></i>
    <span class="badge" id="order-count">{{$newOrdersCount}}</span>
</div>
<div class="dropdown-menu" id="order-details">
    <ul id="order-list">
        @foreach($newOrders as $order)
            <li data-id="{{ $order->id }}">Order ID: {{ $order->id }}, Customer: {{ $order->username }}, Total: {{ $order->total_price }}</li>
        @endforeach
    </ul>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bellIcon = document.querySelector('.bell-icon');
        const orderDetails = document.getElementById('order-details');
        const orderList = document.getElementById('order-list');

        bellIcon.addEventListener('click', function() {
            orderDetails.classList.toggle('active');
        });

        orderList.addEventListener('click', function(event) {
            const clickedItem = event.target.closest('li');
            if (!clickedItem || !clickedItem.dataset.id) return;

            const orderId = clickedItem.dataset.id;
            fetch(`/mark-order-read/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ is_read: 1 })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        clickedItem.classList.add('read');
                        clickedItem.style.display = 'none';

                        const newOrdersCountElement = document.getElementById('order-count');
                        let newOrdersCount = parseInt(newOrdersCountElement.textContent.trim());
                        newOrdersCount--;
                        newOrdersCountElement.textContent = newOrdersCount;
                    } else {
                        console.error('Failed to mark as read');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
@include('admin.adminscript')
</body>
</html>
