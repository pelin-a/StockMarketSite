<?php
// Example function to fetch news
// function getNews() {
//     return [
//         [
//             'title' => 'BIST100 hits record: Which stocks stood out?',
//             'date' => '30 Jun 2025',
//             'category' => 'Stock Market',
//             'summary' => 'BIST100 reached an all-time high today, driven by gains in banking and technology stocks. Experts believe the uptrend may continue as investor confidence grows...',
//             'url' => '#'
//         ],
//         [
//             'title' => 'Central Bank announced rate decision, markets respond',
//             'date' => '30 Jun 2025',
//             'category' => 'Economy',
//             'summary' => 'The Central Bank kept the interest rate unchanged, prompting mixed reactions in the markets. Analysts expect volatility in the coming weeks...',
//             'url' => '#'
//         ],
//     ];
// }
require_once __DIR__ . '/config.php';
function getNews($country = 'us', $limit = 10): array {
    $apiKey = API_KEY_NEWS; // Replace with your API key
    $url = "https://newsdata.io/api/1/news?apikey=$apiKey&country=$country&category=business&language=en";

    $response = @file_get_contents($url);
    if (!$response) {
        echo "Failed to fetch news.";
        return [];
    }

    $data = json_decode($response, true);
    if (!isset($data['results'])) return [];

    $newsList = [];
    $maxFetch = 20;
    $fetched = 0;

    foreach ($data['results'] as $item) {
        if ($fetched >= $maxFetch) break;

        // Check for all required fields
        if (
            !empty($item['title']) &&
            !empty($item['pubDate']) &&
            !empty($item['category']) &&
            !empty($item['description']) &&
            !empty($item['link'])
        ) {
            $newsList[] = [
                'title'    => $item['title'],
                'date'     => $item['pubDate'],
                'category' => $item['category'][0],
                'summary'  => $item['description'],
                'url'      => $item['link'],
            ];
        }

        $fetched++;
        if (count($newsList) >= $limit) break;
    }

    return $newsList;
}

 // For testing purposes, remove in production




?>