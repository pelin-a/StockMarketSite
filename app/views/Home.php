<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: /app/views/Login.php');
    exit();
}
require_once __DIR__ . '/../src/Stock.php'; 
require_once __DIR__ . '/../src/User.php';
require_once __DIR__ . '/../src/config.php';
$userEmail=$_SESSION['user_email'] ?? 'Guest'; 
// Default to 'Guest' if not logged in
$userInfo=getUserInfo($userEmail);

$apiKey = "043de246c6e34bc8b644bdaa7f669aca"; // Replace with your real API key
$symbols = ['AAPL', 'GOOGL', 'MSFT','TSLA', 'AMZN', 'NFLX']; // Example symbols

$selectedCountry = $_GET['country'] ?? 'United States';
if($selectedCountry==='United States'){
  $stocks= getStocks($symbols, API_KEY, $selectedCountry);
}
else{
$stocks = getStocksByCountry($selectedCountry);
}
$stocksOverview=getStocks($symbols, API_KEY, 'United States');
$currency = $_GET['currency'] ?? 'USD'; 
?>
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
  <div class="navbar-brand">
      <a href="/" class="navbar-logo">
    <img src="/Public/images/LOGO.png" alt="StoX Logo">
  </a>
    </div>
  <ul class="navbar-links">
    <li><a href="Home.php" class="active">Home</a></li>
    <li><a href="Portfolio.php">Portfolio</a></li>
    <li><a href="News.php">News</a></li>
    <li><a href="Account.php">Account</a></li>
    <li><a href="StockDetail.php">Stock Detail</a></li>
    <li><a href="Premium.php">Premium</a></li>
  </ul>
  <div class="navbar-profile">
        <form method="GET" action="" style="display:inline;">
      <select name="currency" id="currencySelect" onchange="this.form.submit()" style="margin-right: 12px;">
        <option value="USD" <?= (($_GET['currency'] ?? 'USD') === 'USD') ? 'selected' : '' ?>>USD ($)</option>
        <option value="EUR" <?= (($_GET['currency'] ?? '') === 'EUR') ? 'selected' : '' ?>>EUR (€)</option>
        <option value="CAD" <?= (($_GET['currency'] ?? '') === 'CAD') ? 'selected' : '' ?>>CAD (C$)</option>
        <option value="JPY" <?= (($_GET['currency'] ?? '') === 'JPY') ? 'selected' : '' ?>>JPY (¥)</option>
        <option value="CNY" <?= (($_GET['currency'] ?? '') === 'CNY') ? 'selected' : '' ?>>CNY (¥)</option>
      </select>
    </form>
    <span><?= $userInfo['username'] ?></span>
    <a class="logout" href="../src/logout.php">Logout</a>
    <button id="themeSwitcher" title="Switch theme" class="theme-switcher-btn">🌞</button>
  </div>
</nav>

<main class="main-content">
<?php $totalValue= 21300;
$dailyChange= 245; 
$symbol = getCurrencySymbol($currency);
if ($currency != 'USD'){
  $totalValue = convertCurrency('USD', $currency, number_format($totalValue, 2));
  $dailyChange = convertCurrency('USD', $currency, number_format($dailyChange, 2));
}?>

<section class="card worldstocks-card center-card">
  <h3>World Stocks</h3>
  <div class="worldstocks-header">
    <form method="GET" action="">
      <label for="countrySelect">Select Country:</label>
      <select name="country" id="countrySelect" onchange="this.form.submit()" >
        <option value="United States" <?= ($selectedCountry === 'United States') ? 'selected' : '' ?>>🇺🇸 USA</option>
        <option value="Germany" <?= ($selectedCountry === 'Germany') ? 'selected' : '' ?>>🇩🇪 Germany</option>
        <option value="Japan" <?= ($selectedCountry === 'Japan') ? 'selected' : '' ?>>🇯🇵 Japan</option>
        <option value="China" <?= ($selectedCountry === 'China') ? 'selected' : '' ?>>🇨🇳 China</option>
        <option value="Canada" <?= ($selectedCountry === 'Canada') ? 'selected' : '' ?>>🇨🇦 Canada</option>
      </select>
    </form>
  </div>
  <div class="worldstocks-list-container">
    <ul class="worldstocks-list" id="worldStocksList">
<?php if (empty($stocks)): ?>
    <li>No stocks found for this country.</li>
