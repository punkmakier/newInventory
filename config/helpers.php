<?php

foreach ($_POST as $key => $value) {
	$_POST[mysqli_escape_string($conn,$key)] = mysqli_escape_string($conn,$value);
}
foreach ($_GET as $key => $value) {
	$_GET[mysqli_escape_string($conn,$key)] = mysqli_escape_string($conn,$value);
}

if(stripos($_SERVER['REQUEST_URI'], 'index.php') === false && !$_SERVER['HTTP_REFERER']){
	header("Location: index.php");
}
