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
            padding: 30px;
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
        /* Adjusted positioning for the form and table */
        .form-container, .table-container {
            position: relative;
            top: 120px;
            right: -15px; /* Adjusted right position */
        }
        /* Style for the form elements */
        form input[type="text"],
        form input[type="number"],
        form select,
        form textarea {
            color: black;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form input[type="submit"] {
            background-color: white;
            color: black;
            padding: 5px;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form input[type="submit"]:hover {
            background-color: #f2f2f2;
        }
        /* Style for the image preview */
        #imagePreview {
            max-width: 200px;
            max-height: 200px;
            display: none;
        }
        /* Style for the table image */
        table img {
            left: 100px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        /* Adjusted positioning for the lower table */
        .table-container {
            position: relative;
            top: 20px;
            right: -40px; /* Adjusted right position */
            height: auto; /* Adjusted height */
        }
        /* Style for the add button */
        .add-button-container {
            text-align: right;
            margin-bottom: 20px;
        }
        .add-button-container button {
            background-color: white;
            color: black;
            padding: 10px 20px;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .add-button-container button:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    @include('admin.navbar')

    <div class="table-container">
        <div class="add-button-container">
            <button onclick="window.location.href='{{ url('/addfood') }}'"> <i class="fas fa-plus"></i> </button>
        </div>
        <table>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Category</th>
                <th>Image</th>
                <th>Action</th>
                <th>Change</th>
            </tr>
            @foreach($food as $food)
                <tr align="center">
                    <td>{{$food->title}}</td>
                    <td>{{$food->price}}</td>
                    <td>{{$food->description}}</td>
                    @if($food->cat == '')
                        <td></td>
                    @else
                        <td>{{$food->cat->name}}</td>
                    @endif
                    <td><img src="/foodimage/{{$food->image}}"></td>
                    <td>
                        <a href="{{url('/deletefood', $food->id)}}" style="color: white; padding: 10px;">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{url('/updateview', $food->id)}}" style="color: white; padding: 10px;"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

@include('admin.adminscript')
<script>
    function displayImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>
