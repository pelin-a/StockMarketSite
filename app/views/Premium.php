
<?php
session_start();
require_once __DIR__ . '/../src/User.php';
$userEmail = $_SESSION['user_email'] ?? 'Guest';
$userInfo = getUserInfo($userEmail);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>StoX.com | Get Premium</title>
  <link rel="stylesheet" href="/Public/css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<nav class="navbar">
  <div class="navbar-brand">
    <a href="/" class="navbar-logo">
      <img src="/Public/images/LOGO.png" alt="StoX Logo">
    </a>
    StoX.com
  </div>
  <ul class="navbar-links">
    <li><a href="Home.php">Home</a></li>
    <li><a href="Portfolio.php">Portfolio</a></li>
    <li><a href="News.php">News</a></li>
    <li><a href="Account.php">Account</a></li>
    <li><a href="Premium.php" class="active">Premium</a></li>
  </ul>
  <div class="navbar-profile">
    <span><?= htmlspecialchars($userInfo['username'] ?? 'Guest') ?></span>
    <a class="logout" href="../src/logout.php">Logout</a>
    <button id="themeSwitcher" title="Switch theme" class="theme-switcher-btn">🌞</button>
  </div>
</nav>

<main class="main-content">
  <section class="card premium-card center-card">
    <h2>Upgrade to StoX Premium</h2>
    <p class="premium-desc">
      Unlock exclusive features and take your investing to the next level!
    </p>
    <ul class="premium-features">
      <li>✔️ Real-time stock data</li>
      <li>✔️ Advanced analytics & charts</li>
      <li>✔️ Unlimited portfolio tracking</li>
      <li>✔️ Priority customer support</li>
      <li>✔️ Early access to new features</li>
    </ul>
    <div class="premium-price">
      <span class="price-main">€9.99</span>
      <span class="price-period">/month</span>
    </div>
    <form class="premium-form">
      <button type="button" class="premium-btn">Get Premium Now</button>
    </form>
    <p class="premium-note">No credit card required for trial. Cancel anytime.</p>
  </section>
</main>

<footer class="site-footer">
  <div class="footer-content">
    <span>&copy; <?= date('Y') ?> StoX.com. All rights reserved.</span>
    <span> | </span>
    <a href="mailto:support@stox.com">Contact Support</a>
  </div>
</footer>
</body>
</html>