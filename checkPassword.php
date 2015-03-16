<?php
//checkPassword.php
session_start();

if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
header ("Location: signin.html");
}

include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

define("ERR_INVALID_USERNAME", "1");
define("ERR_NO_USERNAME", "2");
define("ERR_INVALID_PASSWORD", "3");
define("ERR_NO_USERNAME", "4");


$errors = array ();

if (isset ($_POST["userName"]) && $_POST["userName"] != "" && $_POST["userName"] != null) {
//username is set. check if it exists in the db
    $username = $_POST["userName"];
	$query = "select username from walkers where username = ? ";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('s',$username);
	$stmt->execute();
	$stmt->store_result();
	$numRows = $stmt->num_rows;
	if($stmt->num_rows<=0){
	//username does not exist in db
		array_push ($errors, ERR_INVALID_USERNAME);
	}	
	$stmt->close();  
}

else {
//no username entered
    array_push ($errors, ERR_NO_USERNAME);
}


if (isset ($_POST["password"]) && $_POST["password"] != "" && $_POST["password"] != null) {

//password is set. check if matches for username
    $password = $_POST["password"];
    
    $query = "SELECT username FROM walkers WHERE username = ? AND pwd = ?";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('ss', $username, $password);
	$stmt->execute();
	$stmt->store_result();
	$numRows = $stmt->num_rows;
	if($stmt->num_rows<=0){
		//username/password combo does not exist in db
		array_push ($errors, ERR_INVALID_PASSWORD);
	}
	$stmt->close();

}
else {
    array_push ($errors, ERR_NO_PASSWORD);
}

if (sizeof ($errors) > 0) {
    $response = implode (",", $errors);
}
else {
	session_start();
	$_SESSION['username']= $username;
	$query = "SELECT walker_id FROM walkers WHERE username= '$username'";
	$stmt = $mysqli->prepare($query);
	$stmt->execute();
	$stmt->bind_result($walker_id);
	$stmt->fetch();
	$_SESSION['walker_id'] = $walker_id;
    $response = "ok";
}


echo ($response);	

?>