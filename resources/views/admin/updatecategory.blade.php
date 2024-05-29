<x-app-layout>

</x-app-layout>
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
                <input style="color: black;" type="text" id="status" name="status" value="{{$data->status}}"required><br><br>
                <input style="color:white;" type="submit" value="Submit"></div>
            </form>
        </div>
    </div>
    @include('admin.adminscript')
  </body>
</html>
