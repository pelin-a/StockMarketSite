<?php
require_once __DIR__ . '/db.php'; // Adjust path if needed

// // Now you can use $db directly here
// $result = $db->query("SELECT * FROM users");

// while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
//     echo $row['username'] . "<br>";
// }

Class User {
    private $username;
    private $password;
    private $email;

    public function __construct($username, $password, $email) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }





    function registration($username, $firstname,$lastname, $password, $email) {
    $db = getDBConnection();
    $statement= $db-> prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        if (!$statement) {
        return "Prepare failed: " . $db->lastErrorMsg();
    }
    $statement-> bindValue(":username", $username, SQLITE3_TEXT);
    $statement-> bindValue( ":email", $email, SQLITE3_TEXT);
    $result = $statement->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if ($row) {
        return 2; // User already exists
    } else {    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertStatement = $db->prepare("INSERT INTO users (username, firstname, lastname, password, email, created_at) VALUES (:username, :firstname, :lastname, :password, :email, :created_at)");
        $insertStatement->bindValue(":username", $username, SQLITE3_TEXT);
        $insertStatement->bindValue(":firstname", $firstname, SQLITE3_TEXT);
        $insertStatement->bindValue(":lastname", $lastname, SQLITE3_TEXT);   
        $insertStatement->bindValue(":password", $hashedPassword, SQLITE3_TEXT);
        $insertStatement->bindValue(":email", $email, SQLITE3_TEXT);
        $insertStatement->bindValue(":created_at", date('Y-m-d H:i:s'), SQLITE3_TEXT);
        if ($insertStatement->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
}

function login($email, $password) {
    $db = getDBConnection();
    $statement= $db->prepare("SELECT * FROM users WHERE email = :email");
    $statement->bindValue(":email", $email, SQLITE3_TEXT);
    $result = $statement->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if ($row) { 
        if (password_verify($password, $row['password'])) {
            
            return true;
        } else {
            
            return 2;
        }
    } else {
        
        return false;
    }
}
}

function getUserInfo($email) {
    $db = getDBConnection();
    $statement = $db->prepare('SELECT * FROM users WHERE email = :email');
    if (!$statement) {
        return ["error" => "Prepare failed: " . $db->lastErrorMsg()];
    }
    $statement->bindValue(":email", $email, SQLITE3_TEXT);
    $result = $statement->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if ($row) {
        return $row; // returns associative array (dictionary)
    } else {
        return null; // user not found
    }
}
function addToFavorites($userEmail, $symbol) {
    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }
    // Aynı sembol birden fazla eklenmesin
    foreach ($_SESSION['favorites'] as $fav) {
        if ($fav['symbol'] === $symbol) return;
    }
    $_SESSION['favorites'][] = [
        'symbol' => $symbol,
        'added_at' => date('Y-m-d H:i:s'),
        'user' => $userEmail
    ];
}
function addToPortfolio($userEmail, $symbol, $price = null, $quantity = 1) {
    if (!isset($_SESSION['portfolio'])) {
        $_SESSION['portfolio'] = [];
    }
    // Aynı stock tekrar alınırsa miktarı arttır
    foreach ($_SESSION['portfolio'] as &$item) {
        if ($item['symbol'] === $symbol) {
            $item['quantity'] += $quantity;
            return;
        }
    }
    // Yoksa yeni kaydı ekle
    $_SESSION['portfolio'][] = [
        'symbol' => $symbol,
        'buy_price' => $price,
        'quantity' => $quantity,
        'buy_date' => date('Y-m-d H:i:s'),
        'user' => $userEmail
    ];
}
$usr= new User('', '', ''); 

// print($usr -> login('pelin@gmail.com', 'pelin'));


?>
