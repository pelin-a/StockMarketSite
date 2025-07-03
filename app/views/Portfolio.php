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

<main class="main-content">

    <!-- Portfolio Overview Cards -->
    <div class="portfolio-overview-row">
      <!-- Today's Change Card -->
      <section class="card overview-card">
        <span class="overview-label">Today's Change</span>
        <strong class="overview-value profit-up">+€150 (+0.7%)</strong>
      </section>
      <!-- Best Performer Card -->
      <section class="card overview-card">
        <span class="overview-label">Best Performer</span>
        <strong class="overview-value">AAPL +21%</strong>
      </section>
      <!-- Worst Performer Card -->
      <section class="card overview-card">
        <span class="overview-label">Worst Performer</span>
        <strong class="overview-value profit-down">BAYN -1.3%</strong>
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
      <strong class="overview-value" style="font-size:2.3em; margin-bottom:10px; display:block;">€21,300</strong>
      <div class="total-value-extra" style="color:#bdbdbd; font-size:1.05em; margin-top:12px; display:flex; flex-direction:column; gap:6px;">
        <span>All-time change: <b style="color:#4caf50;">+€1,400 (+12%)</b></span>
        <span>Goal: <b>€25,000</b> (You’re 85% there!)</span>
        <span>Highest value: <b>€22,400</b> / Lowest value: <b>€15,100</b></span>
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
        <tr>
          <td>AAPL</td>
          <td>Apple</td>
          <td>15</td>
          <td>€180</td>
          <td>€218.5</td>
          <td>€3,277.5</td>
          <td><span class="profit-up">+€577.5 (+21%)</span></td>
        </tr>
        <tr>
          <td>TSLA</td>
          <td>Tesla</td>
          <td>5</td>
          <td>€195</td>
          <td>€215.8</td>
          <td>€1,079</td>
          <td><span class="profit-up">+€104 (+10.7%)</span></td>
        </tr>
        <tr>
          <td>BAYN</td>
          <td>Bayer</td>
          <td>10</td>
          <td>€30.1</td>
          <td>€29.7</td>
          <td>€297</td>
          <td><span class="profit-down">-€4 (-1.3%)</span></td>
        </tr>
        <tr>
          <td>DBK</td>
          <td>Deutsche Bank</td>
          <td>12</td>
          <td>€8.20</td>
          <td>€10.20</td>
          <td>€122.40</td>
          <td><span class="profit-up">+€24 (+24%)</span></td>
        </tr>
        <!-- More rows as needed -->
      </tbody>
    </table>
  </section>

  <!-- Latest Transactions -->
  <!-- <section class="card transactions-card">
    <h3>Latest Transactions</h3>
    <ul class="transactions-list">
      <li><b>Bought</b> 2 x <b>TSLA</b> @ €214.00 — <span class="date">29 Jun 2025</span></li>
      <li><b>Sold</b> 5 x <b>BAYN</b> @ €30.00 — <span class="date">27 Jun 2025</span></li>
      <li><b>Bought</b> 10 x <b>AAPL</b> @ €215.00 — <span class="date">15 Jun 2025</span></li>
    </ul>
  </section> -->

 

</body>

<footer class="site-footer">
  <div class="footer-content">
    <span>&copy; <?= date('Y') ?> StoX.com. All rights reserved.</span>
    <span> | </span>
    <a href="mailto:support@stox.com">Contact Support</a>
  </div>
</footer>

</html>


