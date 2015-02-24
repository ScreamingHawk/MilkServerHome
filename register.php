<?php
include_once $_SERVER['DOCUMENT_ROOT'].'includes/register.php';
include_once $_SERVER['DOCUMENT_ROOT'].'includes/header.php';
?>

<div class="container">
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-md-6">
			<h1>Join <?php echo $SITE_NAME; ?></h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<form role="form" action="register.php" method="POST" name="registration_form">
						<div class="form-group">
							<label for="username">Username</label>
							<input class="form-control" placeholder="Enter username" type="text" name="username" id="username" required="required" />
						</div>
						<div class="form-group">
							<label for="email">Email Address</label>
							<input class="form-control" placeholder="Enter email" type="email" name="email" id="email" required="required" />
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input class="form-control" placeholder="Password" type="password" name="password" id="password" required="required" />
						</div>
						<div class="form-group">
							<label for="confpassword">Confirm Password</label>
							<input class="form-control" placeholder="Confirm password" type="password" name="confpassword" id="confpassword" required="required" />
						</div>
						
						<button type="button" class="btn btn-success" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confpassword);">Register</button>
					</form>
				</div>
				<div class="panel-footer">
					<ul>
						<li>Usernames may contain only digits, upper and lower case letters and underscores</li>
						<li>Emails must have a valid email format</li>
						<li>Passwords must be at least 6 characters long</li>
						<li>Your password and confirmation must match exactly</li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Trust issues?</h3>
				</div>
				<div class="panel-body">
					<ul>
						<li>Your password is encrypted client side</li>
						<li>Passwords are encrypted again for storage with a salted hash</li>
						<li>I won't even spam your email address</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
	<p>Return to the <a href="index.php">home page</a>.</p>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'].'includes/footer.php'; ?>