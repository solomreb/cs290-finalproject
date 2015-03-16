<?php
//addDog.php
session_start();

if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
header ("Location: signin.html");
}
nclude 'storedInfo.php';
//header('Location: index.php');

//establish connection
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }     
    
    
//delete previous entries for this usern
$sqlQuery= "DELETE from walkers_time WHERE walker_id = '$walker_id'";
$stmt = $mysqli->prepare($sqlQuery);
$stmt->execute();
$stmt->close();

$sqlQuery= "INSERT INTO  walkers_time(walker_id, time_id) VALUES ('$walker_id', ?);";	

foreach ($_GET as $name){
	$avail = $name;
	$stmt = $mysqli->prepare($sqlQuery);
	$stmt->bind_param('i', $avail);
	$stmt->execute();
	$stmt->close();
}

?>
