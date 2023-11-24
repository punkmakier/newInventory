<?php

// Autoloads functions and connection
include "config/load.php";

if($_POST['isDelete']){
	safe_query("DELETE FROM itemtype WHERE ID='{$_POST['id']}'");
	die;
}
if($_POST['id']){
	safe_query("UPDATE itemtype SET Description='{$_POST['itemtype']}' WHERE ID='{$_POST['id']}'");
	$x = 1;

}else{
	$sql = safe_query("SELECT * FROM itemtype WHERE Description='{$_POST['itemtype']}'");
	if(mysqli_num_rows($sql) == 0){
		safe_query("INSERT INTO itemtype (Description) VALUES ('{$_POST['itemtype']}')");
		$x = 1;
	}else{
		$x = 3;
	}
}
echo $x;