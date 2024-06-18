<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.admincss')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.0/dist/echo.iife.min.js"></script>

</head>
<body>
<script>
    Echo.private('my-channel')
        .listen('OrderPlaced', (e) => {
            console.log(e);
        });
</script>
</body>
</html>
