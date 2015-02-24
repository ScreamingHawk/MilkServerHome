<?php
require_once $_SERVER['DOCUMENT_ROOT'].'includes/sec_session_start.php';

$_SESSION = array();
$params = session_get_cookie_params();
setcookie(session_name(), '', 
		time() - 42000, 
		$param["path"], 
		$params["domain"], 
		$params["secure"], 
		$params["httponly"]);

session_destroy();
header('Location: /');