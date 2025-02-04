<!DOCTYPE html>
<html lang="en">
<base href="/">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Sign Up</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="login-container">

    <div class="container-login">
        <div class="form-container">
            <!-- Login Form -->
            <form id="loginForm" class="form active" method="POST" action="{{ route('userlogin') }}">
                @csrf
                <h2>Hi, Admin</h2>
                <p>Join us to save the voices of mother earth</p>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                    <span class="show-password"><i class="fa-solid fa-eye"></i></span>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </div>
</div>

<script src="js/scripts.js"></script>
</body>
</html>

