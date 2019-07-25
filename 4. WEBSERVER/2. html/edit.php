<?php
// Initialize the session
session_start();

require_once "config.php";


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}


if(!isset($_GET['id'])) {
    $sql = "INSERT INTO `Progra` (`id`, `prise_id`, `time`, `state`) VALUES (NULL, ?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);
    $state = $_GET['state'];
    $state = strtoupper($state);
    mysqli_stmt_bind_param($stmt,'sss', $_GET['prise_id'], $_GET['heure'],$state);
    if(mysqli_stmt_execute($stmt)){
        header("location: programmation.php");
    }
    else { 
        echo ("WOUPS... ! il y a un problème...");        
    }    
}
else if(isset($_GET['id'])){
    $sql = "DELETE FROM `Progra` WHERE `Progra`.`id` = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt,'i', $_GET['id']);
    if(mysqli_stmt_execute($stmt)){
        header("location: programmation.php");
    }
    else { 
        echo ("WOUPS... ! il y a un problème...");        
    }    
}



?>
