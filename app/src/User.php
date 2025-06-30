<?php
require_once 'db.php';

// // Now you can use $db directly here
// $result = $db->query("SELECT * FROM users");

// while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
//     echo $row['username'] . "<br>";
// }

function registration($username, $password, $email): string {
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
        return "Username or email already exists.";
    } else {    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertStatement = $db->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
        $insertStatement->bindValue(":username", $username, SQLITE3_TEXT);
        $insertStatement->bindValue(":password", $hashedPassword, SQLITE3_TEXT);
        $insertStatement->bindValue(":email", $email, SQLITE3_TEXT);
        if ($insertStatement->execute()) {
            return "Registration successful.";
        } else {
            return "Registration failed.";
        }
    }
    
}

function login($email, $password): string {
    $db = getDBConnection();
    $statement= $db->prepare("SELECT * FROM users WHERE email = :email");
    $statement->bindValue(":email", $email, SQLITE3_TEXT);
    $result = $statement->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if ($row) { 
        if (password_verify($password, $row['password'])) {
            echo "Login successful.";
            return True;
        } else {
            echo "Invalid password.";
            return False;
        }
    } else {
        echo "User not found.";
        return False;
    }
}



?>
