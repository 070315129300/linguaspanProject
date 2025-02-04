<!DOCTYPE html>
<html lang="en">
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

            <form id="loginForm" class="form active" method="POST" action="{{ route('login') }}">
                @csrf
                <p>Please Fill In Your Email</p>
                <div class="input-group">
                    <input type="" placeholder="Email Address" s>
                </div>
                <button type="submit" id="loginBtn" class="btn">Send</button>
            </form>
        </div>

        <!-- Login Modal -->
        <div class="login-modal" id="loginModal">
            <div class="login-modal-content">
                <span class="close-modal" id="closeModal">&times;</span>
                <h2>Login</h2>
                <h2>A password reset link <br>sent to your mail</h2>
                <p>kindly use the link to reset your password</p>
                <p><i class="fa fa-message"></i></p>
                <button class="btn"> Send</button>
            </div>
        </div>
    </div>
</div>

<script src="js/scripts.js"></script>
</body>
</html>

