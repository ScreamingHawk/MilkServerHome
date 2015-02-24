<?php 

$session_name = 'sec_session_id';
//TODO Change this to true once HTTPS implemented
$secure = false;
$httponly = true;
// Force cookies
if (ini_set('session.use_only_cookies', 1) === FALSE) {
	header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
	exit();
}
// Get current cookies
$cookieParams = session_get_cookie_params();
session_set_cookie_params($cookieParams["lifetime"],
		$cookieParams["path"],
		$cookieParams["domain"],
		$secure,
		$httponly);
session_name($session_name);
session_start();
// Delete old session id
session_regenerate_id(); 