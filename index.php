<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/header.php'; ?>

<div class="jumbotron">
	<div class="container">
		<h1>Hello, world!</h1>
		<p>This is Milk Server. A place for me to dump all the things I'm working on. Hopefully some cool stuff ends up on here.</p>
	</div>
</div>

<div class="container">
	<div class="row js-masonry" data-masonry-options='{"itemSelector": ".masonryitem"}'>
		<div class="col-md-4 masonryitem">
			<div class="thumbnail">
				<div class="caption">
					<h2>File Server</h2>
					<p>A simple file server. </p>
					<p><a class="btn btn-default" href="/file/get.php" role="button">View &raquo;</a></p>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
$requires_masonry = true;
include $_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'; 
?>