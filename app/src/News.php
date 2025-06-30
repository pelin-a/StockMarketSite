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
    foreach (array_slice($data['results'], 0, $limit) as $item) {
        $newsList[] = [
            'title'    => $item['title'] ?? 'No Title',
            'date'     => $item['pubDate'] ?? 'No Date',
            'category' => $item['category'][0] ?? 'General',
            'summary'  => $item['description'] ?? 'No Summary',
            'url'      => $item['link'] ?? '#',
        ];
    }

    return $newsList;
}




?>