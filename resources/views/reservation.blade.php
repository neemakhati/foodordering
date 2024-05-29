<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        @include('homecss')
        
    </head>
    <body>
        @extends('homeheader')
        
        <div style="background-color: white;">
            <form action="{{ route('contact.send') }}" method="post" style=" max-width: 500px; padding:25px; margin:100px 0px 0px 500px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                @csrf
                <h2 style="color: #dc3545; margin-bottom: 20px;">Contact Us</h2>
                <div style="margin-bottom: 15px;">
                    <label for="name" style="display: block; margin-bottom: 5px; color: #333;">Name</label>
                    <input type="text" id="name" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="email" style="display: block; margin-bottom: 5px; color: #333;">Email</label>
                    <input type="email" id="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="subject" style="display: block; margin-bottom: 5px; color: #333;">Subject</label>
                    <input type="text" id="subject" name="subject" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="message" style="display: block; margin-bottom: 5px; color: #333;">Message</label>
                    <textarea id="message" name="message" rows="5" required style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box;"></textarea>
                </div>
                <button type="submit" style="background-color: #dc3545; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">Submit</button>
            </form>
        </div>
    <div style="margin-top: 20px; text-align: center; color: #6c757d;">
        @include('homefooter')
    </div>
        
        @include('homescripts')

  </div>
</html>