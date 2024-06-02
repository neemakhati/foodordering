
<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.admincss')
    <style>
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
        }
        th {
            background-color: #d5bcbc;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #453636;
        }
        tr:hover{
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
        .user-table-container {
            margin: 100px;
            max-width: 600px;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    @include('admin.navbar')
    <div class="user-table-container">
        <table>
            <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
                <th>Change</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="action-links">
                        <a href="{{url('/deleteuser', $user->id)}}">Delete</a>
                    </td>
                    <td class="action-links">
                        <a href="{{url('/updateuser', $user->id)}}">Update</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('admin.adminscript')
</body>
</html>
