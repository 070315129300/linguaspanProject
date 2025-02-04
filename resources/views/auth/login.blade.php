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
            <div class="form-header">
                <div class="toggle-buttons">
                    <button id="loginToggle" class="active">Login</button>
                    <button id="signUpToggle">Sign up</button>
                </div>
            </div>

            <!-- Login Form -->

            <form id="loginForm" class="form active" method="POST" action="{{ route('userlogin') }}">
                @csrf
                <h2>Hola! Welcome</h2>
                <p>Join us to save the voices of mother earth</p>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <span class="show-password" onclick="togglePasswordVisibility()">
            <i class="fa-solid fa-eye" id="passwordIcon"></i>
                </span>
                </div>
                <button type="submit" class="btn">Login</button>
                <p class="forgot-password">Forgot password? <a href="#">Reset here</a></p>
            </form>
            <!-- Sign Up Form -->
            <form id="signUpForm" class="form" method="POST" action="{{ route('register') }}">
                @csrf
                <h2>Lingua Span</h2>
                <h2>Kaabo!</h2>
                <p>Join us to save the voices of mother earth</p>
                <div class="input-group">
                    <input type="" name="email" placeholder="Email Address" >
                </div>
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" >
                </div>
                <div class="input-group">
                    <input type="text" name="age" placeholder="Age bracket" >
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Create Password" >
                </div>
                <button type="submit" id="loginBtn" class="btn">Sign up</button>
                <p class="forgot-password">Already have an account? <a href="#" id="backToLogin">Login here</a></p>
            </form>

        </div>

        <!-- Login Modal -->
        <div class="login-modal" id="loginModal">
            <div class="login-modal-content">
                <span class="close-modal" id="closeModal">&times;</span>
                <h2>Login</h2>
                <h2>A verification link has been <br>sent to your mail</h2>
                <p>kindly select link to verify your account</p>
                <p><i class="fa fa-message"></i></p>
                <button class="btn"> Check Mail</button>
            </div>
        </div>
    </div>
</div>

<script src="js/scripts.js"></script>
</body>
</html>

