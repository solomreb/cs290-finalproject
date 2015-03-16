<?php
//editContactInfo.php
session_start();
include 'storedInfo.php';
header('Location: index.php');

$username= $_SESSION["username"];
$walker_id = $_SESSION["walker_id"];

//establish connection
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }     
  
$sqlQuery= "UPDATE walkers SET phone = ?, email = ? WHERE walker_id='$walker_id';";	


$phone = $_GET['phone'];
$email = $_GET['email'];

$stmt = $mysqli->prepare($sqlQuery);
$stmt->bind_param('ss', $phone, $email);
$stmt->execute();
$stmt->close();


?>