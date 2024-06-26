<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @include('admin.admincss')
    <style>
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
        .form-container, .table-container {
            position: relative;
            top: 120px;
            right: -15px;
        }
        form input[type="text"], form input[type="number"], form select, form textarea {
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
        #imagePreview {
            max-width: 200px;
            max-height: 200px;
            display: none;
        }
        table img {
            left: 100px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .table-container {
            position: relative;
            top: 20px;
            right: -40px;
            height: auto;
        }
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
        <button type="button" class="add-button-container" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i>
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Food Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="food_form" action="/uploadfood" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="title">Title:</label><br>
                            <input type="text" id="title" name="title" required><br>
                            <label for="price">Price:</label><br>
                            <input type="number" id="price" name="price" min="0" step="1" required><br>
                            <label for="image">Image:</label><br>
                            <input type="file" id="image" name="image" onchange="displayImage(this)" required><br>
                            <img id="imagePreview" src="#" alt="Selected Image"><br>
                            <select class="custom-select" id="inputGroupSelect04" name="categories_id">
                                <option selected>Category</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select><br>
                            <label for="description">Description:</label><br>
                            <textarea id="description" name="description" rows="2" cols="20" required></textarea><br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary ms-auto" id="company_form_btn">
                                    Save
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table>
            <thead>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Description</th>
                <th>Category</th>
                <th>Image</th>
                <th>Action</th>
                <th>Change</th>
            </tr>
            </thead>
            <tbody>
            @foreach($food as $item)
                <tr align="center">
                    <td>{{$item->title}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{$item->cat ? $item->cat->name : ''}}</td>
                    <td><img src="/foodimage/{{$item->image}}" width="100" height="100"></td>
                    <td>
                        <a href="{{url('/deletefood', $item->id)}}" style="color: white; padding: 10px;"><i class="fas fa-trash-alt"></i></a>
                    </td>
                    <td>
                        <a href="{{url('/updateview', $item->id)}}" style="color: white; padding: 10px;"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper">
            @if ($food->hasPages())
                <nav>
                    <ul class="pagination">
                        @if ($food->onFirstPage())
                            <li class="disabled" aria-disabled="true">
                                <span>Previous</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $food->previousPageUrl() }}" rel="prev">Previous</a>
                            </li>
                        @endif
                        @if ($food->hasMorePages())
                            <li>
                                <a href="{{ $food->nextPageUrl() }}" rel="next">Next</a>
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

<script>
    $(document).ready(function() {
        $('#food_form').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($(this)[0]);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    var newItem = response.item;
                    console.log("New item added: ", newItem);
                    var newRow = "<tr align='center'>" +
                        "<td>" + newItem.title + "</td>" +
                        "<td>" + newItem.price + "</td>" +
                        "<td>" + newItem.description + "</td>" +
                        "<td>" + newItem.category_name + "</td>" +
                        "<td><img src='/foodimage/" + newItem.image + "' width='100' height='100'></td>" +
                        "<td><a href='/deletefood/" + newItem.id + "' style='color: white; padding: 10px;'><i class='fas fa-trash-alt'></i></a></td>" +
                        "<td><a href='/updateview/" + newItem.id + "' style='color: white; padding: 10px;'><i class='fas fa-edit'></i></a></td>" +
                        "</tr>";
                    $("table tbody").prepend(newRow);
                    $('#exampleModal').modal('hide');

                    $('#food_form')[0].reset();
                    $('#imagePreview').hide();
                },
                error: function(xhr) {
                    console.error("Error adding food item:", xhr.responseText);
                    alert('Error: ' + xhr.responseJSON.message);
                }
            });
        });
    });

    function displayImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>


<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
