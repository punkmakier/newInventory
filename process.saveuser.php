<?php

// Autoloads functions and connection
include "config/load.php";

if(isset($_POST['idx'])){
	safe_query("UPDATE users SET username='{$_POST['username']}', name='{$_POST['name']}', user_level='{$_POST['user_level']}',status='{$_POST['status']}' WHERE id='{$_POST['userid']}'");
	if($_POST['password']){
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		safe_query("UPDATE users SET password='{$password}' WHERE username='{$_POST['username']}'");
	}
	$x = 1;

}else{
	$sql = safe_query("SELECT * FROM users WHERE username='{$_POST['username']}'");
	if(mysqli_num_rows($sql) == 0){
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		safe_query("INSERT INTO users (username,name,password,user_level,status) VALUES ('{$_POST['username']}','{$_POST['name']}','{$password}','{$_POST['user_level']}','{$_POST['status']}')");
		$x = 1;
	}else{
		$x = 3;
	}
}
echo $x;