<?php

require_once __DIR__ . '/config.php';

function getStockInfo($symbol) {
    // Get quote (real-time price)
    $quoteUrl = "https://finnhub.io/api/v1/quote?symbol=" . urlencode($symbol) . "&token=" . API_KEY;
    $quoteJson = file_get_contents($quoteUrl);
    if ($quoteJson === false) {
        die("Failed to fetch quote data.");
    }
    $quoteData = json_decode($quoteJson, true);

    // Get company profile (logo, name)
    $profileUrl = "https://finnhub.io/api/v1/stock/profile2?symbol=" . urlencode($symbol) . "&token=" . API_KEY;
    $profileJson = file_get_contents($profileUrl);
    if ($profileJson === false) {
        die("Failed to fetch company profile data.");
    }
    $profileData = json_decode($profileJson, true);

    // Combine data
    return [
        'symbol' => $symbol,
        'country' => $profileData['country'] ?? 'N/A',
        'currency' => $profileData['currency'] ?? 'N/A',
        'name' => $profileData['name'] ?? 'N/A',
        'logo' => $profileData['logo'] ?? '',
        'current_price' => $quoteData['c'] ?? 'N/A',
        'open_price' => $quoteData['o'] ?? 'N/A',
        'high_price' => $quoteData['h'] ?? 'N/A',
        'low_price' => $quoteData['l'] ?? 'N/A',
        'previous_close' => $quoteData['pc'] ?? 'N/A',
    ];
}

// Example usage

$symbol = 'AAPL';  // Replace with desired stock symbol
$stockInfo = getStockInfo($symbol);

// Output the results
echo "<h2>{$stockInfo['name']} ({$stockInfo['symbol']})</h2>";
if ($stockInfo['logo']) {
    echo "<img src=\"{$stockInfo['logo']}\" alt=\"Logo\" width=\"100\"><br>";
}
echo "Current Price: {$stockInfo['current_price']}<br>";
echo "Open: {$stockInfo['open_price']}<br>";
echo "High: {$stockInfo['high_price']}<br>";
echo "Low: {$stockInfo['low_price']}<br>";
echo "Previous Close: {$stockInfo['previous_close']}<br>";




// $view = $_GET['view'] ?? 'today';  // Default to 'today' if not set

// // Decide date range based on view
// switch ($view) {
//     case 'week':
//         $from = date('Y-m-d', strtotime('-7 days'));
//         break;
//     case 'month':
//         $from = date('Y-m-d', strtotime('-30 days'));
//         break;
//     case 'today':
//     default:
//         $from = date('Y-m-d');
//         break;
// }

// $to = date('Y-m-d');
function getHistoricalData($symbol, $from, $to) {
    // Finnhub needs UNIX timestamps
    $fromTs = strtotime($from);
    $toTs = strtotime($to);
    
    $url = "https://finnhub.io/api/v1/stock/candle?symbol=" . urlencode($symbol) .
           "&resolution=D&from=$fromTs&to=$toTs&token={API_KEY}";

    $json = file_get_contents($url);
    if ($json === false) {
        die("Failed to fetch historical data.");
    }

    return json_decode($json, true);
}

?>
