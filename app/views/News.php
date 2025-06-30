
<?php
require_once '/Users/pelinsualtun/Documents/Stox_Web/app/src/News.php'; 


$newsList = getNews();
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
  <div class="navbar-brand">StoX.com</div>
  <ul class="navbar-links">
    <li><a href="Home.php">Home</a></li>
    <li><a href="Portfolio.php">Portfolio</a></li>
    <li><a href="News.php" class="active">News</a></li>
    <li><a href="Account.php">Account</a></li>
    <li><a href="StockDetail.php">Stock Detail</a></li>
  </ul>
  <div class="navbar-profile">
    <span>👤 User</span>
    <a class="logout" href="Login.php">Logout</a>
    <button id="themeSwitcher" title="Switch theme" class="theme-switcher-btn">🌞</button>
  </div>
</nav>

<main class="main-content">

  <h2 class="news-title">All Market News</h2>

<div class="news-list-long">
  <?php foreach ($newsList as $news): ?>
    <article class="news-card-long">
      <div class="news-content">
        <h3><a href="<?php echo htmlspecialchars($news['url']); ?>"><?php echo htmlspecialchars($news['title']); ?></a></h3>
        <div class="news-meta"><?php echo htmlspecialchars($news['category']); ?> • <?php echo htmlspecialchars($news['date']); ?></div>
        <p><?php echo htmlspecialchars($news['summary']); ?></p>
      </div>
    </article>
  <?php endforeach; ?>
</div>

</main>

<script src="/Public/js/main.js"></script>
</body>
</html>