<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header('Location: Login.php');
    exit();
}
require_once __DIR__ . '/../src/User.php';
require_once __DIR__ . '/../src/Stock.php'; 
$userEmail=$_SESSION['user_email'] ?? 'Guest'; 
// Default to 'Guest' if not logged in
$userInfo=getUserInfo($userEmail);

// Country code to name and flag mapping
$countryMap = [
    'US' => ['flag' => '🇺🇸', 'name' => 'United States'],
    'DE' => ['flag' => '🇩🇪', 'name' => 'Germany'],
    'JP' => ['flag' => '🇯🇵', 'name' => 'Japan'],
    'CN' => ['flag' => '🇨🇳', 'name' => 'China'],
    'CA' => ['flag' => '🇨🇦', 'name' => 'Canada']
];

// Define top symbols for each country
$symbolsByCountry = [
    'US' => ['AAPL', 'MSFT', 'GOOGL', 'TSLA', 'AMZN', 'NFLX', 'NVDA', 'META'],
    'DE' => [],
    'JP' => [],
    'CN' => [],
    'CA' => []
];
$selectedCountry = $_GET['country'] ?? 'US';
$countryName = $countryMap[$selectedCountry]['name'] ?? 'USA';
$symbols = $symbolsByCountry[$selectedCountry] ?? $symbolsByCountry['US'];
$stocks = getStocks($symbols, API_KEY, $countryName);

// Fetch stocks for the selected country


