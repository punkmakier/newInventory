<?php

// Autoloads functions and connection
include "config/load.php";

$sql = safe_query("SELECT pr.ItemCode,it.Description,1 as totals FROM paymentstrail pt
					INNER JOIN products pr ON pr.ID = pt.ItemCode
					INNER JOIN itemtype it ON it.ID = pr.ItemType 
					WHERE IFNULL(pt.isCancelled,'') = '' ORDER BY totals DESC");

while ($rw = mysqli_fetch_assoc($sql)) {
	// check if damaged
	$sqls = safe_query("SELECT 1 FROM transactions WHERE ItemCode ='{$rw['ItemCode']}' AND Action='1'");
	if(mysqli_num_rows($sqls)>0)continue;
	$chart[$rw['Description']] += $rw['totals'];
}
arsort($chart);
$ovrallCount=0;
$Count=0;
$firstTime = true;
foreach ($chart as $itemtypes => $totals) {
	if(!$highestNum)$highestNum = $totals;
	$ovrallCount++;
	if($currentNumber > $totals || $firstTime)$Count++;
	$firstTime = false;
	$currentNumber = $totals;
	$color = ($ovrallCount%2 ? "#a8bbdf":"#92deba");
	?>

	<div style="background: <?=$color?>;width: <?=(($totals/$highestNum)*100)?>%;display:inline-block;margin:2px;border-radius: 10px;padding:3px 10px;white-space: nowrap;">
		#<?=$Count?> <?=$itemtypes."-".$totals?>
	</div>
	<br>

	<?php

}
?>