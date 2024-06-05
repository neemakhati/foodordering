<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>

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
        .add-button-container {
            text-align: right;
            margin-left: 870px;
            margin-top: 25px;
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
                <form id="food_form" method="post" >
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
                        <input type="submit" value="Save" id="food_form_btn" >

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $("#food_form_btn").click(function(e){
        e.preventDefault();
        let form = $('#food_form')[0];
        let data = new FormData(form);

        $.ajax({
            url: "{{ route('food.store') }}",
            type: "POST",
            data : data,
            dataType:"JSON",
            processData : false,
            contentType:false,

            success: function(response) {
                if (response.errors) {
                    var errorMsg = '';
                    $.each(response.errors, function(field, errors) {
                        $.each(errors, function(index, error) {
                            errorMsg += error + '<br>';
                        });
                    });
                    iziToast.error({
                        message: errorMsg,
                        position: 'topRight'
                    });

                } else {
                    iziToast.success({
                    message: response.success,
                    position: 'topRight'

                });
            }

        },
        error: function(xhr, status, error) {

            iziToast.error({
                message: 'An error occurred: ' + error,
                position: 'topRight'
            });
        }

});

})
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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
