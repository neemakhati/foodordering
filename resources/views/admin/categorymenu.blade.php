
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
        tr:hover:not(:first-child) {
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
        .lower-table-container {
            margin-top: 420px;
            margin-left: -50px;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    @include('admin.navbar')
    @include('notifyorder')
    <div style="position:relative; top:60px; right:-150px;">
        <form action="{{url('/uploadcategory')}}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="name">Name:</label><br>
            <input style="color: black;" type="text" id="name" name="name" required><br><br>

            <label for="status">Status:</label><br><br>

            <!-- Active radio button -->
            <input type="radio" id="active" name="status" value="1" required>
            <label for="active">Active</label><br>

            <!-- Inactive radio button -->
            <input type="radio" id="inactive" name="status" value="0">
            <label for="inactive">Inactive</label><br><br>

            <input style="background-color: whitesmoke; padding: 5px; color:black;" type="submit" value="Submit">
        </form>
    </div>
    <div class="lower-table-container">
        <table>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Action</th>
                <th>Change</th>
            </tr>
            @foreach($category as $cat)
                <tr>
                    <td>{{$cat->name}}</td>
                    <td>{{$cat->slug}}</td>
                    <td>{{$cat->status == 1 ? 'Active' : 'Inactive'}}</td>
                    <td class="action-links">
                        <a href="{{url('/deletecategory', $cat->id)}}"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    <td class="action-links">
                        <a href="{{url('/updatecategory', $cat->id)}}"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@include('admin.adminscript')
</body>
</html>
