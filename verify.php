<?php 
include 'storedInfo.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
}

define("ERR_INVALID_USERNAME", "1");
define("ERR_EXISTING_USERNAME", "2");
define("ERR_INVALID_PASSWORD", "3");
define("ERR_DIFFERENT_PASSWORDS", "4");
define("ERR_INVALID_EMAIL", "5");
define("ERR_INVALID_PHONE", "6");
define("ERR_NO_NAME", "7");



$errors = array ();


if (isset ($_POST["userName"])) {
//username is set. check for valid username
    $username = $_POST["userName"];
    $len = strlen ($username);
    if ($len < 2 || $len > 20) {
    //username is too short
        array_push ($errors, ERR_INVALID_USERNAME);
    }
    else {
    //username is a valid lenghth
		$query = "select username from walkers where username = ? ";
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param('s',$username);
		$stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		if($stmt->num_rows>0){
		//username already exists
			array_push ($errors, ERR_EXISTING_USERNAME);
		}	  
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

if(isset ($_POST["phone"])){
	$phone = $_POST["phone"];
	
	if(!preg_match("
/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i", $phone)) {
		array_push ($errors, ERR_INVALID_PHONE);
	}
}
else {
	array_push ($errors, ERR_INVALID_PHONE);
}

if (isset ($_POST["email"])) {
//email is set. check for valid email
  $email = $_POST["email"];

	// Remove all illegal characters from email
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);

	// Validate e-mail
	if (!filter_var($email, FILTER_VALIDATE_EMAIL) === true) {
		array_push ($errors, ERR_INVALID_EMAIL);	
	} 

}
else {
    array_push ($errors, ERR_INVALID_EMAIL);
}

if (isset ($_POST["lname"])) {
//email is set. check for valid email
  	$lname = $_POST["lname"];
    $len = strlen ($lname);
    if ($len < 1 || $len > 50) {
    //name is too short or too long
        array_push ($errors, ERR_NO_NAME);
    }

}
else {
    array_push ($errors, ERR_NO_NAME);
}

$response = "";

if (sizeof ($errors) > 0) {
    $response = implode (",", $errors);
}
else {
//successful. create new account
	
	$fname = $_POST["fname"]; 
	$lname = $_POST["lname"];    
	$phone = $_POST["phone"];    
	$email = $_POST["email"];       
	$username = $_POST["userName"];  
	$pwd = $_POST["password"];

//insert user into walkers db
	$sqlQuery= "INSERT INTO  walkers(fname, lname, phone, email, username, pwd) VALUES (?, ?, ?, ?, ?, ?);";	
	$stmt = $mysqli->prepare($sqlQuery);
	$stmt->bind_param('ssssss', $fname, $lname, $phone, $email, $username, $pwd);
	//execute prepared statement
	$stmt->execute();
    $response = "ok";
}

echo ($response);	

?>