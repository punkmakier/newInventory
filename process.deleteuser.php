<?php 

include "config/load.php";
$id = $_POST['uid'];
$sql = "DELETE FROM users WHERE id = '$id'";
$query = mysqli_query($conn, $sql);


if ($query) {
    echo "Success";
}


?>