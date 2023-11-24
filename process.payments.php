<?php

#====================================
# Autoloads functions and connection
#====================================
include "config/load.php";

// if($_POST['items'] && false){
// 	$items = explode("~", $_POST['items']);
// 	$ornumber = generateORNo();
// 	$amtTendered = str_replace(",", "", $_POST['amtTendered']);
// 	foreach ($items as $value) {
// 		list($itemCode,$price) = explode('*',$value);
// 		$price = str_replace(",", "", $price);
// 		$amountPaid = $price*$quantity;
// 		safe_query("INSERT INTO paymentstrail (ItemCode,AmountPaid,AmountTendered,ORNo,TransID,UserID) VALUES ('$itemCode','$amountPaid','$amtTendered','$ornumber','{$_POST['transid']}','{$_SESSION['user']}')");
// 		$overallPrice += $price;
// 	}
// 	$change = $amtTendered - $overallPrice;
// 	echo $ornumber."~".$change;
// }

if ($_POST['items']) {
	$items = explode("~", $_POST['items']);
	$discount = $_POST['discount'];
	$ornumber = generateORNo();
	$amtTendered = str_replace(",", "", $_POST['amtTendered']);
	foreach ($items as $value) {
		// echo $value;
		$amountPaid = $products->getItemPrice($value);
		$amountPaid = $amountPaid - ($amountPaid*($discount/100));
		safe_query("INSERT INTO paymentstrail (ItemCode,AmountPaid,AmountTendered,ORNo,UserID,Discount) VALUES ('$value','$amountPaid','$amtTendered','$ornumber','{$_SESSION['user']}','$discount')");
		safe_query("TRUNCATE cart");
		$overallPrice += $amountPaid;
	}
	$change = $amtTendered - $overallPrice;
	echo $ornumber."~".$change;
}