<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.admincss')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #0d0d0d;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        .container-scroller {
            min-height: 100vh;
            background-color: #191c24;
        }

        .container {
            margin-top: 100px;
            margin-left: -250px;
        }

        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .button {
            padding: 10px 20px;
            margin: 0 5px;
            font-size: 16px;
            color: #fff;
            background-color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button.active {
            background-color: #f4bcbc;
            color: #333;
        }

        .fetch-button {
            text-align: center;
            margin-top: 20px;
        }

        .chart-container {
            margin-top: 20px;
        }

        #ordersChart {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    @include('admin.navbar')
    @include('notifyorder')
    <div class="container">
        <div class="button-container">
            <button id="show-week-btn" class="button active" onclick="fetchOrderDataByDayOfWeek()">Week</button>
            <button id="show-year-btn" class="button" onclick="fetchOrdersThisYear()">Year</button>
        </div>
        <h1 style="text-align: center; margin-bottom: 20px;">Orders</h1>
        <div class="chart-container">
            <canvas id="ordersChart" height="300"></canvas>
        </div>
    </div>
</div>

<script>
    function fetchOrderDataByDayOfWeek() {
        fetch('/getOrderDataByDayOfWeek')
            .then(response => response.json())
            .then(data => {
                renderChart(data.orderCounts);
            })
            .catch(error => console.error('Error fetching order data by day of week:', error));

        document.getElementById('show-week-btn').classList.add('active');
        document.getElementById('show-year-btn').classList.remove('active');
    }

    function fetchOrdersThisYear() {
        fetch('/getOrdersThisYear')
            .then(response => response.json())
            .then(data => {
                renderMonthlyChart(data.orderCounts);
            })
            .catch(error => console.error('Error fetching orders this year:', error));

        document.getElementById('show-week-btn').classList.remove('active');
        document.getElementById('show-year-btn').classList.add('active');
    }

    function renderChart(orderCounts) {
        const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const data = daysOfWeek.map(day => orderCounts[day] || 0);

        const ctx = document.getElementById('ordersChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: daysOfWeek,
                datasets: [{
                    label: 'Number of Orders',
                    data: data,
                    backgroundColor: '#f4bcbc',
                    borderColor: '#9c7b7b',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    function renderMonthlyChart(orderCounts) {
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        const data = months.map(month => orderCounts[month] || 0);

        const ctx = document.getElementById('ordersChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Number of Orders',
                    data: data,
                    backgroundColor: '#f4bcbc',
                    borderColor: '#9c7b7b',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    fetchOrderDataByDayOfWeek();
</script>

@include('admin.adminscript')
</body>
</html>
