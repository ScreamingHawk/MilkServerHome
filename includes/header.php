<?php
$logged = 'out';
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Standen Links</title>
		<meta name="description" content="Standen Links Home">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="/css/main.css">

		<script src="/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/index.php">Standen Links</a>
					<?php if (isset($breadcrumb)): ?>
						<a class="navbar-brand" style="margin-left: -25px;" href="<?php echo $breadcrumblink; ?>">
							&raquo; <?php echo $breadcrumb; ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="navbar-collapse collapse">
					<?php if ($logged == 'in') : ?>
						<form class="navbar-form navbar-right" role="form" action="/logout.php" method="POST">
							<div class="form-group">
								<p class="navbar-text navbar-right visible-xs">Logged in as <?php echo $_SESSION['username']; ?></p>
								<button type="submit" class="btn btn-primary">Sign out</button>
							</div>
						</form>
						<p class="navbar-text navbar-right hidden-xs">Logged in as <?php echo $_SESSION['username']; ?></p>
					<?php else : ?>
						<form class="navbar-form navbar-right" role="form" action="/process_login.php" method="POST">
							<div class="form-group">
								<input type="text" placeholder="Username / Email" name="email" class="form-control">
							</div>
							<div class="form-group">
								<input type="password" placeholder="Password" name="password" class="form-control">
							</div>
							<button type="submit" class="btn btn-success" onclick="formhash(this.form, this.form.password);">Sign in</button>
							<?php if (!isset($header_block_register)) : ?>
								<a class="btn btn-primary narbar-link" href="/register.php">Register</a>
							<?php endif; ?>
						</form>
					<?php endif; ?>
				</div>
			</div>
		</div>