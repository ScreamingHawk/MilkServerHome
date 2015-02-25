<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'includes/sec_session_start.php';
require_once $_SERVER['DOCUMENT_ROOT'].'lib/aws/aws-autoloader.php';

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
			$file_error_msg = "You may only access private files of the logged in user. ";
		}
	} else {
		if ($s3->sendPublicFile($filename)){
			exit();
		}
	}
	// Set error messages for display
	if ($s3->getErrorMsg() !== null && !empty($s3->getErrorMsg())){
		$file_error_msg = $s3->getErrorMsg();
	}
	if ($s3->getInfoMsg() !== null && !empty($s3->getInfoMsg())){
		$file_info_msg = $s3->getInfoMsg();
	}
} else {
	$file_info_msg = "Please provide a file name in your request. e.g. get.php?file=YourFileName.txt ";
}

include $_SERVER['DOCUMENT_ROOT'].'file/index.php';