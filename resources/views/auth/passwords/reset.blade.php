<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            color: #fb5849;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #fb5849;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #e63c2d;
        }

        .alert {
            color: #ff0000;
            margin-top: 10px;
        }
    </style>
</head>
<body>


<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <h2>Reset Password</h2>
    <input type="hidden" name="token" value="{{ $token }}">
    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

    @error('email')
    <span class="alert" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required autocomplete="new-password">

    @error('password')
    <span class="alert" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">

    <button type="submit">Reset Password</button>
</form>
</body>
</html>
