<?php

require_once __DIR__ . '/config.php';


// Finnhub.io version for stock info


function getStockInfo($symbol, $apiKey, $country) {
    // Finnhub quote endpoint
    $quoteUrl = "https://finnhub.io/api/v1/quote?symbol=" . urlencode($symbol) . "&token=" . urlencode($apiKey);
    $profileUrl = "https://finnhub.io/api/v1/stock/profile2?symbol=" . urlencode($symbol) . "&token=" . urlencode($apiKey);

    $quoteJson = @file_get_contents($quoteUrl);
    if ($quoteJson === false) {
        throw new Exception("API Error: Failed to fetch quote data for $symbol");
    }
    $quote = json_decode($quoteJson, true);

    $profileJson = @file_get_contents($profileUrl);
    if ($profileJson === false) {
        throw new Exception("API Error: Failed to fetch profile data for $symbol");
    }
    $profile = json_decode($profileJson, true);

    if (!isset($quote['c'])) {
        throw new Exception("API Error: Invalid quote data for $symbol");
    }

    $currency = getCurrencyByCountry($country);
    if (!$currency) {
        throw new Exception("Currency not found for country: $country");
    }

    $price = isset($quote['c']) ? round($quote['c'], 2) : null;
    $originalCurrency = $profile['currency'] ?? 'USD';
    $priceConverted = $price;
    if ($price !== null && $originalCurrency !== $currency) {
        echo "Converting $price $originalCurrency to $currency<br>";
        $priceConverted = convertCurrency($originalCurrency, $currency, $price);
    }

    // Calculate change and percent change if possible
    $previousClose = $quote['pc'] ?? null;
    $change = null;
    $changePercent = null;
    if ($price !== null && $previousClose !== null) {
        $change = round($price - $previousClose, 2);
        if ($previousClose != 0) {
            $changePercent = round(($change / $previousClose) * 100, 2);
        }
    }

    return [
        'symbol' => $profile['ticker'] ?? $symbol,
        'name' => $profile['name'] ?? null,
        'price' => $priceConverted,
        'currency' => $currency,
        'open' => $quote['o'] ?? null,
        'high' => $quote['h'] ?? null,
        'low' => $quote['l'] ?? null,
        'previous_close' => $previousClose,
        'change' => $change,
        'change_percent' => $changePercent,
        'volume' => $quote['v'] ?? null,
        'exchange' => $profile['exchange'] ?? null,
        'market_cap' => $profile['marketCapitalization'] ?? null,
        'logo' => $profile['logo'] ?? null,
        'industry' => $profile['finnhubIndustry'] ?? null,
        'country' => $profile['country'] ?? null,
        'website' => $profile['weburl'] ?? null,
    ];
}

function getStocks($symbols, $apiKey, $country) {
    $result = [];
    // Limit to 4 symbols max
    $symbols = array_slice($symbols, 0, 4);
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
function getCurrencySymbol($currencyCode) {
    $symbols = [
        'USD' => '$',
        'EUR' => '€',
        'CAD' => 'C$',
        'JPY' => '¥',
        'CNY' => '¥'
    ];
    return $symbols[$currencyCode] ?? $currencyCode;
}


//print_r(getStocks(['AAPL', 'MSFT', 'GOOGL', 'AMZN', 'TSLA'], API_KEY, 'United States'));

?>





