<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.admincss')
    <style>
        body {

        }
        table {
            width: 500px;
            border-collapse: collapse;
            margin-left: 100px;
            margin-bottom: 20px;

        }
        th, td {
            padding: 20px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #453636;
        }
        tr:hover{
            background-color: #9c7b7b;
        }
        .button-container {
            text-align: center;
            margin: 20px;
        }
        .button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #555;
        }
        .button.active {
            background-color: #f4bcbc;
            color: #333;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    @include('admin.navbar')
    <div class="container">
        <div class="button-container">
            <button id="show-foods-btn" class="button active">Foods</button>
            <button id="show-users-btn" class="button">Users</button>
        </div>
        <div id="table-container">
            <h1 style="text-align: center; margin-top: 20px;">Top 10 Most Ordered Foods</h1>
            <table class="table">
                <thead>
                <tr>
                    <th style="color: white;">Food Name</th>
                    <th style="color: white;">Orders Count</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($topFoods as $food)
                    <tr>
                        <td>{{ $food->title }}</td>
                        <td>{{ $food->orders_count }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const foodsButton = document.getElementById('show-foods-btn');
    const usersButton = document.getElementById('show-users-btn');
    const tableContainer = document.getElementById('table-container');

    function setActiveButton(button) {
        foodsButton.classList.remove('active');
        usersButton.classList.remove('active');
        button.classList.add('active');
    }

    foodsButton.addEventListener('click', function() {
        setActiveButton(foodsButton);
        fetch('/getTopFoods')
            .then(response => response.json())
            .then(data => {
                let tableHTML = `
                    <h1 style="text-align: center; margin-top: 20px;">Top 10 Most Ordered Foods</h1>
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="color: white;">Food Name</th>
                            <th style="color: white;">Orders Count</th>
                        </tr>
                        </thead>
                        <tbody>`;
                data.topFoods.forEach(food => {
                    tableHTML += `
                        <tr>
                            <td>${food.title}</td>
                            <td>${food.orders_count}</td>
                        </tr>`;
                });
                tableHTML += `
                        </tbody>
                    </table>`;
                tableContainer.innerHTML = tableHTML;
            })
            .catch(error => console.error('Error fetching data:', error));
    });

    usersButton.addEventListener('click', function() {
        setActiveButton(usersButton);
        fetch('/getTopUsers')
            .then(response => response.json())
            .then(data => {
                let tableHTML = `
                    <h1 style="text-align: center; margin-top: 20px;">Top 10 Most Active Users</h1>
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="color: white;">User Name</th>
                            <th style="color: white;">Order Count</th>
                        </tr>
                        </thead>
                        <tbody>`;
                data.topUsers.forEach(user => {
                    tableHTML += `
                        <tr>
                            <td>${user.name}</td>
                            <td>${user.order_count}</td>
                        </tr>`;
                });
                tableHTML += `
                        </tbody>
                    </table>`;
                tableContainer.innerHTML = tableHTML;
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>

@include('admin.adminscript')
</body>
</html>
