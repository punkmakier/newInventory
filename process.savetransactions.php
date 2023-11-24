<?php

#====================================
# Autoloads functions and connection
#====================================
include "config/load.php";

$arrayItems = $_POST['items'];
$status = $_POST['stat'];
$arrayItems = explode("~",$arrayItems);
switch ($status) {
	case '1':
		foreach ($arrayItems as $key => $value) {
			safe_query("INSERT INTO transactions (ItemCode,Action) VALUES ('$value','$status')");
		}
		break;
	case '2':
		foreach ($arrayItems as $key => $value) {
			safe_query("INSERT INTO transactions (ItemCode,Action) VALUES ('$value','$status')");
			safe_query("UPDATE paymentstrail a LEFT JOIN products b ON b.ID=a.ItemCode SET a.isCancelled = '1' WHERE b.ItemCode='$value'");
		}
		break;
}