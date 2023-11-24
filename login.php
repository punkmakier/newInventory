<?php
$returnLog = $_POST['auth'];
if($_POST['auth']){
	if($returnLog == 5){
		$alertmsg = "Incorrect username and password.";
	}else if($returnLog == 2){
		$alertmsg = "User Account status is inactive.";
	}

	$alert = "<div class='alert alert-warning' role='alert'>
				$alertmsg
			</div>";
}


?>
<div class="rectangle"></div>
<form action="process.login.php" method="post">
	<div class="row d-flex justify-content-end mt-5">
		<div class="col-lg-8" align="center">
			<img src="img/logo2.jpg" class="login-logo" width="70%" style="position: relative;">
		</div>
		<div class="col-lg-4">
			<div class="login-form">
				<p><center><h2>Login Panel</h2></center></p>
				<p><center><h5>Inventory Management System</h5></center></p>
				<?= $alert ?>
				<label class="control-label">Username</label>
				<input type="text" name="txtUser" class="form-control" autocomplete="off" required>
				<label class="control-label">Password</label>
				<input type="password" name="txtPass" class="form-control" autocomplete="off" required>
				<div align="right">
					<button type="submit" class="btn btn-success mt-3 mb-3">Login</button>
				</div>
			</div>
		</div>
	</div>
</form>