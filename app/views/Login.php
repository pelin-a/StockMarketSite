
<?php
session_start();
require_once __DIR__ . '/../src/User.php';

$error = '';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Create a temporary user object (constructor requires all 3 values, so pass dummy values for now)
    $tempUser = new User('', '', $email);

    $loginResult = $tempUser->login($email, $password);

    if ($loginResult === true) {
        $_SESSION['user_email'] = $email;
        header('Location: Home.php');
        exit();
    } elseif ($loginResult === 2) {
        $error = 'Incorrect password.';
    } else {
        $error = 'User not found.';
    }
}
?>

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
            
            <form class="main-login-form" method="POST" action="Login.php">
                <label for="login_email" class="visually-hidden">Email or phone number</label>
                <input id="login_email" name="email" type="text" placeholder="Email or phone number" autocomplete="username">
                
                <label for="login_password" class="visually-hidden">Password</label>
                <input id="login_password" name="password" type="password" placeholder="Password" autocomplete="current-password">

                <button type="submit" class="login-btn">Login</button>
            </form>

            <button class="register-btn-big" onclick="window.location.href='Register.php'">Register</button>
            
            <!-- Uyarı/hata mesajı alanı -->
        <?php if (!empty($error)): ?>
            <div id="login-error" class="error-msg"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </div>

    <!-- <script>S
    document.querySelector('.main-login-form').addEventListener('submit', function(e) {
        e.preventDefault();
        window.location.href = 'Home.php'; // Redirect to Home page on successful login
    });
    </script> -->
</body>
</html>