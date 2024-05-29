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
        <div style="margin:100px; max-width: 600px;">
    <table style="border-collapse: collapse; width: 100%; border: 1px solid #ddd; background-color: #333; color: #fff; text-align: center;">
        <thead>
            <tr>
                <th style="padding: 8px; background-color: #222; border-bottom: 1px solid #ddd;">User ID</th>
                <th style="padding: 8px; background-color: #222; border-bottom: 1px solid #ddd;">Username</th>
                <th style="padding: 8px; background-color: #222; border-bottom: 1px solid #ddd;">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $user)
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $index + 1 }}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $user->name }}</td>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $user->email }}</td>
                </tr>
             @endforeach
        </tbody>
    </table>



    </div>
    @include('admin.adminscript')
  </body>
</html>
