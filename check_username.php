<?php

if(isset($_POST["username"]))
{

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
  //received username value from registration page
  $username =  $_POST["username"]; 

  //check username in db
  
  $stmt = $mysqli->prepare("SELECT username FROM `solomreb-db`.`users` WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();

if($stmt->num_rows > 0){
	die('username already exists');
}
else{
	die('username is available');
}

}

?>