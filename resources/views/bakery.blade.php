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
    <style>
    </style>

    </head>
    <body>
    <div style="min-height: 100vh; display: flex; flex-direction: column;">
        <div style="flex: 1;">
            @extends('homeheader')


            <section class="section">
                <div class="menu-item-carousel">
                    <div class="col-lg-12">
                        <div class="owl-menu-item owl-carousel owl-loaded owl-drag">
                            @foreach ($food as $data)
                                <div class="owl-item" style="height: 500px; width: 200px; margin: 20px 10px; ">
                                    <div class="item" style="height: 500px; width: 200px; margin: 20px 10px; ">
                                        <div class="card card2" style="background-image:url('/foodimage/{{ $data->image }}'); background-repeat: no-repeat; background-position: center; background-size: cover; width: 100%; height: 300px; overflow: hidden; position: relative;">
                                            <button class="price" style="position: absolute; top: 60px; left: 0px; background-color: #fb5849; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; height: auto;">
                                                {{ $data->price }}
                                            </button>
                                            <div class="info" style="margin-top: 75px;">
                                                <h1 class="title">{{ $data->title }}</h1>
                                                <p class="description">{{ $data->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div style="position: relative;text-align: center; margin-top: auto;">
            @include('homefooter')
        </div>
        </div>

        @include('homescripts')

  </body>
</html>
