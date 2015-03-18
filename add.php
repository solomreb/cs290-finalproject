<?php
include 'storedInfo.php';
header('Location: index.php');

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
$sqlQuery= "INSERT INTO  `solomreb-db`.`dogs` (`name` , `breed_id` , `owner_id`) VALUES ( ?, (SELECT  `breed_id` FROM  `breeds` WHERE  `breed_description` =  ?), (SELECT  `client_id` FROM  `clients` WHERE  `fname` =  ? AND `lname` = ?));";	
$stmt = $mysqli->prepare($sqlQuery);
$stmt->bind_param('ssiss',$name, $breed, $age, $fname, $lname);
$name = $_GET["name"];
$breed = $_GET["breed"];
$age = $_GET["age"];
$fname = $_GET["fname"];
$lname = $_GET["lname"];
echo $name;


//execute prepared statement
	$stmt->execute();
printf("%d Row inserted.\n", $stmt->affected_rows);

?>