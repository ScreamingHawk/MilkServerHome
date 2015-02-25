<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'includes/sec_session_start.php';
require_once $_SERVER['DOCUMENT_ROOT'].'lib/aws/aws-autoloader.php';
require_once $_SERVER['DOCUMENT_ROOT'].'includes/db_connect.php';
require_once $_SERVER['DOCUMENT_ROOT'].'includes/functions.php';

$file_upload_size_limit = 1000000;

if (!login_check($mysqli)){
	$file_error_msg = "You must be logged in to upload a file. ";
} else if (!isset($_FILES['file']) || !isset($_FILES['file']['size']) || !isset($_FILES['file']['name'])){
	$file_error_msg = "No file was detected. ";
} else if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])){
	$file_error_msg = "Multiple files detected. Please only upload one file at a time. ";
} else {
	try{
		// Test error
		switch($_FILES['file']['error']){
			case UPLOAD_ERR_NO_FILE:
				throw new RuntimeException("No file was detected. ");
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				throw new RuntimeException("Exceeded file size limit. ");
			default:
				throw new RuntimeException("Unknown errors with your file upload. ");
		}
		
		if ($_FILES['file']['size'] > $file_upload_size_limit){
			throw new RuntimeException("Exceeded file size limit. ");
		} else if ($_FILES['file']['size'] == 0){
			throw new RuntimeException("No file was detected. ");
		}
		
		// Move the file to s3
		require_once $_SERVER['DOCUMENT_ROOT'].'includes/s3.php';
		$s3 = new s3();
		$s3->putUserFile($_FILES['file']['tmp_name'], $_FILES['file']['name'], $_SESSION['username']);
		
		// Set error messages for display
		if ($s3->getErrorMsg() !== null && !empty($s3->getErrorMsg())){
			$file_error_msg = $s3->getErrorMsg();
		}
		if ($s3->getInfoMsg() !== null && !empty($s3->getInfoMsg())){
			$file_info_msg = $s3->getInfoMsg();
		}
	} catch (RuntimeException $e){
		$file_error_msg = $e->getMessage();
	}
}

if ($s3->getError() !== null){
	$file_error_msg = $s3->getError()->getMessage();
}

include $_SERVER['DOCUMENT_ROOT'].'file/index.php';