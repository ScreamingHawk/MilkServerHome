<?php 
require $_SERVER['DOCUMENT_ROOT'].'lib/aws/aws-autoloader.php';


class s3 {
	public static $commonBucketName = 'milkserver-filestore';
	public static $fileStoragePublicPrefix = 'public/';
	public static $userBucketPostfix = '-filestore';

	private $error_msg = '';
	private $info_msg = '';
	private $error = null;

	private function createS3Client(){
		return Aws\S3\S3Client::factory(array(
				'key' => $_SERVER['AWS_ACCESS_KEY_ID'],
				'secret' => $_SERVER['AWS_SECRET_KEY']
		));
	}

	public function getPublicFile($filename){
		return $this->getPrefixedFile($filename, self::$fileStoragePublicPrefix, self::$commonBucketName);
	}

	public function getUserFile($filename, $username){
		return $this->getPrefixedFile($filename, '', ($username . self::$userBucketPostfix));
	}
	
	public function sendPublicFile($filename){
		return $this->sendFile($this->getPublicFile($filename));
	}
	
	public function sendUserFile($filename, $username){
		return $this->sendFile($this->getUserFile($filename, $username));
	}

	public function getPrefixedFile($filename, $filePrefix, $bucketName){
		try{
			$s3Client = $this->createS3Client();
			
			$this->info_msg = "File key: " . ($filePrefix . $filename) . " in bucket " . $bucketName;
			
			$f = $s3Client->getObject(array(
					'Bucket' => $bucketName,
					'Key' => ($filePrefix . $filename)
			));
			
			if (!$f['ContentLength']){
				$this->error_msg = "There was a problem accessing your file. ";
			} else {
				return $f;
			}
		} catch (Exception $e){
			$this->error_msg = "There was a problem accessing your file. ";
			$this->error = $e;
		}
	}

	public function sendFile($f){
		if (isset($f)){
			header('Content-Type: ' . $f['ContentType']);
			header('Content-Length: ' . $f['ContentLength']);
			$f['Body']->rewind();
			while ($data = $f['Body']->read(1024)){
				echo $data;
			}
			// Success
			return true;
		}
		// Failed
		return false;
	}

	public function getPublicFileList(){
		try{
			$s3Client = $this->createS3Client();
			return $s3Client->getIterator('ListObjects', array(
					'Bucket' => self::$commonBucketName,
					'Prefix' => self::$fileStoragePublicPrefix
			));
		} catch (Exception $e){
			$this->error_msg = "There was a problem accessing your file. ";
			$this->error = $e;
		}
	}

	public function getUserBucketFileList($username){
		$userBucketName = $username . self::$userBucketPostfix;
		try{
			$s3Client = self::createS3Client();
			// Check bucket exists
			if (!$s3Client->doesBucketExist($userBucketName)){
				// It doesn't, create one
				$s3Client->createBucket(array(
						'Bucket' => ($userBucketName)
				));
			}
			// Get the file list
			return $s3Client->getIterator('ListObjects', array(
					'Bucket' => $userBucketName
			));
		} catch (Exception $e){
			$this->error_msg = "There was a problem accessing your file. ";
			$this->error = $e;
		}
	}
	
	public function getErrorMsg(){
		return $this->error_msg;
	}
	
	public function getInfoMsg(){
		return $this->info_msg;
	}
	
	public function getError(){
		return $this->error;
	}
}


