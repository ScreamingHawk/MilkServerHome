<?php include $_SERVER['DOCUMENT_ROOT'].'includes/header.php'; ?>

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
					</ul>
					<strong>Coming Features</strong>
					<ul>
						<li>Uploading files</li>
						<li>User managed files</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-3 hidden-xs hidden-sm">
		</div>
	</div>
</div>

<?php 
include $_SERVER['DOCUMENT_ROOT'].'includes/footer.php'; 
?>