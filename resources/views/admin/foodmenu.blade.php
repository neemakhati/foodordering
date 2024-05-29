<x-app-layout>

</x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.admincss')
</head>
<body>
    <div class="container-scroller">
        @include('admin.navbar')
        <div style="position:relative; top:120px; right:-15px;">
            <form action="{{url('/uploadfood')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="title">Title:</label><br>
                <input style="color: black;" type="text" id="title" name="title" required><br><br>

                <label for="price">Price:</label><br>
                <input style="color: black;" type="number" id="price" name="price" min="0" step="1" required><br><br>

                <label for="image">Image:</label><br>
                <input type="file" id="image" name="image" onchange="displayImage(this)" required><br><br>

                <!-- Display selected image -->
                <img id="imagePreview" src="#" alt="Selected Image" style="max-width: 200px; max-height: 200px; display: none;"><br><br>

                <select class="custom-select" id="inputGroupSelect04" name="categories_id" style="color: black;">
                    <option style="color: black;" selected>Category</option>
                    @foreach ($category as $cat)
                        <option style="color: black;" value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select><br>

                <label for="description">Description:</label><br>
                <textarea style="color: black;" id="description" name="description" rows="2" cols="20" required></textarea><br><br>

                <input style="color:white;" type="submit" value="Submit">
            </form>
        </div>

        <div style="position:relative; top:120px; right:-40px; height:2000px">
            <table bgcolor="black">
                <tr>
                    <th style="padding: 30px;"> Title</th>
                    <th style="padding: 30px;"> Price</th>
                    <th style="padding: 30px;"> Description</th>
                    <th style="padding: 30px;"> Category</th>
                    <th style="padding: 30px;"> Image</th>
                    <th style="padding: 30px;"> Action</th>
                    <th style="padding: 30px;"> Change</th>
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
                    <td><img src="/foodimage/{{$food->image}}" style="left:100px;width: 100px; height: 100px; border-radius: 50%;"></td>
                    <td>
                        <a href="{{url('/deletefood', $food->id)}}">Delete</a>
                    </td>
                    <td>
                        <a href="{{url('/updateview', $food->id)}}">Update</a>
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
