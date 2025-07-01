<?php

require_once __DIR__ . '/config.php';



function getStockInfo($symbol, $apiKey, $country) {
    $url = "https://api.twelvedata.com/quote?symbol=$symbol&apikey=$apiKey";
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    // Handle possible API errors
    if (!isset($data['close'])) {
        throw new Exception("API Error: " . ($data['message'] ?? 'Unknown error'));
    }
    $currency = getCurrencyByCountry($country);
    if (!$currency) {
        throw new Exception("Currency not found for country: $country");
    }
    $price= round($data['close'], 2);
    $priceConverted= convertCurrency('USD',$currency, $price); // Convert to USD or any other currency as needed

    return [
        'symbol' => $data['symbol'],
        'price' => $price,  // <-- use 'close' instead of 'price'
        'change_percent' => round($data['percent_change'], 2)
    ];
}

function getStocks($symbols, $apiKey, $country) {
    $result = [];
    // Limit to 3 symbols max
    $symbols = array_slice($symbols, 0, 3);

    foreach ($symbols as $symbol) {
        $result[] = getStockInfo($symbol, $apiKey, $country);
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

function convertCurrency($from, $to, $amount) {
    $url = "https://api.frankfurter.app/latest?amount=$amount&from=$from&to=$to";

    $response = file_get_contents($url);

    if (!$response) {
        return "API request failed.";
    }

    $data = json_decode($response, true);

    if (isset($data['rates'][$to])) {
        return $data['rates'][$to];
    } else {
        return "Conversion failed.";
    }
}

function getCurrencyByCountry($country) {
    $currencyMap = [
        'United States' => 'USD',
        'Canada' => 'CAD',
        'Japan' => 'JPY',
        'China' => 'CNY',
        'Germany' => 'EUR'
    ];

    return $currencyMap[$country] ?? null;
}


?>





