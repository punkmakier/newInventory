<?php

// Autoloads functions and connection
include "config/load.php";

$sql = safe_query("SELECT * FROM cart a INNER JOIN products b ON b.ItemCode=a.Items");
while ($rw = mysqli_fetch_assoc($sql)) {
	echo "	<tr>
		<td>{$rw['ItemCode']}</td>
		<td>{$rw['ItemName']}</td>
		<td>".number_format($rw['Price'],2)."</td>
		<td><i class='bi bi-x-circle-fill' onclick='removeToCart(\"{$rw['ItemCode']}\")' style='color:red;cursor:pointer'></i></td>
	</tr>";
	$totalAmount += $rw['Price'];
	$items .= $and.$rw['ID'];
	$and = "~";
}
echo "*".number_format($totalAmount,2)."*$items";