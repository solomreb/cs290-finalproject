<?php
//editAvailability.php
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
    echo "connected.";
    
//delete previous entries for this username
$sqlQuery= "DELETE from walkers_time WHERE walker_id = ?";
$stmt = $mysqli->prepare($sqlQuery);
$stmt->bind_param('s', $walker_id);
$stmt->execute();

$sqlQuery= "INSERT INTO  walkers_time(walker_id, time_id) VALUES (?, ?)";	

foreach ($_GET as $name){
	echo "inserting " . $name . "<br>";
	$avail = $name;
	$stmt = $mysqli->prepare($sqlQuery);
	$stmt->bind_param('ii', $walker_id, $avail);
	$stmt->execute();
}


?>
