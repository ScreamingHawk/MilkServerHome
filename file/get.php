<?php 
require $_SERVER['DOCUMENT_ROOT'].'lib/aws/aws-autoloader.php';

$fileBucket = 'milkserver-filestore';
$filename = $_GET['file'];
$fileStoragePrefix = 'public/';

if (isset($filename)){
	try{
		$s3Client = Aws\S3\S3Client::factory(array(
				'key' => $_SERVER['AWS_ACCESS_KEY_ID'],
				'secret' => $_SERVER['AWS_SECRET_KEY']
		));

		$f = $s3Client->getObject(array(
				'Bucket' => $fileBucket,
				'Key' => ($fileStoragePrefix . $filename)
		));

		if (!$f['ContentLength']){
			$get_error_msg = "There was a problem accessing your file. ";
		} else {
			header('Content-Type: ' . $f['ContentType']);
			header('Content-Length: ' . $f['ContentLength']);
			$f['Body']->rewind();
			while ($data = $f['Body']->read(1024)){
				echo $data;
			}
			// Success
			exit();
		}
	} catch (Exception $e){
		$get_error_msg = "There was a problem accessing your file. ";
	}
} else {
	$get_info_msg = "Please provide a file name in your request. e.g. get.php?file=YourFileName.txt ";
}

include $_SERVER['DOCUMENT_ROOT'].'file/index.php';