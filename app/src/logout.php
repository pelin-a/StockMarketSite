<?php


session_start();
session_unset();
session_destroy();
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        // Try deleting with different paths and domains
        setcookie($name, '', time() - 3600, '/');
        setcookie($name, '', time() - 3600, '/', $_SERVER['HTTP_HOST']);
        setcookie($name, '', time() - 3600, '/', '', false, true);
        setcookie($name, '', time() - 3600);
    }
}

header("Location: /views/Login.php");
exit;

?>