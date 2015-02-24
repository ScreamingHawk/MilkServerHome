<?php
require_once $_SERVER['DOCUMENT_ROOT'].'includes/db_connect.php';

if ($mysqli->connect_error){
	die("Connection failed: " . $mysqli->connect_error);
}

$DEBUG = false;

// Create user table
if ($res = $mysqli->query("SHOW TABLES LIKE 'user'")){
	if ($res->num_rows > 0){
		if ($DEBUG){
			echo "Table 'user' already exists. ";
		}
	} else {
		$sql = "CREATE TABLE IF NOT EXISTS user (
			id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			username varchar(30) NOT NULL,
			email varchar(50) NOT NULL,
			password char(128) NOT NULL,
			salt char(128) NOT NULL
			)";
		if ($mysqli->query($sql) === TRUE){
			if ($DEBUG){
				echo "Created table 'users' successfully. ";
			}
		} else {
			if ($DEBUG){
				echo "Error creating table 'users': " . $mysqli->error;
			}
		}
	}
} else {
	if ($DEBUG){
		echo "Table 'user' like test failed. ";
	}
}

// Create user login attempts table
if ($res = $mysqli->query("SHOW TABLES LIKE 'login_attempts'")){
	if ($res->num_rows > 0){
		if ($DEBUG){
			echo "Table 'login_attempts' already exists. ";
		}
	} else {
		$sql = "CREATE TABLE IF NOT EXISTS login_attempts (
			user_id int(11) NOT NULL,
			time varchar(30) NOT NULL
			)";
		if ($mysqli->query($sql) === TRUE){
			if ($DEBUG){
				echo "Created table 'login_attempts' successfully. ";
			}
		} else {
			if ($DEBUG){
				echo "Error creating table 'login_attempts': " . $mysqli->error;
			}
		}
	}
} else {
	if ($DEBUG){
		echo "Table 'login_attempts' like test failed. ";
	}
}

if ($DEBUG){
	echo "Database creation completed. ";
}