// If a symbol is set, fetch detailed stock info for modal display
$stockDetail = null;
if (isset($_GET['symbol'])) {
    $symbol = $_GET['symbol'];
    $stockDetail = getStockInfo($symbol, API_KEY, $countryName);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>| Stock Detail</title>
  <link rel="stylesheet" href="/Public/css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<nav class="navbar">
  <div class="navbar-brand">
      <a href="/" class="navbar-logo">
    <img src="/Public/images/LOGO.png" alt="StoX Logo">
  </a>
    </div>
  <ul class="navbar-links">
    <li><a href="Home.php">Home</a></li>
    <li><a href="Portfolio.php">Portfolio</a></li>
    <li><a href="News.php">News</a></li>
    <li><a href="Account.php">Account</a></li>
    <li><a href="StockDetail.php" class="active">Stock Detail</a></li>
    <li><a href="Premium.php">Premium</a></li>
  </ul>
  <div class="navbar-profile">
    <span><?= htmlspecialchars($userInfo['username']) ?></span>
    <a class="logout" href="../src/logout.php">Logout</a>
    <button id="themeSwitcher" title="Switch theme" class="theme-switcher-btn">🌞</button>
  </div>
</nav>

<main class="main-content">
  <!-- Country/Exchange Select -->
  <section class="card stockdetail-country-card center-card">
    <h3>Browse Stocks by Country</h3>
    <div class="worldstocks-header">
      <label for="countryStockSelect">Select Country:</label>
      <select id="countryStockSelect" onchange="location.href='StockDetail.php?country='+this.value;">
        <?php foreach ($countryMap as $code => $data): ?>
          <option value="<?= htmlspecialchars($code) ?>" <?= $code === $selectedCountry ? 'selected' : '' ?>><?= htmlspecialchars($data['flag'] . ' ' . $data['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </section>

  <!-- Stock List (country filtered) -->
  <section class="card stock-list-detail-card center-card">
    <h3 id="countryNameHeader">Top Stocks — <?= htmlspecialchars($countryName) ?></h3>
    <div id="stocksLoading" class="loading-spinner" style="display:none;"></div>
    <ul class="stock-detail-list" id="stockDetailList">
      <?php
      // Replaced static JS stock list with dynamic PHP loop over $stocks
      if (!empty($stocks)):
          foreach ($stocks as $stock):
              $changeVal = $stock['change'] ?? 0;
              $changePctVal = $stock['change_percent'] ?? 0;
              $changeClass = ($changeVal >= 0) ? "profit-up" : "profit-down";
              $changeDisplay = ($changeVal > 0 ? "+" : "") . $changeVal . " (" . $changePctVal . "%)";
              $currency = $stock['currency'] ?? '';
      ?>
      <li>
        <div class="stock-detail-row" onclick="window.location.href='StockDetail.php?country=<?= urlencode($selectedCountry) ?>&symbol=<?= urlencode($stock['symbol']) ?>'">
          <div class="stock-detail-main">
            <span class="stock-symbol"><?= htmlspecialchars($stock['symbol']) ?></span>
            <span class="stock-name"><?= htmlspecialchars($stock['name']) ?></span>
            <span class="stock-sector"><?= htmlspecialchars($stock['industry'] ?? '') ?></span>
          </div>
          <div class="stock-detail-prices">
            <span class="stock-price"><?= htmlspecialchars($stock['price']) ?> <span class="currency"><?= htmlspecialchars($currency) ?></span></span>
            <span class="stock-change <?= $changeClass ?>"><?= htmlspecialchars($changeDisplay) ?></span>
          </div>
        </div>
      </li>
      <?php
          endforeach;
      else:
      ?>
      <li>No stocks available for selected country.</li>
      <?php endif; ?>
    </ul>
  </section>

  <!-- Stock Detail Drawer/Modal -->
  <?php if ($stockDetail): ?>
  <div class="stock-detail-modal" id="stockDetailModal" style="display:flex;">
    <div class="stock-detail-modal-content card">
      <button class="close-modal" id="closeDetailModal">&times;</button>
      <div id="modalStockContent">
        <!-- Stock details loaded dynamically from PHP $stockDetail -->
        <div class="stock-detail-modal-header">
          <div class="stock-detail-modal-symbol"><?= htmlspecialchars($stockDetail['symbol'] ?? 'N/A') ?> <span class="stock-sector"><?= htmlspecialchars($stockDetail['industry'] ?? 'N/A') ?></span></div>
          <div class="stock-detail-modal-name"><?= htmlspecialchars($stockDetail['name'] ?? 'N/A') ?></div>
        </div>
        <div class="stock-detail-modal-main-info">
          <div class="stock-detail-modal-price"><?= htmlspecialchars($stockDetail['price'] ?? 'N/A') ?> <?= htmlspecialchars($stockDetail['currency'] ?? '') ?> <span class="stock-change"><?= htmlspecialchars(($stockDetail['change'] ?? 'N/A') . ' (' . ($stockDetail['change_percent'] ?? 'N/A') . '%)') ?></span></div>
          <div class="stock-detail-modal-cap">Market Cap: <b><?= htmlspecialchars($stockDetail['market_cap'] ?? 'N/A') ?></b></div>
          <div class="stock-detail-modal-pe">Exchange: <b><?= htmlspecialchars($stockDetail['exchange'] ?? 'N/A') ?></b></div>
          <div class="stock-detail-modal-div">Country: <b><?= htmlspecialchars($stockDetail['country'] ?? 'N/A') ?></b></div>
        </div>
        <div class="stock-detail-modal-meta">
          <span><b>Exchange:</b> <?= htmlspecialchars($stockDetail['exchange'] ?? 'N/A') ?></span> |
          <span><b>Industry:</b> <?= htmlspecialchars($stockDetail['industry'] ?? 'N/A') ?></span> |
          <span><b>Country:</b> <?= htmlspecialchars($stockDetail['country'] ?? 'N/A') ?></span>
        </div>
        <div class="stock-detail-modal-desc"><?= htmlspecialchars($stockDetail['website'] ?? 'N/A') ?></div>
        <div class="stock-detail-modal-actions">
          <a href="<?= htmlspecialchars($stockDetail['website'] ?? '#') ?>" target="_blank" class="website-link">Visit Website</a>
        </div>
        <div class="stock-detail-modal-news">
          <h4>Recent News</h4>
          <ul>
            <?php
            if (!empty($stockDetail['news'])):
                foreach ($stockDetail['news'] as $newsItem):
            ?>
            <li><a href="<?= htmlspecialchars($newsItem['url']) ?>"><?= htmlspecialchars($newsItem['title']) ?></a></li>
            <?php
                endforeach;
            else:
            ?>
            <li>No recent news available.</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</main>

<script>
// Modal open/close UI logic only
const modal = document.getElementById('stockDetailModal');
const closeBtn = document.getElementById('closeDetailModal');
if (closeBtn) {
    closeBtn.onclick = () => { modal.style.display = 'none'; window.history.pushState({}, document.title, "StockDetail.php?country=<?= urlencode($selectedCountry) ?>"); };
}
window.onclick = e => { if(e.target === modal) modal.style.display = 'none'; };
</script>

<style></style>
</style>
</body>
<footer class="site-footer">
  <div class="footer-content">
    <span>&copy; <?= date('Y') ?> StoX.com. All rights reserved.</span>
    <span> | </span>
    <a href="mailto:support@stox.com">Contact Support</a>
  </div>
</footer>
</html>