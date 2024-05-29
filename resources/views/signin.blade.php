<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 350px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
        }
        .container input[type="text"],
        .container input[type="password"],
        .container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 4px;
        }
        .container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .signup-link {
            text-align: center;
        }
    </style>
</head>
<body>

<div>
    <div class="container">
        <h2>Login</h2>
        <form action="/signin" method="post">
            @csrf
            <label for="loginemail">Email</label>
            <input type="email" id="loginemail" name="loginemail" required>

            <label for="loginpassword">Password</label>
            <input type="password" id="loginpassword" name="loginpassword" required>

            <button style="background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 3px; cursor: pointer; text-decoration: none; display: inline-block;">
                Login
            </button>

        </form>
        <div class="signup-link">
            <p>Don't have an account? <a href="/signup">Sign Up</a></p>
        </div>
    </div>

</div>
</body>
</html>
