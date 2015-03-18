<?php 
session_start();
$_SESSION['userName']= $_POST['username'];

include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

define("ERR_INVALID_USERNAME", "1");
define("ERR_EXISTING_USERNAME", "2");
define("ERR_INVALID_PASSWORD", "3");

$errors = array ();

//username is set
if (isset ($_POST["userName"])) {
//username is set. check if it exists in the db
    $username = $_POST["userName"];

	$query = "select username from users where username = ? ";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('s',$username);
	$stmt->execute();
	$stmt->store_result();
	$numRows = $stmt->num_rows;
	if($stmt->num_rows<=0){
	//username does not exist in db
		array_push ($errors, ERR_INVALID_USERNAME);
	}	  
}

else {
//no username entered
    array_push ($errors, ERR_INVALID_USERNAME);
}


if (isset ($_POST["password"])) {
//password is set. check for valid password
    $password = $_POST["password"];
    $len = strlen ($password);
    if ($len < 6 || $len > 20) {
    //password is too short
        array_push ($errors, ERR_INVALID_PASSWORD);
    }
    else {
    //password is right length. check repassword is the same
        if (!isset ($_POST["repassword"]) || strcmp ($password, $_POST["repassword"]) != 0) {
            array_push ($errors, ERR_DIFFERENT_PASSWORDS);
        }
    }
}
else {
    array_push ($errors, ERR_INVALID_PASSWORD);
}

$response = "";
if (sizeof ($errors) > 0) {
    $response = implode (",", $errors);
}
else {
        // some db operations, save username and password ...
    
    $response = "ok";
}

echo ($response);	

?>