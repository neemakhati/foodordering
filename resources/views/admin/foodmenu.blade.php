<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
        <button type="button" class="add-food-button-container" id="foodModalBtn" data-toggle="modal" data-target="#foodModal">
            <i class="fas fa-plus"></i>
        </button>
        <div class="modal fade" id="foodModal" tabindex="-1" role="dialog" aria-labelledby="foodModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="foodModalLabel">Add New Food Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="food_form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="food_id" name="food_id">
                            <label for="title">Title:</label><br>
                            <input type="text" id="title" name="title" required><br>
                            <label for="price">Price:</label><br>
                            <input type="number" id="price" name="price" min="0" step="1" required><br>
                            <label for="image">Image:</label><br>
                            <input type="file" id="image" name="image" onchange="displayImage(this)"><br>
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
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="food_form_btn">Save</button>
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
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this food item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
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
                    console.log("Fetched food items:", response.food);
                    $('tbody').html("");
                    $.each(response.food, function (key, item) {
                        appendFoodItemToTable(item);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching food items:", error);
                }
            });
        }

        $(document).on('click', '.add-food-button-container', function () {
            $('#food_form')[0].reset();
            $('#food_id').val('');
            $('#imagePreview').hide();
            $('#foodModalLabel').text('Add New Food Item');
            $('#food_form_btn').text('Save');
            $('#foodModalBtn').attr('data-mode', 'add');
            $('#foodModal').modal('show');
        });

        $(document).on('click', 'a[href^="/updateview/"]', function (e) {
            e.preventDefault();
            var foodId = $(this).attr('href').split('/').pop();

            $.ajax({
                type: 'GET',
                url: '/fetch-food-item/' + foodId,
                success: function (response) {
                    var item = response.food;
                    $('#food_id').val(item.id);
                    $('#title').val(item.title);
                    $('#price').val(item.price);
                    $('#description').val(item.description);
                    $('#imagePreview').attr('src', '/foodimage/' + item.image).show();
                    $('#categories_id').val(item.categories_id);
                    $('#foodModalLabel').text('Update Food Item');
                    $('#food_form_btn').text('Save Changes');
                    $('#foodModalBtn').attr('data-mode', 'update');
                    $('#foodModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching food item:", error);
                    alert('Error fetching food item: ' + error);
                }
            });
        });

        $(document).on('submit', '#food_form', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            var foodId = $('#food_id').val();
            var url = foodId ? '/updatefood/' + foodId : '/uploadfood';
            var method = foodId ? 'POST' : 'POST';

            $.ajax({
                type: method,
                url: url,
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status == 'success') {
                        if (foodId) {
                            updateFoodItemInTable(response.item);
                        } else {
                            appendFoodItemToTable(response.item);
                        }
                        $('#foodModal').modal('hide');
                        $('#food_form')[0].reset();
                        $('#imagePreview').hide();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error adding/updating food item:", error);
                    alert('Error: ' + error);
                }
            });
        });

        function appendFoodItemToTable(item) {
            var categoryName = '';
            if (item.cat && item.cat.name) {
                categoryName = item.cat.name;
            }
            $('tbody').prepend('<tr data-food-id="' + item.id + '">\
            <td>' + item.title + '</td>\
            <td>' + item.price + '</td>\
            <td>' + item.description + '</td>\
            <td>' + categoryName + '</td>\
            <td><img src="/foodimage/' + item.image + '" width="100" height="100"></td>\
            <td><a href="#" class="delete-food" data-food-id="' + item.id + '" style="color: white; padding: 10px;"><i class="fas fa-trash-alt"></i></a></td>\
            <td><a href="/updateview/' + item.id + '" style="color: white; padding: 10px;"><i class="fas fa-edit"></i></a></td>\
        </tr>');
        }

        function updateFoodItemInTable(item) {
            var categoryName = '';
            if (item.cat && item.cat.name) {
                categoryName = item.cat.name;
            }
            var row = $('tr[data-food-id="' + item.id + '"]');
            row.find('td').eq(0).text(item.title);
            row.find('td').eq(1).text(item.price);
            row.find('td').eq(2).text(item.description);
            row.find('td').eq(3).text(categoryName);
            row.find('img').attr('src', '/foodimage/' + item.image);
        }

        $(document).on('click', '.delete-food', function (e) {
            e.preventDefault();
            var foodId = $(this).data('food-id');
            $('#confirmDeleteBtn').data('food-id', foodId);
            $('#deleteModal').modal('show');
        });

        $(document).on('click', '#confirmDeleteBtn', function (e) {
            e.preventDefault();
            var foodId = $(this).data('food-id');
            $.ajax({
                type: 'DELETE',
                url: '/deletefood/' + foodId,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#deleteModal').modal('hide');
                    $('tr[data-food-id="' + foodId + '"]').remove();
                },
                error: function (xhr, status, error) {
                    console.error("Error deleting food item:", error);
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
    function displayUpdateImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#update_imagePreview').attr('src', e.target.result).show();
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


