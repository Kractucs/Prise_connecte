<?php
//Connexion a la base de donee
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'phpmyadmin');
define('DB_PASSWORD', 'toto');
define('DB_NAME', 'mqtt');

//connection to db  
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Si pas de co alors die
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
