<?php

// Autoloads functions and connection
include "config/load.php";
$value = $_POST['val'];

safe_query("INSERT INTO cart (Items) VALUES ('$value')");