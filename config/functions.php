<?php

session_start();

function getPageTitle(){

	foreach($_GET as $key => $value){
		$pathLink = $key;
	}
	$sql = safe_query("SELECT * FROM modules WHERE Path = '$pathLink' and Module = '{$_SESSION['userlevel']}'");
	if($rw=mysqli_fetch_assoc($sql)){
		return $rw['Description'];
	}else{
		return "Inventory Management System";
	}
}

function getUserLevel($value=""){
	switch ($value) {
		case '1':
			$result = "Admin";
			break;
		case '3':
			$result = "Cashier";
			break;
		
	}
	return $result;
}
function getUserStatus($value=""){
	switch($value){
		case '1':
			$result = "Active";
			break;
		case '0':
			$result = "Inactive";
			break;
	}
	return $result;
}
function generateORNo(){
	$date = date("Ymd");
	$sql = safe_query("SELECT ORNo FROM paymentstrail WHERE ORNo LIKE '$date%' ORDER BY ORNo DESC LIMIT 1");
	if($rw = mysqli_fetch_assoc($sql)){

		$result=$rw['ORNo']+1;
	}else{
		$result=$date.sprintf("%05d",1);
	}
	return $result;
}