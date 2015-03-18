<?php
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

$username = mysql_real_escape_string($_POST['username']);
  

//check if username exists
$stmt = $mysqli->prepare("SELECT username FROM `solomreb-db`.`users` WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();
if($stmt->num_rows>0){
	echo 0;
}
else{
	echo 1;	
}

/*
//insert username and password into database
$stmt = $mysqli->prepare("INSERT INTO  `solomreb-db`.`users`(username, pwd) VALUES (?, ?)");
$stmt->bind_param('ss', $user, $pwd);

$stmt->execute();
printf("%d Row inserted.\n", $stmt->affected_rows);

*/

?>