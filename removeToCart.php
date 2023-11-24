<?php

// Autoloads functions and connection
include "config/load.php";
$value = $_POST['val'];

safe_query("DELETE FROM cart WHERE Items = '$value'");