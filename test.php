<?php
require_once('app/src/User.php');

//echo registration('testuser', 'testpassword', 'testuser@example.com') . "<br>";

echo login('testuser@example.com', 'testpassword') ;
echo login('testuser@example.com', 'testpassword2') ;

?>