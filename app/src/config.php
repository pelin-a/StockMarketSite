<?php
// Path to your SQLite DB
define('DB_PATH', __DIR__ . '/../stock_app.db');

// Example: API key for your stock/news API
define('API_KEY', 'YOUR_STOCK_API_KEY_HERE');


// Example: Site name
define('SITE_NAME', 'Stox Website');

function getDBConnection() {
    return new SQLite3(DB_PATH);
}

getDBConnection();

