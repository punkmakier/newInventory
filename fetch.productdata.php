<?php

// Autoloads functions and connection
include "config/load.php";
$value = $_POST['val'];

$sql = safe_query("SELECT * FROM products a LEFT JOIN cart c ON c.Items = a.ItemCode WHERE ItemCode='$value' AND c.Items IS NULL");
if ($rw = mysqli_fetch_assoc($sql)) {
	$result = "{$rw['ID']}*{$rw['ItemCode']}*{$rw['ItemName']}*{$rw['Price']}";
}
echo $result;