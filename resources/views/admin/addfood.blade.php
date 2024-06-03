
<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.admincss')
    <style>
        /* Adjusted positioning for the form and table */
        .form-container, .table-container {
            position: relative;
            top: 80px;
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
    </style>

</head>
<body>
<div class="container-scroller">
    @include('admin.navbar')
<div class="form-container">
    <form action="{{url('/uploadfood')}}" method="post" enctype="multipart/form-data">
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

        <input type="submit" value="Submit">
    </form>
</div></div>
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