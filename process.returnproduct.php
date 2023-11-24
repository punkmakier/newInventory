<?php 
include "config/load.php";

$txtICode = $_POST['txtICode'];
$txtIDesc = $_POST['txtIDesc'];
$txtIPrice = $_POST['txtIPrice'];
$dateSubmit = $_POST['dateSubmit'];
$reason = $_POST['reason'];




$sql = "INSERT INTO transactions (ItemCode,Action,reason, return_date) VALUES ('$txtICode','1','$reason','$dateSubmit')";
$query = mysqli_query($conn, $sql);

$sql1 = "UPDATE paymentstrail a LEFT JOIN products b ON b.ID=a.ItemCode SET a.isCancelled = '1' WHERE b.ItemCode='$txtICode'";
$query1 = mysqli_query($conn, $sql1);

if($query && $query1){
    echo "Success";
}


?>