
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
//$stocks = getStocks($symbols, $apiKey);
$stocks= [
    [
        'symbol' => 'AAPL',
        'price' => 200.08,
        'change_percent' => -0.49,
    ],
    [
        'symbol' => 'MSFT',
        'price' => 330.55,
        'change_percent' => 1.12,
    ],
    [
        'symbol' => 'GOOGL',
        'price' => 2800.35,
        'change_percent' => 0.75,
    ],
];

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
    StoX.com</div>
  <ul class="navbar-links">
    <li><a href="Home.php" class="active">Home</a></li>
    <li><a href="Portfolio.php">Portfolio</a></li>
    <li><a href="News.php">News</a></li>
    <li><a href="Account.php">Account</a></li>
    <li><a href="StockDetail.php">Stock Detail</a></li>
  </ul>
  <div class="navbar-profile">
    <span><?= $userInfo['username'] ?></span>
    <a class="logout" href="../src/logout.php">Logout</a>
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
    <?php foreach ($stocks as $item): ?>
      <?php
        $changeClass = strpos($item['change_percent'], '-') === 0 ? 'profit-down' : 'profit-up';
      ?>
      <li>
        <?php echo htmlspecialchars($item['symbol']); ?>
        <span><?php echo htmlspecialchars($item['price']); ?></span>
        <b class="<?php echo $changeClass; ?>"><?php echo htmlspecialchars($item['change_percent']); ?></b>
      </li>
    <?php endforeach; ?>
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
    <form method="GET" action="">
      <label for="countrySelect">Select Country:</label>
      <select name="country" id="countrySelect" onchange="this.form.submit()" >
        <option value="United States" <?= (($_GET['country'] ?? '') === 'United States') ? 'selected' : '' ?>>🇺🇸 USA</option>
        <option value="Germany" <?= (($_GET['country'] ?? '') === 'Germany') ? 'selected' : '' ?>>🇩🇪 Germany</option>
        <option value="Japan" <?= (($_GET['country'] ?? '') === 'Japan') ? 'selected' : '' ?>>🇯🇵 Japan</option>
        <option value="China" <?= (($_GET['country'] ?? '') === 'China') ? 'selected' : '' ?>>🇨🇳 China</option>
        <option value="Canada" <?= (($_GET['country'] ?? '') === 'Canada') ? 'selected' : '' ?>>🇨🇦 Canada</option>
      </select>
    </form>
  </div>
  <div class="worldstocks-list-container">
    <ul class="worldstocks-list" id="worldStocksList">
      <?php
      if (isset($_GET['country'])) {
          $country = $_GET['country'];
          $stocksData = getStocksByCountry($country);
          if (isset($stocksData['error'])) {
              echo "<li class='text-danger'>Error: " . htmlspecialchars(is_array($stocksData['error']) ? implode(', ', $stocksData['error']) : $stocksData['error']) . "</li>";
          } elseif (empty($stocksData)) {
              echo "<li>No stocks found for this country.</li>";
          } else {
              foreach ($stocksData as $stock) {
                  echo "<li><strong>" . htmlspecialchars($stock['symbol']) . "</strong>: $"
                      . number_format($stock['price'], 2) . " ("
                      . number_format($stock['change_percent'], 2) . "%)</li>";
              }
          }
      } else {
          echo "<li>Please select a country to see stocks.</li>";
      }
      ?>
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
<footer class="site-footer">
  <div class="footer-content">
    <span>&copy; <?= date('Y') ?> StoX.com. All rights reserved.</span>
    <span> | </span>
    <a href="mailto:support@stox.com">Contact Support</a>
  </div>
</footer>
</html>