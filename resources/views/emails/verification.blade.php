<!DOCTYPE html>
<html>
    <head>
        <title>Email Verification</title>
    </head>
    <body>

        <h1>Hi, {{ $user->name }}</h1>
        <p>Thank you for registering. Please click the link below to verify your email address.</p>
        <a href="{{ url('/verify', $user->verification_token) }}">Verify Email</a>
        <p>This link is valid only for 24 hours. </p>
    </body>
</html>
