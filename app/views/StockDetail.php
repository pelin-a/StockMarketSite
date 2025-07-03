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
    <span><?= $userInfo['username'] ?></span>
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
      <select id="countryStockSelect">
        <option value="US">🇺🇸 USA</option>
        <option value="DE">🇩🇪 Germany</option>
        <option value="JP">🇯🇵 Japan</option>
        <option value="CN">🇨🇳 China</option>
        <option value="CA">🇨🇦 Canada</option>
      </select>
    </div>
  </section>

  <!-- Stock List (country filtered) -->
  <section class="card stock-list-detail-card center-card">
    <h3 id="countryNameHeader">Top Stocks — USA</h3>
    <div id="stocksLoading" class="loading-spinner" style="display:none;"></div>
    <ul class="stock-detail-list" id="stockDetailList">
      <!-- Stocks will be loaded here by JS -->
    </ul>
  </section>

  <!-- Stock Detail Drawer/Modal -->
  <div class="stock-detail-modal" id="stockDetailModal" style="display:none;">
    <div class="stock-detail-modal-content card">
      <button class="close-modal" id="closeDetailModal">&times;</button>
      <div id="modalStockContent">
        <!-- Stock details will be loaded here -->
      </div>
    </div>
  </div>
</main>

<script>
/*
  --- Replace the following "stocksData" with Finnhub API fetches in real use ---
  Below is just a static demo!
*/
const stocksData = {
  US: [
    { symbol: "AAPL", name: "Apple Inc.", price: 218.5, change: 1.3, changePct: "+0.7%", marketCap: "2.8T", sector: "Technology", finnhubId: "AAPL" },
    { symbol: "MSFT", name: "Microsoft Corp.", price: 325.8, change: -2.1, changePct: "-0.6%", marketCap: "2.7T", sector: "Technology", finnhubId: "MSFT" }
  ],
  DE: [
    { symbol: "SAP", name: "SAP SE", price: 177.2, change: 1.6, changePct: "+0.9%", marketCap: "207B", sector: "Software", finnhubId: "SAP.DE" }
  ],
  // ... Add JP, CN, CA as needed
};

const modal = document.getElementById('stockDetailModal');
const modalContent = document.getElementById('modalStockContent');
const closeBtn = document.getElementById('closeDetailModal');

function renderStockList(country) {
  const list = document.getElementById('stockDetailList');
  const header = document.getElementById('countryNameHeader');
  list.innerHTML = '';
  header.textContent = `Top Stocks — ${country}`;
  document.getElementById('stocksLoading').style.display = 'block';

  setTimeout(() => {
    document.getElementById('stocksLoading').style.display = 'none';
    (stocksData[country] || []).forEach(stock => {
      const li = document.createElement('li');
      li.innerHTML = `
        <div class="stock-detail-row" onclick="showStockDetail('${country}','${stock.symbol}')">
          <div class="stock-detail-main">
            <span class="stock-symbol">${stock.symbol}</span>
            <span class="stock-name">${stock.name}</span>
            <span class="stock-sector">${stock.sector}</span>
          </div>
          <div class="stock-detail-prices">
            <span class="stock-price">${stock.price} <span class="currency">${country === "US" ? "USD" : country === "DE" ? "EUR" : ""}</span></span>
            <span class="stock-change ${stock.change >= 0 ? "profit-up" : "profit-down"}">${stock.change > 0 ? "+" : ""}${stock.change} (${stock.changePct})</span>
          </div>
        </div>
      `;
      list.appendChild(li);
    });
  }, 600);
}

window.showStockDetail = function(country, symbol) {
  // Normally here you'd fetch details from Finnhub:
  // e.g. fetch(`/api/stock-detail?symbol=${symbol}&country=${country}`)
  // For demo, just fill with example data:
  let data = {};
  if (country === "US" && symbol === "AAPL") {
    data = {
      symbol: "AAPL",
      name: "Apple Inc.",
      sector: "Technology",
      price: "218.5",
      currency: "USD",
      change: "+1.3 (+0.7%)",
      marketCap: "2.8T",
      peRatio: "34.2",
      dividend: "0.50%",
      ceo: "Tim Cook",
      employees: "164,000",
      founded: "1976",
      website: "https://apple.com",
      high52w: "230.0",
      low52w: "170.3",
      headquarters: "Cupertino, CA",
      description: "Apple Inc. designs, manufactures, and markets smartphones, computers, wearables and more.",
      analyst: "Strong Buy",
      news: [
        { title: "Apple introduces new AI features", url: "News.php" },
        { title: "Quarterly earnings beat expectations", url: "News.php" }
      ]
    };
  } else if (country === "DE" && symbol === "SAP") {
    data = {
      symbol: "SAP",
      name: "SAP SE",
      sector: "Software",
      price: "177.2",
      currency: "EUR",
      change: "+1.6 (+0.9%)",
      marketCap: "207B",
      peRatio: "28.7",
      dividend: "1.60%",
      ceo: "Christian Klein",
      employees: "107,415",
      founded: "1972",
      website: "https://sap.com",
      high52w: "182.2",
      low52w: "131.3",
      headquarters: "Walldorf, Germany",
      description: "SAP SE provides enterprise application software and services worldwide.",
      analyst: "Buy",
      news: [
        { title: "SAP to acquire new cloud startup", url: "News.php" }
      ]
    };
  }
  // ... other stocks

  // Build detail HTML
  modalContent.innerHTML = `
    <div class="stock-detail-modal-header">
      <div class="stock-detail-modal-symbol">${data.symbol} <span class="stock-sector">${data.sector}</span></div>
      <div class="stock-detail-modal-name">${data.name}</div>
    </div>
    <div class="stock-detail-modal-main-info">
      <div class="stock-detail-modal-price">${data.price} ${data.currency} <span class="stock-change">${data.change}</span></div>
      <div class="stock-detail-modal-cap">Market Cap: <b>${data.marketCap}</b></div>
      <div class="stock-detail-modal-pe">P/E Ratio: <b>${data.peRatio}</b></div>
      <div class="stock-detail-modal-div">Dividend: <b>${data.dividend}</b></div>
      <div class="stock-detail-modal-hi-lo">52w High/Low: <b>${data.high52w}</b> / <b>${data.low52w}</b></div>
    </div>
    <div class="stock-detail-modal-meta">
      <span><b>CEO:</b> ${data.ceo}</span> |
      <span><b>Employees:</b> ${data.employees}</span> |
      <span><b>Founded:</b> ${data.founded}</span> |
      <span><b>HQ:</b> ${data.headquarters}</span>
    </div>
    <div class="stock-detail-modal-desc">${data.description}</div>
    <div class="stock-detail-modal-actions">
      <a href="${data.website}" target="_blank" class="website-link">Visit Website</a>
      <span class="analyst-badge">Analyst: ${data.analyst}</span>
    </div>
    <div class="stock-detail-modal-news">
      <h4>Recent News</h4>
      <ul>
        ${data.news.map(n => `<li><a href="${n.url}">${n.title}</a></li>`).join("")}
      </ul>
    </div>
  `;
  modal.style.display = 'flex';
};
closeBtn.onclick = () => { modal.style.display = 'none'; };
window.onclick = e => { if(e.target === modal) modal.style.display = 'none'; }

