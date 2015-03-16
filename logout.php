<?php
//logout.php
//code from http://php.net/session_destroy

//redirect
header('Location: signin.html');

//initialize session
	session_start();

//unset all session variables
	$_SESSION = array();
	

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
	
//destroy session	
	session_destroy();
	

	
?>