<?php else: ?>
    <?php foreach ($stocks as $stock): ?>
        <?php $changeClass = $stock['change_percent'] < 0 ? 'profit-down' : 'profit-up'; 
        if ($currency != 'USD') {
            $price = convertCurrency('USD', $currency, number_format($stock['price'], 2)); // Assuming you have a function to convert currency
        } else {
            $price = number_format($stock['price'], 2);
        } ?>
        
        <li>
            <span><?= htmlspecialchars($stock['symbol']) ?></span>
            <span style="margin-left: auto; display: flex; align-items: center; gap: 10px;">
                <span><?= $symbol . $price ?></span>
                <b class="<?= $changeClass ?>">
                    <?= $stock['change_percent'] >= 0 ? '+' : '' ?><?= number_format($stock['change_percent'], 2) ?>%
                </b>
            </span>
        </li>
    <?php endforeach; ?>
<?php endif; ?>
</ul>
  </div>
</section>

  <!-- Üstte üç kart yan yana -->
  <div class="top-row">
    <!-- Portfolio Summary -->
    <section class="card portfolio-card">
      <h3>Portfolio Summary</h3>
      <div class="portfolio-summary">
        <div class="total-value">
          <span>Total Value</span>
          <strong><?= $symbol.$totalValue ?></strong>
        </div>
        <div class="profit">
          <span>Daily Change</span>
          <strong class="profit-up"><?= $symbol . $dailyChange?></strong>
        </div>
      </div>
      <div class="portfolio-extra">
        <span>Portfolio Return: <b>+12.4%</b></span>
        <span>|</span>
        <span>Stocks: <b>4</b></span>
        <span>|</span>
        <span>Best: <b>Apple (+4.2%)</b></span>
      </div>
    </section>

    <!-- Market Overview -->
<section class="card market-card">
  <h3>Market Overview</h3>

  <ul class="market-list">
    <?php foreach ($stocksOverview as $item): ?>
      <?php
        $changeClass = strpos($item['change_percent'], '-') === 0 ? 'profit-down' : 'profit-up';
        if ($currency != 'USD') {
            $price = convertCurrency('USD', $currency, number_format($item['price'], 2)); // Assuming you have a function to convert currency
        } else {
            $price = number_format($item['price'], 2);
        }
      ?>
<li>
  <span><?php echo htmlspecialchars($item['symbol']); ?></span>
  <span style="margin-left: auto; display: flex; align-items: center; gap: 16px;">
<span><?= $symbol . $price; ?></span>
    <b class="<?php echo $changeClass; ?>">
      <?php echo $item['change_percent'] >= 0 ? '+' : ''; ?><?php echo number_format($item['change_percent'], 2); ?>%
    </b>
  </span>
</li>
    <?php endforeach; ?>
  </ul>
</section>


    <!-- Favorite Stocks -->
    <section class="card favs-card">
      <h3>Favorite Stocks</h3>
      <?php
      // Example favorites; replace with user-specific favorites if needed
      $favorites = ['AAPL', 'TSLA', 'BMW.DE', 'BAS.DE'];
      $favoriteStocks = getFavStocks();
      ?>
      <ul class="favorites">
      <?php if (count($favoriteStocks) === 0): ?>
          <li>No favorite stocks found in the current market.</li>
      <?php else: ?>
          <?php foreach ($favoriteStocks as $stock): ?>
              <?php $changeClass = $stock['change_percent'] < 0 ? 'profit-down' : 'profit-up'; 
              if ($currency != 'USD') {
            $price = convertCurrency('USD', $currency, number_format($stock['price'], 2)); // Assuming you have a function to convert currency
        }  else{
          $price = number_format($stock['price'], 2);
        }?>
        <li>
            <span><?= htmlspecialchars($stock['symbol']) ?></span>
            <span style="margin-left: auto; display: flex; align-items: center; gap: 10px;">
                <span> <?=  $symbol. $price ?></span>
                <b class="<?= $changeClass ?>">
                    <?= $stock['change_percent'] >= 0 ? '+' : '' ?><?= number_format($stock['change_percent'], 2) ?>%
                </b>
            </span>
        </li>
          <?php endforeach; ?>
      <?php endif; ?>
      </ul>
    </section>
  </div>





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
<footer class="site-footer">
  <div class="footer-content">
    <span>&copy; <?= date('Y') ?> StoX.com. All rights reserved.</span>
    <span> | </span>
    <a href="mailto:support@stox.com">Contact Support</a>
  </div>
</footer>
</html>