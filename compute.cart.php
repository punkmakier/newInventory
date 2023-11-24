<?php

#====================================
# Autoloads functions and connection
#====================================
include "config/load.php";

$sql = safe_query("SELECT * FROM cart a INNER JOIN products b ON b.ItemCode=a.Items");
while ($rw = mysqli_fetch_assoc($sql)) {
	$subTotal += $rw['Price'];
	$items .= $and.$rw['ID'];
	$and = "~";
}
$totalAmount = $subTotal;
?>
<input type="hidden" id="totalamount" value="<?=$totalAmount?>">
<input type="hidden" id="allItems" value="<?=$items?>">
<div class="row mb-3" style="border-bottom: 1px solid #ccc;">
	<div class="col-lg-6">
		<h4><b>Sub-total</b></h4>
	</div>
	<div class="col-lg-6" align="right">
		<h4><?=number_format($subTotal,2)?></h4>
	</div>
</div>
<div class="row mb-3">
	<div class="col-lg-6">
		<h4>Discount</h4>
		<input type="number" name="percent" id="discount" min=0 max=100 class="form-control" placeholder="Input Discount in %" onchange='getTotalAmountWithDiscount(this.value)' oninput="this.value = Math.abs(this.value)" style="width: 80px;display:inline-block" value=0> <font class="fs-4">%</font>
	</div>
	<div class="col-lg-6" align="right">
		<h4 id="discount-amount-here">0</h4>
	</div>
</div>
<div class="row mb-3" style="border-bottom: 1px solid #ccc;">
	<div class="col-lg-6">
		<h4><b>Total Amount</b></h4>
	</div>
	<div class="col-lg-6" align="right">
		<h4 id="total-amount-here-2"><?=$totalAmount?></h4>
	</div>
</div>
<div class="row mb-3">
	<div class="col-lg-6">
		<h4>Cash Tendered</h4>
	</div>
	<div class="col-lg-6" align="right">
		<input type="number" id="amount-tendered" min="1" class="form-control" style="height: 50px;text-align: right;" onchange="getChange()">
	</div>
</div>
<div class="row">
	<div class="col-lg-6">
		<h4>Change</h4>
	</div>
	<div class="col-lg-6" align="right">
		<h5 id="change-here"></h5>
	</div>
</div>
<script type="text/javascript">
	function getChange(){
		change = parseFloat($("#amount-tendered").val().replaceAll(',',''))-parseFloat($("#total-amount-here-2").html().replaceAll(',',''));
		if($("#amount-tendered").val()==""){
			return false;
		}

		$("#change-here").html(addCommas(change.toFixed(2)));
	}
	function getTotalAmountWithDiscount(value){
		if(parseFloat(value) < 0 || parseFloat(value) > 100){
			alert("Invalid discount %");
			$("#discount").val('');
			return false;
		}
		$("#discount-amount-here").html((parseFloat($("#totalamount").val().replaceAll(',',''))*(parseFloat(value.replaceAll(',',''))/100)).toFixed(2));
		computeLoop();
		if($("#amount-tendered").val() != "")getChange();
	}
	function computeLoop(){
		$("#total-amount-here-2").html((parseFloat($("#totalamount").val().replaceAll(',',''))-$("#discount-amount-here").html()).toFixed(2));
	}
</script>