<?php

require_once __DIR__ . '/config.php';



// Example usage





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
#TODO:
function getYahooHistoricalData($symbol, $from, $to) {
    // Convert dates to UNIX timestamps
$symbol = 'AAPL';
$from = strtotime("-1 year");
$to = time();
$api_key = 'your_finnhub_api_key';

$url = "https://finnhub.io/api/v1/stock/candle?symbol=$symbol&resolution=D&from=$from&to=$to&token=$api_key";

$response = file_get_contents($url);
$data = json_decode($response, true);

if ($data && $data['s'] === 'ok') {
    foreach ($data['t'] as $i => $timestamp) {
        echo date('Y-m-d', $timestamp) . ": Open: {$data['o'][$i]}, Close: {$data['c'][$i]}<br>";
    }
} else {
    echo "Failed to fetch historical data.";
}


}

// Usage:


function getStocks($country="World"): array {
    $stocks=[];

    // Check if the country exists in the STOCKS dictionary
    if (array_key_exists($country, STOCKS)) {

        foreach (STOCKS[$country] as $symbol) {
        $info = getStockInfo1($symbol);
        if ($info) {
            $stocks[] = $info;
        }}
    
        return $stocks;
    } else {
        echo 'country not found';
        return []; // Return an empty array if the country is not found
    }

    
}


function getStockInfo(string $symbol): ?array {
    $apiKey = '043de246c6e34bc8b644bdaa7f669aca'; // Store this in config or environment variable ideally
    $url = "https://api.twelvedata.com/quote?symbol={$symbol}&apikey={$apiKey}";

    $response = @file_get_contents($url);
    if ($response === FALSE) {
        echo "Failed to fetch stock data for {$symbol}.\n";
        return null;
    }

    $data = json_decode($response, true);

    // Check if response contains error
    if (isset($data['code']) || empty($data['symbol'])) {
        return null;
    }


    return [
        'symbol' => $data['symbol'],
        'name' => $data['name'] ?? '',
        'exchange' => $data['exchange'] ?? '',
        'currency' => $data['currency'] ?? '',
        'current_price' => $data['price'] ?? null,
        'open_price' => $data['open'] ?? null,
        'high_price' => $data['high'] ?? null,
        'low_price' => $data['low'] ?? null,
        'previous_close' => $data['previous_close'] ?? null,
        'percent_change' => $data['percent_change'] ?? null
    ];
}
// Change 'World' to any country key you want to fetch stocks for

#print_r(getStocks('USA'));

function getStockInfo1($symbol) {
    $apiKey = 'Z5OLAZQ3WLN36XNH';
    $url = "https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=$symbol&apikey=$apiKey";

    $response = file_get_contents($url);
    if (!$response) {
        echo "Failed to fetch data.";
        return null;
    }

    $data = json_decode($response, true);
    
    if (!isset($data["Global Quote"])) {
        return null;
    }

    $quote = $data["Global Quote"];
    
    return [
        "symbol" => $quote["01. symbol"],
        "open_price" => $quote["02. open"],
        "high_price" => $quote["03. high"],
        "low_price" => $quote["04. low"],
        "current_price" => $quote["05. price"],
        "previous_close" => $quote["08. previous close"]
    ];
}

$json = file_get_contents('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=demo');

function display($stocks){
    foreach ($stocks as $stock) {
        echo $stock['symbol'] .'/';
    }
}

// Example usage (uncomment and provide valid $stocks data to test):
display(getStocks('Germany'));

?>
