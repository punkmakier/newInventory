<?php
switch ($_SESSION['userlevel']) {
	case '1':
		$path = "admin";
		break;
	case '2':
		$path = "manager";
		break;
	case '3':
		$path = "cashier";
		break;
}
foreach($_GET as $key => $value){
	$pathLink = $key;
}
if($pathLink == ""){
	if($_SESSION['userlevel'] == 1) {
		header("Location: index.php?dashboard");
		$homepage = "dashboard";
	}
	if($_SESSION['userlevel'] == 3) {
		header("Location: index.php?payment");
		$homepage = "payment";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=getPageTitle()?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
	<script src="js/jquery-3.7.0.min.js"></script>
	<!-- Datatables -->
	<link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
	<script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
	<?php


				if($_SESSION['user']){

					?>
<!--Main Navigation-->
<header>
  <!-- Sidebar -->
  <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white" >
    <div class="position-sticky">
      <div class="list-group list-group-flush">
        <ul class="side-bar-nav-links">
			<?php
			$sql = safe_query("SELECT * FROM modules WHERE Module = '{$_SESSION['userlevel']}' AND Visible='1'");
			while ($rw=mysqli_fetch_assoc($sql)) {
				if($pathLink == $rw['path']){
					$currModule = $rw['Description'];
				}
				echo "<li class='".($pathLink == $rw['path'] ? "active":"")."'><div style='width:20%;display:inline-block;vertical-align:middle'><i class='bi bi-{$rw['icons']}' style='font-size:24px'></i></div>&nbsp;<div style='width:75%;display:inline-block;vertical-align:middle'><a class='dropdown-item ".($pathLink == $rw['path'] ? "active":"")."' href='index.php?{$rw['path']}' style='text-align:center'>{$rw['Description']}</a></div></li>";
			}
			?>
		</ul>

      </div>
  </div>
  <form class="text-light" role="search" action="logout.php" style="position:absolute;bottom:5px;padding-left: 15px;font-size: 20px;line-height: 1.8;cursor: pointer;padding-right: 57px;text-align: center;width: 100%;" onclick="$(this).submit();">
  	<img src="img/icons/logout.png" width="20px" class="float-start" style="filter: invert(1);margin-top:10px;">&nbsp;Log-out
  </form>
  </nav>
  <!-- Sidebar -->
</header>
<!--Main Navigation-->
	<nav class="navbar fixed-top navbar-expand-lg" style="z-index: 600;background-color: #bbb;">
		<div class="container-fluid">
			<!-- <button
			class="navbar-toggler"
			type="button"
			data-mdb-toggle="collapse"
			data-mdb-target="#sidebarMenu"
			aria-controls="sidebarMenu"
			aria-expanded="false"
			aria-label="Toggle navigation"
			>
			<i class="bi bi-list"></i>
		</button> -->
			<img src="img/logo2.jpg" height="40px" style="margin-right: 5px;">
			<a class="navbar-brand" href="index.php?<?=$homepage?>">Inventory</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<?php


				if($_SESSION['user']){

					?>
						<div id="sheesh">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<!-- <li class="nav-item">
							<a class="nav-link" aria-current="page" href="#">Dashboard</a>
						</li> -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								Modules
							</a>
							<ul class="dropdown-menu">
								<?php
								$sql = safe_query("SELECT * FROM modules WHERE Module = '{$_SESSION['userlevel']}' AND Visible='1'");
								while ($rw=mysqli_fetch_assoc($sql)) {
									if($pathLink == $rw['path']){
										$currModule = $rw['Description'];
									}
									echo "<li><a class='dropdown-item ".($pathLink == $rw['path'] ? "active":"")."' href='index.php?{$rw['path']}' >{$rw['Description']}</a></li>";
								}
								?>
							</ul>
						</li>

						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="#"><?=ucwords($path)." - ".$currModule?></a>
						</li>
					</ul>
				<form class="d-flex" role="search" action="logout.php" onclick="$(this).submit();">
					<button class="btn btn-outline-secondary" type="submit" title="Log-out"><i class="bi bi-box-arrow-right"></i></button>
				</form>
					</div>
			<?php } ?>
			</div>
			<div style="float: right;">
				<img src="img/icons/profile-icon.png" height="40px" style="vertical-align: -12px;">
				<font class="fs-5"><?=$_SESSION['fullname']?></font>
			</div>
		</div>
	</nav>


 

		
<!--Main layout-->
<main>
			<?php } ?>
		
  <div class="container pt-4">
<!--Main layout-->