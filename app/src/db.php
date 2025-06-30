<?php
// Path to your SQLite database file
$db_file = '/Users/pelinsualtun/Documents/Stox_Web/stock_app.sqlite3';

// Open (or create) SQLite3 database connection
try {
    $db = new SQLite3($db_file);
} catch (Exception $e) {
    die("Failed to create or open the database: " . $e->getMessage());
}


// You can optionally wrap your connection in a function like this:
function getDBConnection() {
    global $GLOBALS;
    return $GLOBALS['db'];
}

// Use $db or getDBConnection() from here onward

// SQL to create tables (note: no trailing commas before closing parentheses)


?>
