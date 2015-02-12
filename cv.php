<?php 
require $_SERVER['DOCUMENT_ROOT'].'/lib/aws/aws-autoloader.php';

$cvBucket = 'milkserver-filestore';
$cvLocation = 'MichaelStandenCV.pdf';
$cvFilename = 'MichaelStandenCV.pdf';

try{
	$s3Client = Aws\S3\S3Client::factory(array(
			'key' => $_SERVER['AWS_ACCESS_KEY_ID'],
			'secret' => $_SERVER['AWS_SECRET_KEY']
	));

	$cv = $s3Client->getObject(array(
			'Bucket' => $cvBucket,
			'Key' => $cvLocation
	));

	if (!$cv['ContentLength']){
		header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
	} else {
		header('Content-Type: ' . $cv['ContentType']);
		header('Content-Length: ' . $cv['ContentLength']);
		$cv['Body']->rewind();
		while ($data = $cv['Body']->read(1024)){
			echo $data;
		}
	}
} catch (Exception $e){
	echo 'Exception: ' . $e->getMessage();
}