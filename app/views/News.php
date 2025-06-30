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
    <!-- Haber Kartı -->
    <article class="news-card-long">
      <div class="news-content">
        <h3><a href="#">BIST100 hits record: Which stocks stood out?</a></h3>
        <div class="news-meta">Stock Market • 30 Jun 2025</div>
        <p>BIST100 reached an all-time high today, driven by gains in banking and technology stocks. Experts believe the uptrend may continue as investor confidence grows...</p>
      </div>
    </article>

    <article class="news-card-long">
      <div class="news-content">
        <h3><a href="#">Central Bank announced rate decision, markets respond</a></h3>
        <div class="news-meta">Economy • 30 Jun 2025</div>
        <p>The Central Bank kept the interest rate unchanged, prompting mixed reactions in the markets. Analysts expect volatility in the coming weeks as economic data is released...</p>
      </div>
    </article>

    <article class="news-card-long">
      <div class="news-content">
        <h3><a href="#">Latest on Dollar and Gold: What do analysts say?</a></h3>
        <div class="news-meta">Markets • 29 Jun 2025</div>
        <p>Dollar and gold prices fluctuated as investors assessed global economic developments. Market participants are watching for signals from the upcoming policy meetings...</p>
      </div>
    </article>

    <!-- İstersen daha fazla haber ekleyebilirsin -->
  </div>

</main>

<script src="/Public/js/main.js"></script>
</body>
</html>