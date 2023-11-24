<?php
// Autoloads functions and connection
include "config/load.php";
// print_r($_POST);

$sql = safe_query("SELECT * FROM users WHERE username = '{$_POST['txtUser']}'");
if(mysqli_num_rows($sql) > 0){
	if($rw = mysqli_fetch_assoc($sql)){
		if($rw['status'] != '1'){
			$return = 2;
		}else{
			if(password_verify($_POST['txtPass'], $rw['password'])){
				safe_query("INSERT INTO logtrail (username) VALUES ('{$_POST['txtUser']}')");
				$return = 1;
				$_SESSION['user']= $rw['username'];
				$_SESSION['userlevel']= $rw['user_level'];
				$_SESSION['fullname']= $rw['name'];
			}else{
				$return = 5;
			}
		}
	}else{
		$return = 5;
	}
}else{
	$return = 5;
}



if($return == '1'){
	if($_SESSION['userlevel'] == 1) header("Location: index.php?dashboard");
	if($_SESSION['userlevel'] == 3) header("Location: index.php?payment");
}else{
	
	echo "
	<body>
		<form id='frmLog' method='post' action='index.php'>
			<input type='hidden' name='auth' value='${return}'>
		</form>
	</body>
	<script type='text/javascript'>
		document.getElementById('frmLog').submit();
	</script>
	";
}