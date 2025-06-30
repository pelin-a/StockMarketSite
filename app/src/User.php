<?php
require_once 'db.php';

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
            return True;
        } else {
            return False;
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
            
            return True;
        } else {
            
            return 2;
        }
    } else {
        
        return False;
    }
}
}

$usr= new User('', '', ''); // Create an instance of User class with empty values
// You can now use $usr to call methods like $usr->registration() or $usr

// $usr -> registration('pelin','pelin', 'pelin@gmail.com')

// print($usr -> login('pelin@gmail.com', 'pelin'));

?>
