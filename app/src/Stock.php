<?php



function getStockInfo($symbol, $apiKey) {
    // Get quote (real-time price)
    $quoteUrl = "https://finnhub.io/api/v1/quote?symbol=" . urlencode($symbol) . "&token=" . $apiKey;
    $quoteJson = file_get_contents($quoteUrl);
    if ($quoteJson === false) {
        die("Failed to fetch quote data.");
    }
    $quoteData = json_decode($quoteJson, true);

    // Get company profile (logo, name)
    $profileUrl = "https://finnhub.io/api/v1/stock/profile2?symbol=" . urlencode($symbol) . "&token=" . $apiKey;
    $profileJson = file_get_contents($profileUrl);
    if ($profileJson === false) {
        die("Failed to fetch company profile data.");
    }
    $profileData = json_decode($profileJson, true);

    // Combine data
    return [
        'symbol' => $symbol,
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
$apiKey = 'YOUR_API_KEY_HERE';
$symbol = 'AAPL';  // Replace with desired stock symbol
$stockInfo = getStockInfo($symbol, $apiKey);

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
?>
