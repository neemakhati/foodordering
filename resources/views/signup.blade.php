<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <style>
        .container {
            width: 400px;
            margin: 150px auto; /* Centering the container vertically */
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

        input[type="text"],
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

        .signin-link {
            text-align: center;
        }

        .signin-link a {
            color: #fb5849;
            text-decoration: none;
        }

        .signin-link a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
<div class="container">
    <h2>Sign Up</h2>
    <form action="/signup" method="post">
        @csrf
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Sign Up</button>
    </form>
    <div class="signin-link">
        <p>Already have an account? <a href="/signin">Login</a></p>
    </div>
</div>
</body>
</html>
