<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <base href="public">
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

<title>Klassy Cafe - Restaurant HTML Template</title>

@include('homecss')
        
        
    </head>
    <body>
        @extends('homeheader')

        <div style="margin:100px">
            @foreach ($food as $data)
            <div style="display: inline-block; margin: 10px; background-image: url('/foodimage/{{ $data->image }}'); background-size: cover; background-position: center; width: 200px; height: 300px; border-radius: 8px; position: relative;">
                <div style="position: absolute; bottom: 0; background-color: rgba(255, 255, 255, 0.8); padding: 10px; border-radius: 0 0 8px 8px;">
                    <h1 style="font-size: 18px; color: #333; margin: 0;">{{ $data->title }}</h1>
                    <p style="font-size: 14px; color: #666; margin: 5px 0;">{{ $data->description }}</p>
                    <div style="background-color: #ff9800; color: #fff; padding: 5px 10px; border-radius: 4px;">Rs. {{ $data->price }}</div>
                </div>
            </div>
            @endforeach
        </div>

        
        @include('homefooter')
        @include('homescripts')

  </body>
</html>