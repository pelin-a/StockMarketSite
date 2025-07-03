<?php
// Path to your SQLite DB
define('DB_PATH', __DIR__ . '/../stock_app.sqlite3');

// Example: API key for your stock/news API
define('API_KEY', '043de246c6e34bc8b644bdaa7f669aca');

define('API_KEY_NEWS', 'pub_999d0506b4f1461badb43e6e9fcdd42c');
// Example: Site name
define('SITE_NAME', 'Stox Website');
define('COUNTRY_SYMBOLS', [
    'USA' => ['AAPL', 'MSFT', 'GOOGL', 'AMZN', 'TSLA', 'NVDA', 'META', 'JPM', 'BAC', 'NFLX'],
    'Germany' => ['SAP.DE', 'BAS.DE', 'ALV.DE', 'VOW3.DE', 'DTE.DE'],
    'Japan' => ['7203.T', '6758.T', '9984.T', '8316.T', '6861.T'],
    'China' => ['BABA', 'JD', 'PDD', 'NIO', 'TCEHY']]);

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
        "FSX", "XETR", "XMUN", "XSTU", "XHAM",
        "DUS", "XBER"
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
) ;

function getStocksByCountry($country){

    $stocksData = [
    'United States' => [
        ['symbol' => 'AAPL', 'price' => 200.08, 'change_percent' => -0.49],
        ['symbol' => 'MSFT', 'price' => 330.55, 'change_percent' => 1.12],
        ['symbol' => 'GOOGL', 'price' => 2800.35, 'change_percent' => 0.75],
        ['symbol' => 'AMZN', 'price' => 126.78, 'change_percent' => 0.92],
        ['symbol' => 'TSLA', 'price' => 255.10, 'change_percent' => -1.20],
    ],
    'Germany' => [
        ['symbol' => 'DTE.DE', 'price' => 22.45, 'change_percent' => 0.85],
        ['symbol' => 'BAS.DE', 'price' => 48.90, 'change_percent' => -0.42],
        ['symbol' => 'BMW.DE', 'price' => 96.30, 'change_percent' => 1.05],
        ['symbol' => 'SAP.DE', 'price' => 135.70, 'change_percent' => -0.18],
        ['symbol' => 'VOW3.DE', 'price' => 112.80, 'change_percent' => 0.34],
    ],
    'Canada' => [
        ['symbol' => 'SHOP.TO', 'price' => 89.75, 'change_percent' => 2.13],
        ['symbol' => 'RY.TO', 'price' => 123.10, 'change_percent' => -0.66],
        ['symbol' => 'TD.TO', 'price' => 80.40, 'change_percent' => 0.12],
        ['symbol' => 'BNS.TO', 'price' => 66.20, 'change_percent' => -0.45],
        ['symbol' => 'ENB.TO', 'price' => 51.75, 'change_percent' => 0.27],
    ],
    'China' => [
        ['symbol' => 'BABA', 'price' => 78.60, 'change_percent' => -1.25],
        ['symbol' => 'JD', 'price' => 33.45, 'change_percent' => 0.73],
        ['symbol' => 'TCEHY', 'price' => 40.20, 'change_percent' => 0.38],
        ['symbol' => 'PDD', 'price' => 120.10, 'change_percent' => -0.90],
        ['symbol' => 'NIO', 'price' => 9.45, 'change_percent' => 2.05],
    ],
    'Japan' => [
        ['symbol' => 'TM', 'price' => 171.98, 'change_percent' => 0.55],       // Toyota
        ['symbol' => 'SONY', 'price' => 25.71, 'change_percent' => -0.88],     // Sony
        ['symbol' => 'SFTBY', 'price' => 36.80, 'change_percent' => 1.20],     // SoftBank
        ['symbol' => 'HMC', 'price' => 29.68, 'change_percent' => 0.45],       // Honda
        ['symbol' => 'NTTYY', 'price' => 3.10, 'change_percent' => -0.35],     // NTT
    ]
    ];
    return $stocksData[$country] ?? [];
}
function getFavStocks(){
    $stocksData = [
    ['symbol' => 'DTE.DE', 'price' => 22.45, 'change_percent' => 0.85],
    ['symbol' => 'BAS.DE', 'price' => 48.90, 'change_percent' => -0.42],
    ['symbol' => 'BMW.DE', 'price' => 96.30, 'change_percent' => 1.05],
    ['symbol' => 'SAP.DE', 'price' => 135.70, 'change_percent' => -0.18],
    ['symbol' => 'VOW3.DE', 'price' => 112.80, 'change_percent' => 0.34],
] ;
    return $stocksData;
}

?>




