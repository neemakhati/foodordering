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
        }
        .dropdown-menu li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

    <div class="bell-icon">
        <i class="fa fa-bell"></i>
        <span class="badge" id="order-count">0</span>
    </div>
    <div class="dropdown-menu" id="order-details">
        <ul id="order-list">
            <!-- Order details will be appended here -->
        </ul>
    </div><script>
        document.addEventListener('DOMContentLoaded', function() {
            const bellIcon = document.querySelector('.bell-icon');
            const orderCount = document.getElementById('order-count');
            const orderDetails = document.getElementById('order-details');
            const orderList = document.getElementById('order-list');

            bellIcon.addEventListener('click', function() {
                orderDetails.classList.toggle('active');
            });


            function fetchOrderCount() {
                fetch('/orders/count')
                    .then(response => response.json())
                    .then(data => {
                        orderCount.textContent = data.count;
                        fetchOrderDetails();
                    })
                    .catch(error => console.error('Error fetching order count:', error));
            }

            function fetchOrderDetails() {
                fetch('/orders/details')
                    .then(response => response.json())
                    .then(data => {
                        orderList.innerHTML = '';
                        data.orders.forEach(order => {
                            const li = document.createElement('li');
                            li.innerHTML = `<strong>Name:</strong> ${order.username}<br>
                                        <strong>Price:</strong> ${order.total_price}<br>
                                        <strong>Time:</strong> ${order.created_at}`;
                            orderList.appendChild(li);
                        });
                    })
                    .catch(error => console.error('Error fetching order details:', error));
            }

            setInterval(fetchOrderCount, 30000); // Fetch order count every 30 seconds

            // Initial fetch
            fetchOrderCount();
        });
    </script>
@include('admin.adminscript')
</body>
</html>
