<?php

session_start();
if (!isset($_SESSION['user_email'])) {
    header('Location: Login.php');
    exit();
}
require_once __DIR__ . '/../src/User.php';
$userEmail=$_SESSION['user_email'] ?? 'Guest'; 
// Default to 'Guest' if not logged in
$userInfo=getUserInfo($userEmail);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> | Portfolio</title>
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
    <li><a href="Portfolio.php" class="active">Portfolio</a></li>
    <li><a href="News.php">News</a></li>
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

<?php
require_once __DIR__ . '/../src/Stock.php';
$portfolio = $_SESSION['portfolio'] ?? [];
$totalValue = 0;
$todayChange = 0;
$allTimeGain = 0;
$goal = 25000;
$bestPerformer = null;
$worstPerformer = null;
$totalInvested = 0;

foreach ($portfolio as $holding) {
    if (is_string($holding)) {
        $symbol = $holding;
        $quantity = 1;
        $buy_price = 0.0;
    } else {
        $symbol = $holding['symbol'];
        $quantity = isset($holding['quantity']) ? (int)$holding['quantity'] : 1;
        $buy_price = isset($holding['buy_price']) ? (float)$holding['buy_price'] : 0.0;
    }
    $stockInfo = getStockInfo($symbol, API_KEY, $selectedCountry ?? 'United States');
    $current_price = isset($stockInfo['price']) ? (float)$stockInfo['price'] : 0.0;
    $value = $current_price * $quantity;
    $totalValue += $value;

    // Calculate gain/loss
    $gain = $current_price - $buy_price;
    $gain_total = $gain * $quantity;
    $allTimeGain += $gain_total;
    $totalInvested += $buy_price * $quantity;

    // Today's change
    $daily_change = isset($stockInfo['change']) ? (float)$stockInfo['change'] : 0.0;
    $daily_change_total = $daily_change * $quantity;
    $todayChange += $daily_change_total;

    // Daily percent
    $yesterday_price = $current_price - $daily_change;
    $daily_percent_change = ($yesterday_price != 0) ? ($daily_change / $yesterday_price) * 100 : 0;

    if ($bestPerformer === null || $daily_percent_change > $bestPerformer['percent_change']) {
        $bestPerformer = [
            'symbol' => $symbol,
            'percent_change' => $daily_percent_change,
        ];
    }
    if ($worstPerformer === null || $daily_percent_change < $worstPerformer['percent_change']) {
        $worstPerformer = [
            'symbol' => $symbol,
            'percent_change' => $daily_percent_change,
        ];
    }
}
$goalProgress = ($goal > 0) ? ($totalValue / $goal) * 100 : 0;
$allTimeGainPercent = ($totalInvested > 0) ? ($allTimeGain / $totalInvested) * 100 : 0;
$todayChangePercent = (($totalValue - $todayChange) > 0) ? ($todayChange / ($totalValue - $todayChange)) * 100 : 0;
?>
<main class="main-content">

    <!-- Portfolio Overview Cards -->
    <div class="portfolio-overview-row">
      <!-- Today's Change Card -->
      <section class="card overview-card">
        <span class="overview-label">Today's Change</span>
        <?php
          $todayChangeClass = ($todayChange > 0) ? 'profit-up' : (($todayChange < 0) ? 'profit-down' : '');
          $todayChangeSign = ($todayChange > 0) ? '+' : '';
        ?>
        <strong class="overview-value <?= $todayChangeClass ?>">
          <?= $todayChangeSign ?>€<?= number_format($todayChange, 2) ?>
          (<?= $todayChangeSign . number_format($todayChangePercent, 2) ?>%)
        </strong>
      </section>
      <!-- Best Performer Card -->
      <section class="card overview-card">
        <span class="overview-label">Best Performer</span>
        <?php
          if ($bestPerformer !== null) {
            $bpSign = ($bestPerformer['percent_change'] > 0) ? '+' : '';
            $bpClass = ($bestPerformer['percent_change'] > 0) ? 'profit-up' : (($bestPerformer['percent_change'] < 0) ? 'profit-down' : '');
            echo '<strong class="overview-value ' . $bpClass . '">' .
                 htmlspecialchars($bestPerformer['symbol']) . ' ' .
                 $bpSign . number_format($bestPerformer['percent_change'], 2) . '%</strong>';
          } else {
            echo '<strong class="overview-value">-</strong>';
          }
        ?>
      </section>
      <!-- Worst Performer Card -->
      <section class="card overview-card">
        <span class="overview-label">Worst Performer</span>
        <?php
          if ($worstPerformer !== null) {
            $wpSign = ($worstPerformer['percent_change'] > 0) ? '+' : '';
            $wpClass = ($worstPerformer['percent_change'] > 0) ? 'profit-up' : (($worstPerformer['percent_change'] < 0) ? 'profit-down' : '');
            echo '<strong class="overview-value ' . $wpClass . '">' .
                 htmlspecialchars($worstPerformer['symbol']) . ' ' .
                 $wpSign . number_format($worstPerformer['percent_change'], 2) . '%</strong>';
          } else {
            echo '<strong class="overview-value">-</strong>';
          }
        ?>
      </section>
      <!-- Risk Score Card -->
      <section class="card overview-card">
        <span class="overview-label">Risk Score</span>
        <strong class="overview-value">Moderate</strong>
      </section>
    </div>
  
    <!-- Total Value Card (centered & bigger) -->
    <div class="card total-value-card" style="max-width:500px; margin:0 auto 36px auto; text-align:center;">
      <span class="overview-label">Total Value</span>
      <strong class="overview-value" style="font-size:2.3em; margin-bottom:10px; display:block;">
        €<?= number_format($totalValue, 2) ?>
      </strong>
      <div class="total-value-extra" style="color:#bdbdbd; font-size:1.05em; margin-top:12px; display:flex; flex-direction:column; gap:6px;">
        <?php
          $allTimeGainClass = ($allTimeGain > 0) ? 'color:#4caf50;' : (($allTimeGain < 0) ? 'color:#f44336;' : '');
          $allTimeGainSign = ($allTimeGain > 0) ? '+' : '';
        ?>
        <span>All-time change:
          <b style="<?= $allTimeGainClass ?>">
            <?= $allTimeGainSign ?>€<?= number_format($allTimeGain, 2) ?>
            (<?= $allTimeGainSign . number_format($allTimeGainPercent, 2) ?>%)
          </b>
        </span>
        <span>
          Goal: <b>€<?= number_format($goal, 2) ?></b>
          (You’re <?= number_format($goalProgress, 0) ?>% there!)
        </span>
        <!-- <span>Highest value: <b>€22,400</b> / Lowest value: <b>€15,100</b></span> -->
      </div>
    </div>

  <!-- Holdings Table -->
  <section class="card holdings-card">
    <h3>Your Holdings</h3>
    <table class="portfolio-table">
      <thead>
        <tr>
          <th>Symbol</th>
          <th>Name</th>
          <th>Shares</th>
          <th>Buy Price</th>
          <th>Current Price</th>
          <th>Value</th>
          <th>Gain/Loss</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once __DIR__ . '/../src/Stock.php';
        $portfolio = $_SESSION['portfolio'] ?? [];
        if (empty($portfolio)) {
          echo '<tr><td colspan="7" style="text-align:center;">No holdings yet.</td></tr>';
        } else {
          foreach ($portfolio as $holding) {
            // Support both old (string) and new (array) format
            if (is_string($holding)) {
              $symbol = $holding;
              $quantity = 1;
              $buy_price = 0.0;
            } else {
              $symbol = $holding['symbol'];
              $quantity = isset($holding['quantity']) ? (int)$holding['quantity'] : 1;
              $buy_price = isset($holding['buy_price']) ? (float)$holding['buy_price'] : 0.0;
            }
            $stockInfo = getStockInfo($symbol, API_KEY, $selectedCountry ?? 'United States');
            $name = $stockInfo['name'] ?? $symbol;
            $current_price = isset($stockInfo['price']) ? (float)$stockInfo['price'] : 0.0;
            $value = $current_price * $quantity;
            $gain = $current_price - $buy_price;
            $gain_total = $gain * $quantity;
            $is_up = $gain_total >= 0;
            $gain_class = $is_up ? 'profit-up' : 'profit-down';
            $gain_sign = $is_up ? '+' : '';
            // Format numbers
            $buy_price_disp = '€' . number_format($buy_price, 2);
            $current_price_disp = '€' . number_format($current_price, 2);
            $value_disp = '€' . number_format($value, 2);
            $gain_total_disp = $gain_sign . '€' . number_format($gain_total, 2);
            // Updated gain percent display logic
            if ($buy_price > 0) {
                $gain_percent = ($gain / $buy_price) * 100;
                $gain_percent_disp = $gain_sign . number_format($gain_percent, 1) . '%';
            } else {
                $gain_percent_disp = 'N/A';
            }
            echo '<tr>';
            echo "<td>{$symbol}</td>";
            echo "<td>{$name}</td>";
            echo "<td>{$quantity}</td>";
            echo "<td>{$buy_price_disp}</td>";
            echo "<td>{$current_price_disp}</td>";
            echo "<td>{$value_disp}</td>";
            echo "<td><span class=\"{$gain_class}\">{$gain_total_disp} ({$gain_percent_disp})</span></td>";
            echo '</tr>';
          }
        }
        ?>
      </tbody>
    </table>
  </section>


 

</body>

<footer class="site-footer">
  <div class="footer-content">
    <span>&copy; <?= date('Y') ?> StoX.com. All rights reserved.</span>
    <span> | </span>
    <a href="mailto:support@stox.com">Contact Support</a>
  </div>
</footer>

</html>
