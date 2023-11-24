<?php

// Autoloads functions and connection
include "config/load.php";

$sql = safe_query("SELECT * FROM itemseqno");

if($rw=mysqli_fetch_assoc($sql)){
	$code = $rw['seqno'];
}else{
	$code = 1;
	safe_query("INSERT INTO itemseqno (seqno) values ($code)");
}
echo "IT".sprintf("%05d",$code);