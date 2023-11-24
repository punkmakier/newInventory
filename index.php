<?php

#====================================
# Autoloads functions and connection
#====================================
include "config/load.php";

#====================================
# Display Header
#====================================
include "templates/header.php";


#====================================
# Display Body / Page
#====================================
if($_SESSION['user']){
	include "pages.php";
}else{
	include "login.php";
}

#====================================
# Display Footer
#====================================
include "templates/footer.php"; 