<?php 

include $_SERVER['DOCUMENT_ROOT'].'includes/header.php'; 
require_once $_SERVER['DOCUMENT_ROOT'].'includes/s3.php'; 

$s3 = new s3();

?>

<div class="jumbotron">
	<div class="container">
		<h1>File Server</h1>
		<p>A simple file server. </p>
	</div>
</div>

<div class="container">

	<?php if (isset($get_error_msg)) : ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Error!</strong>
			<?php echo $get_error_msg; ?>
		</div>
	<?php endif; ?>

	<?php if (isset($get_info_msg)) : ?>
		<div class="alert alert-info alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Oops!</strong>
			<?php echo $get_info_msg; ?>
		</div>
	<?php endif; ?>
	
	<div class="row">
		<div class="col-md-3 hidden-xs hidden-sm">
		</div>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3>File Server State</h3>
				</div>
				<div class="panel-body">
					The file server is currently an in progress experiment for testing the AWS SDK for PHP when integrating S3 management from within EC2 instances. 
					<br/>
					<br/>
					<strong>Current Features</strong>
					<ul>
						<li><a href="/file/get.php">Access to files</a> is available by passing a file param. </li>
						<li>User file access using the above while passing a user param. Note: Currently must be the logged in user. </li>
					</ul>
					<strong>Coming Features</strong>
					<ul>
						<li>Uploading files</li>
						<li>User file management</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3 hidden-xs hidden-sm">
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3>Public Uploads</h3>
				</div>
				<div class="panel-body">
					<?php 
						$objs = $s3->getPublicFileList();
						if (!isset($objs) || empty($objs)):
						?>
						There are currently no publicly uploaded files. 
					<?php else : ?>
						This is a list of all the publicly uploaded files. 
						<ul>
							<?php 
								foreach ($objs as $obj): 
									if ($obj['Size'] > 0) : 
									?>
									<li>
										<a href="/file/get.php?file=<?php echo str_replace(s3::$fileStoragePublicPrefix, "", $obj['Key']); ?>">
											<?php echo str_replace(s3::$fileStoragePublicPrefix, "", $obj['Key']); ?>
										</a>
										(<?php echo human_filesize($obj['Size']); ?>)
									</li>
								<?php
								endif;
							endforeach; 
							?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php if ($logged == 'in') : ?>
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3>Your Uploads</h3>
					</div>
					<div class="panel-body">
						<?php 
							$objs = $s3->getUserBucketFileList($_SESSION['username']);
							$valid = false;
							foreach ($objs as $obj){ 
								if ($obj['Size'] > 0){ 
									$valid = true;
								}
							}
							$objs->rewind();
							if (!$valid): 
							?>
							You currently don't have any uploaded files. 
						<?php else : ?>
							This is a list of all the files you have listed under your account. 
							<ul>
								<?php 
									foreach ($objs as $obj): 
										if ($obj['Size'] > 0) : 
										?>
										<li>
											<a href="/file/get.php?file=<?php echo $obj['Key']; ?>&user=<?php echo $_SESSION['username']; ?>">
												<?php echo $obj['Key']; ?>
											</a>
											(<?php echo human_filesize($obj['Size']); ?>)
										</li>
									<?php
									endif;
								endforeach; 
								?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php else: ?>
			<div class="col-md-6 hidden-sm hidden-xs">
			</div>
		<?php endif; ?>
	</div>
</div>

<?php 
include $_SERVER['DOCUMENT_ROOT'].'includes/footer.php'; 
?>