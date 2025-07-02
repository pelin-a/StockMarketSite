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