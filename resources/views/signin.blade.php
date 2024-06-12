<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        .container {
            width: 400px;
            margin: 0 auto;
            margin-top: 150px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fb5849;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            background-color: #fb5849;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #fb4433;
        }

        /* Style the signup link */
        .signup-link {
            text-align: center;
        }

        .signup-link a {
            color: #fb5849;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
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


<div class="container">
    <h2>Login</h2>
    <form action="/signin" method="post">
        @csrf
        <label for="loginemail">Email</label>
        <input type="email" id="loginemail" name="loginemail" required>

        <label for="loginpassword">Password</label>
        <input type="password" id="loginpassword" name="loginpassword" required>

        <button type="submit">Login</button>

    </form>
    <div class="signup-link">
        <p>Don't have an account? <a href="/signup">Sign Up</a></p>
    </div>
</div>

</body>
</html>
