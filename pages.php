<?php

$sql = safe_query("SELECT * FROM modules WHERE Path = '$pathLink' and Module = '{$_SESSION['userlevel']}' AND Visible='1'");
if($rw=mysqli_fetch_assoc($sql)){
	include $path."/".$rw['Link'];
}else{
	if($pathLink)echo "Page not found";
	else header("Location: index.php?dashboard");
}

?>

<div id="popupbox"></div>

<script type="text/javascript">
	$(".dt-active").DataTable({
		bSort:false,
		autoWidth:false,
	});
</script>