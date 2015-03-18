<?php
session_start();

include 'storedInfo.php';
//header('Location: index.php');

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    
$fname = $_POST["fname"]; 
$lname = $_POST["lname"];    
$phone = $_POST["phone"];    
$email = $_POST["email"];       
$username = $_POST["userName"];  
$pwd = $_POST["password"];


$sqlQuery= "INSERT INTO  `solomreb-db`.`walkers`(fname, lname, phone, email, username, pwd) VALUES (?, ?, ?, ?, ?, ?);";	
$stmt = $mysqli->prepare($sqlQuery);
$stmt->bind_param('ssssss', $fname, $lname, $phone, $email, $username, $pwd);
//execute prepared statement
$stmt->execute();

printf("%d Row inserted.\n", $stmt->affected_rows);
?>
