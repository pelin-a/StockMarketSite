// =============== THEME SWITCHER ===============
const themeBtn = document.getElementById("themeSwitcher");
const body = document.body;

// Load theme on page load
if(localStorage.getItem("theme") === "light") {
  body.classList.add("light-mode");
  themeBtn.textContent = "🌙";
} else {
  themeBtn.textContent = "🌞";
}
themeBtn.addEventListener("click", function(){
  body.classList.toggle("light-mode");
  if(body.classList.contains("light-mode")) {
    localStorage.setItem("theme", "light");
    themeBtn.textContent = "🌙";
  } else {
    localStorage.setItem("theme", "dark");
    themeBtn.textContent = "🌞";
  }
});

// =============== WORLD STOCKS LOGIC ===============
const worldStocksData = {
  usa: [
    { name: "Apple", price: 218.5, change: 1.3, currency: "USD" },
    { name: "Microsoft", price: 445.2, change: 0.7, currency: "USD" },
    { name: "Amazon", price: 172.1, change: -0.4, currency: "USD" }
  ],
  germany: [
    { name: "Deutsche Bank", price: 10.2, change: -0.7, currency: "EUR" },
    { name: "Bayer", price: 29.7, change: -1.2, currency: "EUR" },
    { name: "Volkswagen", price: 120.9, change: 1.0, currency: "EUR" }
  ],
  japan: [
    { name: "Toyota", price: 3241, change: 2.1, currency: "JPY" },
    { name: "Sony", price: 13210, change: -0.8, currency: "JPY" },
    { name: "Nintendo", price: 7978, change: 0.3, currency: "JPY" }
  ],
  china: [
    { name: "Huawei", price: 12.8, change: 1.8, currency: "CNY" },
    { name: "Alibaba", price: 82.5, change: -0.5, currency: "CNY" },
    { name: "Tencent", price: 360, change: 2.3, currency: "CNY" }
  ],
  canada: [
    { name: "Shopify", price: 91.2, change: 2.7, currency: "CAD" },
    { name: "RBC", price: 125.7, change: -0.2, currency: "CAD" },
    { name: "Enbridge", price: 47.6, change: 0.8, currency: "CAD" }
  ]
};

const worldStocksList = document.getElementById("worldStocksList");
const countrySelect = document.getElementById("countrySelect");
const loadingSpinner = document.getElementById("worldStocksLoading");

function renderStocks(country) {
  loadingSpinner.style.display = "block";
  worldStocksList.style.opacity = 0;

  setTimeout(() => {
    const stocks = worldStocksData[country] || [];
    worldStocksList.innerHTML = stocks.map(stock => `
      <li>
        <span>${stock.name}</span>
        <span>
          ${stock.price} <span class="currency">${stock.currency}</span>
          <b class="${stock.change >= 0 ? "profit-up" : "profit-down"}">
            ${stock.change > 0 ? "+" : ""}${stock.change}%
          </b>
        </span>
      </li>
    `).join("");
    loadingSpinner.style.display = "none";
    worldStocksList.style.opacity = 1;
  }, 700);
}

countrySelect.addEventListener("change", function() {
  renderStocks(this.value);
});

document.addEventListener("DOMContentLoaded", function(){
  renderStocks("usa");
});













modalContent.innerHTML = `
  <div class="stock-detail-modal-header">
    ${data.symbol} <span class="stock-sector">${data.sector}</span>
  </div>
  <div class="stock-detail-modal-name">${data.name}</div>
  <div class="stock-detail-modal-main-info">
    <div class="stock-detail-modal-price">
      ${data.price} ${data.currency} 
      <span class="stock-change ${data.change.startsWith('-') ? 'profit-down' : 'profit-up'}">${data.change}</span>
    </div>
    <span class="stock-detail-modal-cap">Market Cap: <b>${data.marketCap}</b></span>
    <span class="stock-detail-modal-pe">P/E Ratio: <b>${data.peRatio}</b></span>
    <span class="stock-detail-modal-div">Dividend: <b>${data.dividend}</b></span>
    <span class="stock-detail-modal-hi-lo">52w High/Low: <b>${data.high52w}</b> / <b>${data.low52w}</b></span>
  </div>
  <div class="stock-detail-modal-meta">
    <span><b>CEO:</b> ${data.ceo}</span>
    <span><b>Employees:</b> ${data.employees}</span>
    <span><b>Founded:</b> ${data.founded}</span>
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