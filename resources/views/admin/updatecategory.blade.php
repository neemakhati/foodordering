
<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
  @include('admin.admincss')
  </head>
  <body>
    <div class="container-scroller">
        @include('admin.navbar')
        <div style="position:relative; top:60px; right:-150px;">
            <form action="{{url('/updatecat',$data->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="name">Name:</label><br>
                <input style="color: black;" type="text" name="name" value="{{$data->name}}"required><br><br>

                <label for="slug">Slug:</label><br>
                <input style="color: black;" type="text" id="slug" name="slug" value="{{$data->slug}}" required><br><br>

                <label for="status">Status:</label><br>
                <div>
                    <input type="radio" id="status_active" name="status" value="1" {{ $data->status == 1 ? 'checked' : '' }}>
                    <label for="status_active" style="color: white;">Active</label><br>
                    <input type="radio" id="status_inactive" name="status" value="0" {{ $data->status == 0 ? 'checked' : '' }}>
                    <label for="status_inactive" style="color: white;">Inactive</label><br><br>
                </div>
                <input style=" background-color: whitesmoke; padding: 5px; color:black;" type="submit" value="Submit">
            </form>
        </div>
    </div>
    @include('admin.adminscript')
  </body>
</html>
