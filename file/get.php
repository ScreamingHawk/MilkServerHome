<?php 
require $_SERVER['DOCUMENT_ROOT'].'/lib/aws/aws-autoloader.php';

$fileBucket = 'milkserver-filestore';
$filename = $_GET['file'];

if (isset($filename)){
	try{
		$s3Client = Aws\S3\S3Client::factory(array(
				'key' => $_SERVER['AWS_ACCESS_KEY_ID'],
				'secret' => $_SERVER['AWS_SECRET_KEY']
		));

		$f = $s3Client->getObject(array(
				'Bucket' => $fileBucket,
				'Key' => $filename
		));

		if (!$f['ContentLength']){
			header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
		} else {
			header('Content-Type: ' . $f['ContentType']);
			header('Content-Length: ' . $f['ContentLength']);
			$f['Body']->rewind();
			while ($data = $f['Body']->read(1024)){
				echo $data;
			}
		}
		// Success
		exit();
	} catch (Exception $e){
		$error_msg = $e->getMessage();
	}
} else {
	echo "No file to get";
}