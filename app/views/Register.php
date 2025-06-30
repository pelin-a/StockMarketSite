<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basit demo için, gerçek kayıt eklenmedi
    $firstname = $_POST['firstname'] ?? '';
    $lastname  = $_POST['lastname'] ?? '';
    $email     = $_POST['email'] ?? '';
    $password  = $_POST['password'] ?? '';

    // Pelin buraya veritabanini ekleyebilirsin.
    // Şimdilik doğrudan Home.php'ye yönlendiriyorum:
    header('Location: Home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StoX.com | Register</title>
    <link rel="stylesheet" href="/Public/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="login-bg">
        <div class="login-container">
            <div class="logo-row">
                <span class="brand-title">StoX.com</span>
            </div>
            <h2 class="welcome">Create your account</h2>
            <p class="info">Join StoX.com to track your investments easily.</p>
            
            <div class="divider">
                <span>Register with email</span>
            </div>

            <form class="main-login-form" method="POST" action="Register.php">
                <label for="register_firstname" class="visually-hidden">First Name</label>
                <input id="register_firstname" name="firstname" type="text" placeholder="First Name" required>
                
                <label for="register_lastname" class="visually-hidden">Last Name</label>
                <input id="register_lastname" name="lastname" type="text" placeholder="Last Name" required>

                <label for="register_email" class="visually-hidden">Email</label>
                <input id="register_email" name="email" type="email" placeholder="Email" required autocomplete="username">

                <label for="register_password" class="visually-hidden">Password</label>
                <input id="register_password" name="password" type="password" placeholder="Password" required autocomplete="new-password" minlength="6">

                <button type="submit" class="register-btn-big">Register</button>
            </form>

            <p style="margin-top: 20px; text-align: center;">
                Already have an account?
                <a href="Login.php">Login here</a>
            </p>

            <?php if (!empty($error)): ?>
                <div id="register-error" class="error-msg"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>