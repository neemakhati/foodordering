<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
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

        input[type="text"],
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

        input[type="text"]:focus,
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

        .signin-link {
            text-align: center;
            margin-top: 10px;
        }

        .signin-link a {
            color: #fb5849;
            text-decoration: none;
        }

        .signin-link a:hover {
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

        .error-message {
            color: #d9534f;
            font-size: 14px;
            display: none;
        }
    </style>
</head>
<body>
@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div class="container">
    <h2>Sign Up</h2>
    <form id="signupForm" action="/signup" method="post">
        @csrf
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
        <div id="nameError" class="error-message">Name is required and must be at least 3 characters.</div>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        <div id="emailError" class="error-message">Please enter a valid email address.</div>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <div id="passwordError" class="error-message">Password must be at least 6 characters long.</div>

        <button type="submit">Sign Up</button>
    </form>
    <div class="signin-link">
        <p>Already have an account? <a href="/signin">Login</a></p>
    </div>
</div>

<script>
    document.getElementById('signupForm').addEventListener('submit', function(event) {
        let valid = true;

        // Name validation
        const name = document.getElementById('name').value;
        if (name.length < 3) {
            document.getElementById('nameError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('nameError').style.display = 'none';
        }

        // Email validation
        const email = document.getElementById('email').value;
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            document.getElementById('emailError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('emailError').style.display = 'none';
        }

        // Password validation
        const password = document.getElementById('password').value;
        if (password.length < 6) {
            document.getElementById('passwordError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('passwordError').style.display = 'none';
        }

        // If any validation fails, prevent form submission
        if (!valid) {
            event.preventDefault();
        }
    });
</script>
</body>
</html>
