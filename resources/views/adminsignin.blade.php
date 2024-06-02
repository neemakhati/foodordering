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

    </style>
</head>
<body>

<div>
    <div class="container">
        <h2>Admin Login</h2>
        <form action="/adminlog" method="post">
            @csrf
            <label for="adminemail">Email</label>
            <input type="email" id="adminemail" name="adminemail" required>

            <label for="adminpassword">Password</label>
            <input type="password" id="adminpassword" name="adminpassword" required>

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</div>
</body>
</html>
