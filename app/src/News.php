<?php
require_once __DIR__ . '/config.php';
function getFinnhubNews($category = 'general', $limit = 10) {
    $apiKey = API_KEY; // Make sure this is defined in your config.php

    // Finnhub "general news" endpoint
    $url = "https://finnhub.io/api/v1/news?category=$category&token=$apiKey";
    $response = @file_get_contents($url);

    if (!$response) {
        echo "Failed to fetch news.";
        return [];
    }

    $data = json_decode($response, true);
    if (!is_array($data)) return [];

    $newsList = [];
    foreach ($data as $item) {
        if (
            !empty($item['headline']) &&
            !empty($item['datetime']) &&
            !empty($item['summary']) &&
            !empty($item['url'])
        ) {
            $newsList[] = [
                'title'    => $item['headline'],
                'date'     => date('Y-m-d H:i', $item['datetime']),
                'summary'  => $item['summary'],
                'url'      => $item['url'],
                'source'   => $item['source'] ?? '',
                'image'    => $item['image'] ?? '',
            ];
        }
        if (count($newsList) >= $limit) break;
    }

    return $newsList;
}
?>