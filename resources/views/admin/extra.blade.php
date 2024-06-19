<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @include('admin.admincss')
    <style>
        /* Your existing CSS */
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
        <button type="button" class="btn btn-primary mb-2" id="itemModalBtn" data-toggle="modal" data-target="#foodsModal">
            <i class="fas fa-plus-circle"></i>
        </button>

        <div class="modal fade" id="foodsModal" tabindex="-1" role="dialog" aria-labelledby="foodModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="foodModalLabel">Add New Food Items</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="foods_form" enctype="multipart/form-data">
                            @csrf
                            <div id="food_items_container">
                                <div class="foods-item-form">
                                    <label for="title">Title:</label><br>
                                    <input type="text" name="title[]" required><br>
                                    <label for="price">Price:</label><br>
                                    <input type="number" name="price[]" min="0" step="any" required><br>
                                    <label for="image">Image:</label><br>
                                    <input type="file" name="image[]" onchange="displayImage(this)" required><br>
                                    <img class="imagePreview" src="#" alt="Selected Image" style="display:none;"><br>
                                    <label for="categories_id">Category:</label><br>
                                    <select name="categories_id[]" required>
                                        <option value="">Select Category</option>
                                        @foreach ($category as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select><br>
                                    <label for="description">Description:</label><br>
                                    <textarea name="description[]" rows="2" cols="20" required></textarea><br>
                                </div>
                            </div>
                            <button type="button" id="add_more_food_item">Add More Food Items</button>
                            <button type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>


<script>
    $(document).ready(function() {
        fetchFoodItems(); // Load existing food items on page load

        $('#foods_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);

            $.ajax({
                type: 'POST',
                url: '/uploadfoods',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        fetchFoodItems(); // Reload food items table
                        $('#foodsModal').modal('hide'); // Close the modal
                        $('#foods_form')[0].reset(); // Clear the form
                        $('.imagePreview').hide(); // Hide any image previews
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error adding food items:', error);
                    alert('Error: ' + error);
                }
            });
        });




        $('#add_more_food_item').click(function() {
            var foodItemForm = $('.foods-item-form:first').clone();
            foodItemForm.find('input, select, textarea').val('');
            foodItemForm.find('.imagePreview').hide();
            $('#food_items_container').append(foodItemForm);
        });






    });

