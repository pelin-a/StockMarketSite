<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header('Location: Login.php');
    exit();
}
require_once __DIR__ . '/../src/News.php'; 
require_once __DIR__ . '/../src/User.php';
$userEmail=$_SESSION['user_email'] ?? 'Guest'; 
$userInfo=getUserInfo($userEmail);

$newsList = getFinnhubNews('general', 6);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>StoX.com | News</title>
  <link rel="stylesheet" href="/Public/css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="navbar-brand">
      <a href="/" class="navbar-logo">
    <img src="/Public/images/LOGO.png" alt="StoX Logo">
  </a>
    </div>
  <ul class="navbar-links">
    <li><a href="Home.php">Home</a></li>
    <li><a href="Portfolio.php">Portfolio</a></li>
    <li><a href="News.php" class="active">News</a></li>
    <li><a href="Account.php">Account</a></li>
    <li><a href="StockDetail.php">Stock Detail</a></li>
    <li><a href="Premium.php">Premium</a></li>
  </ul>
  <div class="navbar-profile">
    <span><?= $userInfo['username'] ?></span>
    <a class="logout" href="../src/logout.php">Logout</a>
    <button id="themeSwitcher" title="Switch theme" class="theme-switcher-btn">🌞</button>
  </div>
</nav>

<main class="main-content">

  <h2 class="news-title">All Market News</h2>

<div class="news-list-long">
  <?php foreach ($newsList as $news): ?>
    <article class="news-card-long">
      <?php if (!empty($news['image'])): ?>
        <div class="news-img-wrap">
          <img src="<?= htmlspecialchars($news['image']) ?>" alt="news image" class="news-img">
        </div>
      <?php endif; ?>
      <div class="news-content">
        <h3>
          <a href="<?= htmlspecialchars($news['url']) ?>" target="_blank" rel="noopener">
            <?= htmlspecialchars($news['title']) ?>
          </a>
        </h3>
        <div class="news-meta">
          <?= !empty($news['source']) ? htmlspecialchars($news['source']) . ' • ' : '' ?>
          <?= isset($news['date']) ? htmlspecialchars($news['date']) : '' ?>
        </div>
        <p><?= htmlspecialchars($news['summary']) ?></p>
      </div>
    </article>
  <?php endforeach; ?>
</div>

</main>

<script src="/Public/js/main.js"></script>
</body>
<footer class="site-footer">
  <div class="footer-content">
    <span>&copy; <?= date('Y') ?> StoX.com. All rights reserved.</span>
    <span> | </span>
    <a href="mailto:support@stox.com">Contact Support</a>
  </div>
</footer>
</html>