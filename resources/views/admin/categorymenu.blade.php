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
        <div style="position:relative; top:60px; right:-150px;">
            <form action="{{url('/uploadcategory')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="name">Name:</label><br>
                <input style="color: black;" type="text" id="name" name="name" required><br><br>

                <label for="slug">Slug:</label><br>
                <input style="color: black;" type="text" name="slug" required><br><br>

                <label for="status">Status:</label><br>
                <textarea style="color: black;" name="status"required></textarea><br><br>

                <input style="color:white;" type="submit" value="Submit"></div>
            </form>
        </div>
        <div style="position:relative; top:-250px; right:-400px;">
              <table bgcolor="black">
                <tr>
                  <th style="padding: 30px;"> Name</th>
                  <th style="padding: 30px;"> Slug</th>
                  <th style="padding: 30px;"> Status</th>
                  <th style="padding: 30px;"> Action</th>
                  <th style="padding: 30px;"> Change</th>
                </tr>
                @foreach($category as $cat)
                <tr align="center">
                  <td>{{$cat->name}}</td>
                  <td>{{$cat->slug}}</td>
                  <td>
                      @if($cat->status == 1)
        Active
                      @else
        Inactive
                      @endif
                  </td>

                  <td>
                    <a href="{{url('/deletecategory', $cat->id)}}">Delete</a>
                  </td>
                  <td>
                    <a href="{{url('/updatecategory', $cat->id)}}">Update</a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
    </div>
    @include('admin.adminscript')
  </body>
</html>
