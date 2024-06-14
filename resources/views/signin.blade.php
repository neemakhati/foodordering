<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fb5849;
            font-size: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="email"],
        input[type="password"],
        button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #fb5849;
            outline: none;
        }

        button {
            background-color: #fb5849;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e14b3b;
        }

        .signup-link {
            text-align: center;
            margin-top: 10px;
        }

        .signup-link a {
            color: #fb5849;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid transparent;
            border-radius: 5px;
            text-align: center;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 15px;
        }

        .forgot-password a {
            color: #fb5849;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 300px;
            text-align: center;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .modal-alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
@if(session('message'))
    <div id="modal" class="modal">
        <div class="modal-content modal-alert-success">
            <span class="close">&times;</span>
            <p>{{ session('message') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div id="modal" class="modal">
        <div class="modal-content modal-alert-danger">
            <span class="close">&times;</span>
            <p>{{ session('error') }}</p>
        </div>
    </div>
@endif

@if (session('status'))
    <div id="modal" class="modal">
        <div class="modal-content modal-alert-success">
            <span class="close">&times;</span>
            <p>{{ session('status') }}</p>
        </div>
    </div>
@endif

<div class="container">
    <h2>Login</h2>
    <form action="/signin" method="post">
        @csrf
        <label for="loginemail">Email</label>
        <input type="email" id="loginemail" name="loginemail" required>

        <label for="loginpassword">Password</label>
        <input type="password" id="loginpassword" name="loginpassword" required>

        <div class="forgot-password">
            <a href="/forgot-password">Forgot Password?</a>
        </div>

        <button type="submit">Login</button>
    </form>
    <div class="signup-link">
        <p>Don't have an account? <a href="/signup">Sign Up</a></p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('modal');
        var span = document.getElementsByClassName('close')[0];

        if (modal) {
            modal.style.display = 'block';
        }

        span.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    });
</script>
</body>
</html>
