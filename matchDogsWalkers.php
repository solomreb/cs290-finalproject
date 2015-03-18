<?php
//matchDogsWalkers.php
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
    
//delete from dogs_walkers all rows where walker_id = walker_id
$query = "DELETE FROM dogs_walkers WHERE walker_id = '$walker_id'";
if (!($stmt = mysqli_query($mysqli, $query))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}


//select all time slots for walker
$timeQuery= "SELECT time_id FROM walkers_time WHERE walker_id = '$walker_id'";
echo "selecting times for walker $walker_id<br>";
if (!($stmt = mysqli_query($mysqli, $timeQuery))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
//for each timeslot, find all dogs who need that timeslot and are not already being walked
while ($timeSlots = mysqli_fetch_array($stmt)){
	$time_id = $timeSlots['time_id'];
	$findDogsQuery = "SELECT dogs_time.dog_id FROM dogs_time " .  
	"WHERE time_id = '$time_id' AND NOT EXISTS (SELECT * FROM dogs_walkers " . 
	"WHERE dogs_walkers.walker_id = '$walker_id' AND dogs_walkers.dog_id = dogs_time.dog_id) ";
	echo "$findDogsQuery<br>";
	$result = mysqli_query($mysqli, $findDogsQuery);
	while ($resultRow = mysqli_fetch_array($result)){
		$dog_id = $resultRow['dog_id'];
		$insertQuery = "INSERT INTO dogs_walkers(walker_id, dog_id, time_id) VALUES " . 
		"('$walker_id', '$dog_id', '$time_id')";
		echo "$insertQuery<br>";
		$insertResult = mysqli_query($mysqli, $insertQuery);
	}
	
}

?>