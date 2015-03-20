<?php
include 'storedInfo.php';
header("Location: index.php");

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
    
$row = $_GET["nameid"];
echo "deleting row " . $row . "\n";
if (!($stmt = mysqli_query($mysqli, "DELETE FROM videos WHERE id='$row'"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

?>