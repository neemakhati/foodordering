<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    @include('homecss')
    <style>
            body, html {
                height: 100%;
                margin: 0;
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                display: flex;
                flex-direction: column;
            }

            .contain {
                display: flex;
                flex: 1;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .notice-card {
                background-color: #fff;
                color: #333;
                font-size: 1.25em;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                width: 80%;
                max-width: 500px;
                text-align: center;
                transition: all 0.3s ease-in-out;
            }

            .notice-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            }
    </style>

</head>
<body>
@extends('homeheader')

<div class="contain">
    <div class="notice-card"> Validate your email first. </div>
</div>

@include('homefooter')
@include('homescripts')

</body>
</html>