document.getElementById('countryStockSelect').addEventListener('change', function() {
  const country = this.value;
  renderStockList(country);
});
renderStockList('US');
</script>

<!-- Ekstra CSS (Style dosyana ekleyebilirsin) -->
<style>
/* ... Navbar, main-content vs. senin mevcut stilinle uyumlu bırakabilirsin ... */
.stock-list-detail-card { margin-top: 20px;}
.stock-detail-list { list-style: none; padding: 0; margin: 0;}
.stock-detail-list li {
  border-bottom: 1px solid #2225;
  padding: 20px 10px 16px 10px;
  margin-bottom: 10px;
  background: #1c212b;
  border-radius: 12px;
  box-shadow: 0 2px 10px #0001;
  margin-top: 10px;
  cursor: pointer;
  transition: background 0.13s;
}
.stock-detail-list li:hover { background: #242b36; }
.stock-detail-row {
  display: flex;
  justify-content: space-between;
  align-items: baseline;
  gap: 15px;
  margin-bottom: 5px;
}
.stock-detail-main {
  display: flex;
  align-items: center;
  gap: 13px;
  font-size: 1.12em;
}
.stock-symbol { font-weight: bold; color: #4caf50; font-size: 1.17em; margin-right: 7px; letter-spacing: .7px;}
.stock-name { font-weight: 500; color: #f6f9fe;}
.stock-sector { background: #232734; color: #4caf50; border-radius: 8px; font-size: 0.93em; padding: 1px 10px; margin-left: 9px;}
.stock-detail-prices { text-align: right;}
.stock-price { font-weight: bold; font-size: 1.2em;}
.stock-change { display: block; margin-top: 3px; font-size: 1em;}
.profit-up { color: #4caf50; } .profit-down { color: #e53935; }

/* Modal/Drawer */
.stock-detail-modal {
  position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
  background: rgba(24,26,32,0.88);
  display: flex; align-items: center; justify-content: center;
  z-index: 9999;
}
.stock-detail-modal-content {
  min-width: 370px; max-width: 480px;
  background: var(--secondary-bg);
  border-radius: 18px;
  box-shadow: 0 4px 34px #111a;
  padding: 32px 28px 22px 28px;
  position: relative;
  animation: modalin .17s;
}
@keyframes modalin { from { transform: translateY(80px); opacity: 0; } to { transform: none; opacity: 1;} }
.close-modal {
  position: absolute; top: 20px; right: 24px;
  background: none; border: none; font-size: 1.7em; color: #bdbdbd;
  cursor: pointer; transition: color .17s;
}
.close-modal:hover { color: #e53935; }
.stock-detail-modal-header { font-size: 1.3em; font-weight: 700; margin-bottom: 4px; }
.stock-detail-modal-name { font-size: 1.1em; color: #89d0e6; font-weight: 400; }
.stock-detail-modal-main-info { margin: 16px 0 7px 0; font-size: 1.11em; color: #d6f1d6;}
.stock-detail-modal-main-info > div { margin-bottom: 3px; }
.stock-detail-modal-meta { color: #bdbdbd; font-size: .99em; margin-bottom: 11px;}
.stock-detail-modal-desc { margin: 8px 0 15px 0; color: #bbc7e7; }
.stock-detail-modal-actions { display: flex; align-items: center; gap: 18px; margin-bottom: 10px;}
.website-link { color: #5cb3fa; font-size: .97em; }
.analyst-badge { background: #232734; border-radius: 6px; padding: 3px 10px; color: #f3ea99; font-size: .99em;}
.stock-detail-modal-news h4 { margin-bottom: 7px; color: #5cb3fa; }
.stock-detail-modal-news ul { list-style: none; padding: 0; }
.stock-detail-modal-news li { margin-bottom: 6px;}
.stock-detail-modal-news a { color: #4cafef; text-decoration: none;}
.stock-detail-modal-news a:hover { text-decoration: underline;}
@media (max-width:600px){
  .stock-detail-modal-content { min-width: 80vw; max-width: 96vw; padding:18px 8vw;}
}
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