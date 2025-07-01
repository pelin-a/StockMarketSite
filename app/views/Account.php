<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header('Location: Login.php');
    exit();
}
require_once __DIR__ . '/../src/User.php'; // Adjust path if needed
$userEmail=$_SESSION['user_email'] ?? 'Guest'; 
// Default to 'Guest' if not logged in
$userInfo=getUserInfo($userEmail);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>StoX.com | Account</title>
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
    <li><a href="Home.php">Home</a></li>
    <li><a href="Portfolio.php">Portfolio</a></li>
    <li><a href="News.php">News</a></li>
    <li><a href="Account.php" class="active">Account</a></li>
    <li><a href="StockDetail.php">Stock Detail</a></li>
  </ul>
  <div class="navbar-profile">
    <span><?= $userInfo['username'] ?></span>
    <a class="logout" href="../src/logout.php">Logout</a>
    <button id="themeSwitcher" title="Switch theme" class="theme-switcher-btn">🌞</button>
  </div>
</nav>

<main class="main-content">

  <!-- Profile Card -->
  <section class="account-card">
    <div class="account-avatar">B</div>
    <div class="account-info">
      <h2><?= $userInfo['username'] ?></h2>
      <h4><?= $userInfo['firstname']. ' ' .$userInfo['lastname'] ?></h4>
      <p class="user-badge">Standard Member</p>
      <p class="user-email"><?= $userInfo['email'] ?></p>
      <p class="member-since">Member since: <?= date('Y-m-d', strtotime($userInfo['created_at'])) ?></p>
    </div>
  </section>

  <!-- Account Stats Row -->
  <div class="account-stats-row">
    <div class="account-stat">
      <span class="stat-label">Last login</span>
      <span class="stat-value"><?= date('Y-m-d', strtotime($userInfo['created_at'])) ?></span>
    </div>
    <div class="account-stat">
      <span class="stat-label">Account Type</span>
      <span class="stat-value">Standard</span>
    </div>
    <div class="account-stat">
      <span class="stat-label">User ID</span>
      <span class="stat-value">#348991</span>
    </div>
  </div>

  <!-- Action Buttons -->

  <!-- Notification Preferences -->
  <section class="account-preferences card">
    <h3>Notification Preferences</h3>
    <label><input type="checkbox" checked> Email Notifications</label>
    <label><input type="checkbox"> SMS Notifications</label>
    <label><input type="checkbox" checked> App Alerts</label>
  </section>

  <section class="delete-account-section">
    <button class="action-btn danger">Delete Account</button>
  </section>
</main>

<!-- Ekstra stiller aşağıda, istersen CSS dosyana taşı -->
<style>
.account-card {
  display: flex;
  align-items: center;
  gap: 32px;
  background: var(--secondary-bg);
  border-radius: var(--card-radius);
  padding: 30px 34px;
  margin-bottom: 30px;
  box-shadow: 0 2px 22px 0 #0002;
}
.account-avatar {
  width: 82px;
  height: 82px;
  border-radius: 50%;
  background: linear-gradient(135deg, #222f52 65%, #7ad1ec 100%);
  color: #fff;
  font-size: 2.9em;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  box-shadow: 0 2px 18px #3af8f622;
  letter-spacing: 2px;
}
.account-info h2 { margin: 0 0 6px 0; font-size: 2em;}
.user-badge {
  display: inline-block;
  background: #34b0e9;
  color: #fff;
  border-radius: 8px;
  padding: 2px 12px;
  font-size: .99em;
  margin-bottom: 10px;
}
.user-email, .member-since {
  color: #adb8cc;
  font-size: 1.04em;
  margin: 2px 0;
}
.account-stats-row {
  display: flex;
  gap: 26px;
  justify-content: flex-start;
  margin-bottom: 26px;
}
.account-stat {
  background: var(--secondary-bg);
  border-radius: 11px;
  padding: 17px 30px;
  min-width: 150px;
  text-align: center;
  box-shadow: 0 2px 10px 0 #2221;
}
.stat-label { color: #b0b8d1; font-size: 1em; display:block; margin-bottom: 6px;}
.stat-value { font-weight: 600; font-size: 1.14em; letter-spacing: .7px; color: #fff; }
.account-actions {
  display: flex;
  gap: 22px;
  margin-bottom: 28px;
}
.action-btn {
  padding: 12px 32px;
  border-radius: 9px;
  border: none;
  font-weight: 600;
  font-size: 1.08em;
  cursor: pointer;
  background: var(--accent);
  color: #fff;
  transition: background 0.19s, box-shadow 0.2s;
  box-shadow: 0 1px 10px #2223;
}
.action-btn:hover { background: #23843e; }
.action-btn.danger { background: #e53935; }
.action-btn.danger:hover { background: #b11612; }
.account-preferences, .account-theme {
  margin-bottom: 22px;
  padding: 24px 28px;
  background: var(--secondary-bg);
  border-radius: var(--card-radius);
  box-shadow: 0 1px 10px #2221;
}
.account-preferences label, .account-theme label {
  display: block;
  font-size: 1.09em;
  margin: 7px 0;
  color: #e1e6f6;
}
.account-preferences h3 { margin-bottom: 10px;}
</style>

<script>
  // Tema değiştirici (navbar'daki ile aynı çalışıyor)
  const themeBtn = document.getElementById("themeSwitcher");
  const body = document.body;
  function setTheme() {
    if(body.classList.contains("light-mode")) {
      localStorage.setItem("theme", "light");
      if(themeBtn) themeBtn.textContent = "🌙";
    } else {
      localStorage.setItem("theme", "dark");
      if(themeBtn) themeBtn.textContent = "🌞";
    }
  }
  if(themeBtn) themeBtn.addEventListener("click", function(){
    body.classList.toggle("light-mode");
    setTheme();
  });
  // Sayfa açılışında önceki tema yükle
  window.addEventListener("DOMContentLoaded", () => {
    if(localStorage.getItem("theme") === "light") {
      body.classList.add("light-mode");
      setTheme();
    }
  });
</script>

</body>
<footer class="site-footer">
  <div class="footer-content">
    <span>&copy; <?= date('Y') ?> StoX.com. All rights reserved.</span>
    <span> | </span>
    <a href="mailto:support@stox.com">Contact Support</a>
  </div>
</footer>
</html>
