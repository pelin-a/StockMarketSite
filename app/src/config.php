<?php
// Path to your SQLite DB
define('DB_PATH', __DIR__ . '/../stock_app.sqlite3');

// Example: API key for your stock/news API
define('API_KEY', 'd1cppkhr01qic6lf7e20d1cppkhr01qic6lf7e2g');


// Example: Site name
define('SITE_NAME', 'Stox Website');


// Global STOCKS dictionary with country as key and array of tickers as value
define('STOCKS', [
    "World" => [
        "AAPL", "MSFT", "GOOGL", "AMZN", "TSLA",
        "NVDA", "META", "NFLX", "V", "MA",
        "JNJ", "PG", "DIS", "ADBE", "PEP"
    ],
    "USA" => [
        "AAPL", "MSFT", "GOOGL", "AMZN", "TSLA",
        "NVDA", "META", "JPM", "WMT", "UNH",
        "DIS", "BAC", "PEP", "CVX", "KO"
    ],
    "Germany" => [
        "SAP", "DTE.DE", "BAS.DE", "ALV.DE", "BMW.DE",
        "DBK.DE", "VOW3.DE", "SIE.DE", "BAYN.DE", "FRE.DE"
    ],
    "UK" => [
        "HSBA.L", "BP.L", "VOD.L", "GSK.L", "AZN.L",
        "RIO.L", "ULVR.L", "BARC.L", "LLOY.L", "DGE.L"
    ],
    "Turkey" => [
        "THYAO.IS", "GARAN.IS", "AKBNK.IS", "BIMAS.IS", "SISE.IS",
        "KCHOL.IS", "TUPRS.IS", "ASELS.IS", "ISCTR.IS", "FROTO.IS"
    ],
    "China" => [
        "BABA", "PDD", "JD", "NIO", "LI",
        "TCEHY", "BIDU", "XPEV", "DIDI", "BILI"
    ],
    "Canada" => [
        "RY.TO", "TD.TO", "BNS.TO", "ENB.TO", "BAM.TO",
        "CM.TO", "SHOP.TO", "TRP.TO", "BCE.TO", "SU.TO"
    ],
    "Spain" => [
        "SAN.MC", "ITX.MC", "BBVA.MC", "IBE.MC", "REP.MC",
        "FER.MC", "ACS.MC", "NTGY.MC", "AENA.MC", "CABK.MC"
    ],
    "Japan" => [
        "SONY", "TM", "NTDOY", "MFG", "NMR",
        "SMFG", "SFTBY", "CAJ", "HMC", "8306.T"
    ]
]
) 


// Usage example:
// print_r(STOCKS['Germany']);
?>




