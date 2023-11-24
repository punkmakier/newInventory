<?php

// Autoloads functions and connection
include "config/load.php";

if($_POST['isDelete']){
	safe_query("DELETE FROM products WHERE ID='{$_POST['id']}'");
	die;
}
if($_POST['idx']){
	safe_query("UPDATE products SET Description='{$_POST['desc']}', Price='{$_POST['price']}',ItemType='{$_POST['type']}' WHERE ID='{$_POST['idx']}'");
	$x = 1;

}else{
	$sql = safe_query("SELECT * FROM products WHERE ItemCode='{$_POST['code']}'");
	if(mysqli_num_rows($sql) == 0){
		safe_query("INSERT INTO products (ItemCode,Description,Price,ItemType,ItemName,Size) VALUES ('{$_POST['code']}','{$_POST['desc']}','{$_POST['price']}','{$_POST['type']}','{$_POST['name']}','{$_POST['size']}')");
		safe_query("UPDATE itemseqno SET seqno=seqno+1");
		$x = 1;
	}else{
		$x = 3;
	}
}
echo $x;