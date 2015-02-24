<?php
require_once $_SERVER['DOCUMENT_ROOT'].'includes/db_connect.php';

$header_block_register = true;
$error_msg = "";
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error_msg .= 'The email address you entered is not valid. ';
	}
	
	$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
	if (strlen($password) != 128) {
		$error_msg .= 'Invalid password configuration. ';
	}
	
	$prep_stmt = "SELECT id FROM user WHERE email = ? LIMIT 1";
	$stmt = $mysqli->prepare($prep_stmt);
	
	if ($stmt) {
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows == 1) {
			$error_msg .= 'A user with this email address already exists. ';
		}
		$stmt->close();
	} else {
		$stmt->close();
	}
	
	$prep_stmt = "SELECT id FROM user where username = ? LIMIT 1";
	$stmt = $mysqli->prepare($prep_stmt);
	
	if ($stmt) {
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows == 1) {
			$error_msg .= 'A user with this username already exists. ';
		}
		$stmt->close();
	} else {
		$stmt->close();
	}
	
	if (empty($error_msg)) {
		// Create random salt
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		$password = hash('sha512', $password . $random_salt);
		
		if ($insert_stmt = $mysqli->prepare("INSERT INTO user (username, email, password, salt) VALUES (?, ?, ?, ?)")) {
			$insert_stmt->bind_param('ssss', $username, $email, $password, $random_salt);
			
			if (!$insert_stmt->execute()) {
				header('Location: ../error.php?err=2');
			}
		}
		header('Location: ./register_success.php');
	}
}
		