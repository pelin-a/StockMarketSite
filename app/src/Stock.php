<?php

require_once __DIR__ . '/config.php';



function getStockInfo($symbol, $apiKey) {
    $url = "https://api.twelvedata.com/quote?symbol=$symbol&apikey=$apiKey";
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    // Handle possible API errors
    if (!isset($data['close'])) {
        throw new Exception("API Error: " . ($data['message'] ?? 'Unknown error'));
    }

    return [
        'symbol' => $data['symbol'],
        'price' => round($data['close'], 2),  // <-- use 'close' instead of 'price'
        'change_percent' => round($data['percent_change'], 2)
    ];
}

function getStocks($symbols, $apiKey) {
    $result = [];
    // Limit to 3 symbols max
    $symbols = array_slice($symbols, 0, 3);

    foreach ($symbols as $symbol) {
        $result[] = getStockInfo($symbol, $apiKey);
        sleep(1); // avoid rapid requests
    }
    return $result;
}
function getStockSymbolsByCountry($country, $apiKey) {
    $symbols = [];
    $url = "https://api.twelvedata.com/stocks?country=" . urlencode($country) . "&apikey=" . urlencode($apiKey);

    $response = @file_get_contents($url);
    if ($response === false) {
        return ["error" => "Request failed or API limit reached."];
    }

    $data = json_decode($response, true);

    if (isset($data['data'])) {
        foreach ($data['data'] as $stock) {
            if (isset($stock['symbol'])) {
                $symbols[] = $stock['symbol'];
            }
        }
        return $symbols;
    } elseif (isset($data['message'])) {
        return ["error" => $data['message']];
    } else {
        return ["error" => "Unexpected API response."];
    }
}
// Example usage
// Replace with your real API key


 // For testing, you can remove this later




?>
