<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'lib/aws/aws-autoloader.php';

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/db_connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions.php';

sec_session_start();
$skip_sec_session_start = true;

if (isset($_GET['file'])){
	$filename = $_GET['file'];
}
if (isset($_GET['user'])){
	$reqUsername = $_GET['user'];
}

if (isset($filename)){
	require_once $_SERVER['DOCUMENT_ROOT'].'includes/s3.php';
	$s3 = new s3();
	if (isset($reqUsername)){
		// Only allow access if the user supplied is the logged in user
		if ($_SESSION['username'] == $reqUsername){
			if ($s3->sendUserFile($filename, $reqUsername)){
				exit();
			}
		} else {
			$get_error_msg = "You may only access private files of the logged in user. ";
		}
	} else {
		if ($s3->sendPublicFile($filename)){
			exit();
		}
	}
	$get_error_msg = "Sorry, we were unable to retrieve your file. ";
} else {
	$get_info_msg = "Please provide a file name in your request. e.g. get.php?file=YourFileName.txt ";
}

include $_SERVER['DOCUMENT_ROOT'].'file/index.php';