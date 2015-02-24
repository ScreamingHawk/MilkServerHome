<?php
require_once $_SERVER['DOCUMENT_ROOT'].'includes/sec_session_start.php';

require_once $_SERVER['DOCUMENT_ROOT'].'includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'].'includes/functions.php';

if (isset($_POST['email'], $_POST['p'])) {
	$email = $_POST['email'];
	$password = $_POST['p'];
	
	if (login($email, $password, $mysqli) == true) {
		if (isset($_SERVER['HTTP_REFERER'])){
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		} else {
			header('Location: ..index.php');
		}
	} else {
		header('Location: ../index.php?error=1');
	}
} else {
	echo 'Invalid Request';
}