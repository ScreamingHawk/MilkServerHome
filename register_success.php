<?php 
include $_SERVER['DOCUMENT_ROOT'].'includes/header.php'; 
?>

<div class="jumbotron">
	<div class="container">
		<h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
		<p>We hope you enjoy your stay. You can now return to the <a href="/">home page</a> and go about your business.</p>
	</div>
</div>

<?php 
include $_SERVER['DOCUMENT_ROOT'].'includes/footer.php'; 
?>