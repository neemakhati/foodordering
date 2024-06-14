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
            background-color: #f2f2f2;
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
            margin-bottom: 20px;
            text-align: center;
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
            margin-top: -15px;
            margin-bottom: 15px;
            font-size: 14px;
            display: none;
        }
    </style>
</head>
<body>

<form id="resetPasswordForm" method="POST" action="{{ route('password.update') }}">
    @csrf
    <h2>Reset Password</h2>
    <input type="hidden" name="token" value="{{ $token }}">

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
    <div id="emailError" class="alert"></div>
    @error('email')
    <span class="alert" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required autocomplete="new-password">
    <div id="passwordError" class="alert"></div>
    @error('password')
    <span class="alert" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
    <div id="confirmPasswordError" class="alert"></div>

    <button type="submit">Reset Password</button>
</form>

<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
        let valid = true;

        const email = document.getElementById('email').value;
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            document.getElementById('emailError').textContent = 'Please enter a valid email address.';
            document.getElementById('emailError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('emailError').style.display = 'none';
        }

        const password = document.getElementById('password').value;
        if (password.length < 6) {
            document.getElementById('passwordError').textContent = 'Password must be at least 6 characters long.';
            document.getElementById('passwordError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('passwordError').style.display = 'none';
        }

        const confirmPassword = document.getElementById('password-confirm').value;
        if (password !== confirmPassword) {
            document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
            document.getElementById('confirmPasswordError').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('confirmPasswordError').style.display = 'none';
        }
        if (!valid) {
            event.preventDefault();
        }
    });
</script>
</body>
</html>
