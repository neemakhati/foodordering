<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    @include('admin.admincss')
</head>
<body>
    <div class="container-scroller">
        @include('admin.navbar')
        <div style="position:relative; top:60px; right:-150px;">cd
            <form action="{{url('/update',$data->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="title">Title:</label><br>
                <input style="color: black;" type="text" id="title" name="title" value="{{$data->title}}" required><br><br>

                <label for="price">Price:</label><br>
                <input style="color: black;" type="number" id="price" name="price" min="0" step="0.01" value="{{$data->price}}" required><br><br>

                <label for="description">Description:</label><br>
                <input style="color: black;" type="text" id="description" name="description" value="{{$data->description}}" required><br><br>

                <div>
                    <label for="image">Image:</label><br>
                    <input type="file" id="image" name="image" onchange="displayImage(this)">
                    <img id="imagePreview" src="/foodimage/{{$data->image}}" alt="Selected Image" style="max-width: 200px; max-height: 200px;"><br><br>
                </div>

                <input style="color:black;" type="submit" value="Submit">
            </form>
        </div>
    </div>
    @include('admin.adminscript')
    <script>
        function displayImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
