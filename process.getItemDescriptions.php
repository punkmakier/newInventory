<?php

#====================================
# Autoloads functions and connection
#====================================
include "config/load.php";

$sql = safe_query("SELECT * FROM products WHERE ID ='{$_POST['itmID']}'");
if($rw=mysqli_fetch_assoc($sql)){
	$return = $rw['Price'];
}
echo $return;