<?php

// -----------------------------------------------------------------------
// DEFINE SEPERATOR ALIASES
// -----------------------------------------------------------------------
define("URL_SEPARATOR", '/');

define("DS", DIRECTORY_SEPARATOR);

// -----------------------------------------------------------------------
// DEFINE ROOT PATHS
// -----------------------------------------------------------------------
defined('SITE_ROOT')? null: define('SITE_ROOT', realpath(dirname(__FILE__)));
define("LIB_PATH_INC", SITE_ROOT.DS);
ini_set('display_errors', 0);

include_once LIB_PATH_INC."db.php";
include_once LIB_PATH_INC."helpers.php";
include_once LIB_PATH_INC."functions.php";
include_once LIB_PATH_INC."class.product.php";
include_once LIB_PATH_INC."class.users.php";
include_once LIB_PATH_INC."class.transactions.php";