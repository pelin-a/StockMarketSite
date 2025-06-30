<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StoX.com | Login</title>
    <link rel="stylesheet" href="/Public/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <div class="login-bg">
        <div class="login-container">
            <div class="logo-row">
                <span class="brand-title">StoX.com</span>
            </div>
            <h2 class="welcome">Welcome to StoX.com!</h2>
            <p class="info">Track your investments and stay ahead of the market.</p>
            
            <div class="social-buttons">
                <button class="social-btn apple">
                    <img src="/public/images/apple.svg" alt="Apple" class="social-icon">
                    Continue with Apple
                </button>
                <button class="social-btn facebook">
                    <img src="/public/images/facebook.svg" alt="Facebook" class="social-icon">
                    Continue with Facebook
                </button>
                <button class="social-btn google">
                    <img src="/public/images/google.svg" alt="Google" class="social-icon">
                    Continue with Google
                </button>
            </div>
            
            <div class="divider">
                <span>or</span>
            </div>
            
            <form class="main-login-form">
                <label for="login_email" class="visually-hidden">Email or phone number</label>
                <input id="login_email" name="email" type="text" placeholder="Email or phone number" autocomplete="username">
                
                <label for="login_password" class="visually-hidden">Password</label>
                <input id="login_password" name="password" type="password" placeholder="Password" autocomplete="current-password">

                <button type="submit" class="login-btn">Login</button>
            </form>

            <!-- Uyarı/hata mesajı alanı -->
            <div id="login-error" class="error-msg" style="display: none;"></div>

        </div>
    </div>

    <script>
    document.querySelector('.main-login-form').addEventListener('submit', function(e) {
        e.preventDefault();
        window.location.href = 'Home.php'; // Redirect to Home page on successful login
    });
    </script>
</body>
</html>