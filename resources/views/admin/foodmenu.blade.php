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
            margin: 20px;
        }
        .pagination li {
            margin: 10px 5px;
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
        <button type="button" class="add-food-button-container" data-toggle="modal" data-target="#exampleModal">
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
                        <form id="food_form" enctype="multipart/form-data">
                            @csrf
                            <label for="title">Title:</label><br>
                            <input type="text" id="title" name="title" required><br>
                            <label for="price">Price:</label><br>
                            <input type="number" id="price" name="price" min="0" step="1" required><br>


                            <label for="image">Image:</label><br>
                            <input type="file" id="image" name="image" onchange="displayImage(this)" required><br>
                            <img id="imagePreview" src="#" alt="Selected Image"><br>
                            <select class="custom-select" id="categories_id" name="categories_id">
                                <option selected>Category</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select><br>
                            <label for="description">Description:</label><br>
                            <textarea id="description" name="description" rows="2" cols="20" required></textarea><br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary ms-auto add-food-submit" id="food_form_btn">
                                    Save
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close_modal_btn">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table>
            <thead>
            <tr>
                {{--                <th>Ssn.</th>--}}
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
            @foreach($food as $index=> $item)
                <tr align="center">
                    {{--                    <td>{{ $index + 1 + ($food->currentPage() - 1) * $food->perPage() }}</td>--}}
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
    $(document).ready(function () {


        fetchFoodItems();

        function fetchFoodItems() {
            $.ajax({
                type: "GET",
                url: "/fetch-food-items",
                dataType: "json",
                success: function (response) {
                    console.log("Fetched food items:", response.food); // Debugging
                    $('tbody').html("");
                    $.each(response.food, function (key, item) {
                        appendFoodItemToTable(item);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching food items:", error); // Debugging
                }
            });
        }

        $('#exampleModal').on('hidden.bs.modal', function () {
            $('#success_message').removeClass('alert alert-success').text('');
        });

        $(document).on('click', '#close_modal_btn', function() {
            $('#success_message').removeClass('alert alert-success').text('');
        });
        $(document).on('click', '.add-food-submit', function (e) {
            e.preventDefault();

            $(this).text('Sending..');

            var formData = new FormData($('#food_form')[0]);

            $.ajax({
                type: "POST",
                url: "/uploadfood",
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == 'success') {
                        appendFoodItemToTable(response.item);
                        $('#exampleModal').modal('hide');
                        $('#food_form')[0].reset();
                        $('#imagePreview').hide();
                        $('#success_message').addClass('alert alert-success').text(response.message);
                    } else {
                        $('#save_msgList').html("").addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                    }
                },
                error: function (xhr) {
                    console.error("Error adding food item:", xhr.responseText);
                    alert('Error: ' + xhr.responseJSON.message);
                },
                complete: function () {
                    $('.add-food-submit').text('Save');
                }
            });
        });

        function appendFoodItemToTable(item) {
            console.log("Food item:", item);
            var categoryName = '';
            if (item.cat && item.cat.name) {
                categoryName = item.cat.name;
            }
            console.log("Category name:", categoryName); // Debugging
            $('tbody').prepend('<tr>\
        <td>' + item.title + '</td>\
        <td>' + item.price + '</td>\
        <td>' + item.description + '</td>\
        <td>' + categoryName + '</td>\
        <td><img src="/foodimage/' + item.image + '" width="100" height="100"></td>\
        <td><a href="/deletefood/' + item.id + '" style="color: white; padding: 10px;"><i class="fas fa-trash-alt"></i></a></td>\
        <td><a href="/updateview/' + item.id + '" style="color: white; padding: 10px;"><i class="fas fa-edit"></i></a></td>\
    </tr>');
        }




    })
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
