<?php


function dbconnect($server = 'localhost',$user='root',$pass='',$database='inventory'){
	$myLink = mysqli_connect($server,$user,$pass,$database);
	if(!$myLink){
		echo mysqli_connect_errno();
	}else{
		// echo "Connected!";
	}
	return $myLink;
}

$conn = dbconnect();
function safe_query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "<b>Encountered Error:</b> ". mysqli_error($conn)."<br><b>QUERY</b>:".$query;
	}
	return $result;
}