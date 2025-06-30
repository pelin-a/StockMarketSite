<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>StoX.com | Home</title>
  <link rel="stylesheet" href="/Public/css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="navbar-brand">StoX.com</div>
  <ul class="navbar-links">
    <li><a href="Home.php" class="active">Home</a></li>
    <li><a href="Portfolio.php">Portfolio</a></li>
    <li><a href="News.php">News</a></li>
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

  <!-- Üstte üç kart yan yana -->
  <div class="top-row">
    <!-- Portfolio Summary -->
    <section class="card portfolio-card">
      <h3>Portfolio Summary</h3>
      <div class="portfolio-summary">
        <div class="total-value">
          <span>Total Value</span>
          <strong>€21,300</strong>
        </div>
        <div class="profit">
          <span>Daily Change</span>
          <strong class="profit-up">+€245</strong>
        </div>
      </div>
      <div class="portfolio-extra">
        <span>Portfolio Return: <b>+12.4%</b></span>
        <span>|</span>
        <span>Stocks: <b>8</b></span>
        <span>|</span>
        <span>Best: <b>Apple (+4.2%)</b></span>
      </div>
    </section>

    <!-- Market Overview -->
    <section class="card market-card">
      <h3>Market Overview</h3>
      <ul class="market-list">
        <li>BIST100 <span>9,400</span> <b class="profit-up">+1.2%</b></li>
        <li>EUR/USD <span>1.07</span> <b class="profit-down">-0.3%</b></li>
        <li>GOLD <span>2,468</span> <b class="profit-up">+0.7%</b></li>
        <li>NASDAQ <span>17,560</span> <b class="profit-up">+0.4%</b></li>
      </ul>
    </section>

    <!-- Favorite Stocks -->
    <section class="card favs-card">
      <h3>Favorite Stocks</h3>
      <ul class="favorites">
        <li>Apple <span>€218.50</span> <b class="profit-up">+1.3%</b></li>
        <li>Deutsche Bank <span>€10.20</span> <b class="profit-down">-0.7%</b></li>
        <li>Tesla <span>€215.80</span> <b class="profit-up">+0.9%</b></li>
        <li>Bayer <span>€29.70</span> <b class="profit-down">-1.2%</b></li>
      </ul>
    </section>
  </div>

  <!-- HEMEN ALTINDA World Stocks -->
  <section class="card worldstocks-card center-card">
    <h3>World Stocks</h3>
    <div class="worldstocks-header">
      <label for="countrySelect">Select Country:</label>
      <select id="countrySelect">
        <option value="usa">🇺🇸 USA</option>
        <option value="germany">🇩🇪 Germany</option>
        <option value="japan">🇯🇵 Japan</option>
        <option value="china">🇨🇳 China</option>
        <option value="canada">🇨🇦 Canada</option>
      </select>
    </div>
    <div class="worldstocks-list-container">
      <div id="worldStocksLoading" class="loading-spinner" style="display: none;"></div>
      <ul class="worldstocks-list" id="worldStocksList">
        <!-- World stocks content will be loaded here by JS -->
      </ul>
    </div>
  </section>

  <!-- En altta News bölümü -->
  <section class="card news-card">
    <h3>Latest News</h3>
    <ul class="news-list">
      <li><a href="News.php">BIST100 hits record: Which stocks stood out?</a></li>
      <li><a href="News.php">Central Bank announced rate decision, markets respond</a></li>
      <li><a href="News.php">Latest on Dollar and Gold: What do analysts say?</a></li>
    </ul>
  </section>
</main>

<script src="/Public/js/main.js"></script>
</body>
</html>